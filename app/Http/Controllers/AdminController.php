<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Region;
use App\Models\Langue;
use App\Models\Contenu;
use App\Models\Commentaire;
use App\Models\Media;
use App\Models\TypeContenu;

class AdminController extends Controller
{
    /**
     * Dashboard principal de l'admin
     */
    public function index()
    {
        $user = Auth::user();
        
        // Compter les statistiques
        $users_count = User::count();
        $regions_count = class_exists('App\Models\Region') ? Region::count() : 0;
        $langues_count = class_exists('App\Models\Langue') ? Langue::count() : 0;
        $contenus_count = class_exists('App\Models\Contenu') ? Contenu::where('statut', '!=', 'supprime')->count() : 0;
        $commentaires_count = class_exists('App\Models\Commentaire') ? Commentaire::count() : 0;
        
        // Récupérer les derniers contenus
        $derniers_contenus = Contenu::with(['auteur', 'region', 'langue'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Récupérer les derniers utilisateurs
        $derniers_utilisateurs = User::orderBy('created_at', 'desc')->take(5)->get();
        
        return view('dashboard', [
            'users_count' => $users_count,
            'regions_count' => $regions_count,
            'langues_count' => $langues_count,
            'contenus_count' => $contenus_count,
            'commentaires_count' => $commentaires_count,
            'derniers_contenus' => $derniers_contenus,
            'derniers_utilisateurs' => $derniers_utilisateurs,
            'user' => $user,
            'title' => 'Tableau de bord - Culture Bénin',
        ]);
    }

    /**
 * Méthode dashboard pour la route /admin/dashboard
 */
public function dashboard()
{
    return $this->index();
}

/**
 * Afficher le profil de l'administrateur
 */
public function profile()
{
    $user = Auth::user();
    
    // Statistiques de l'admin
    $stats = [
        'total_contenus' => Contenu::where('id_auteur', $user->id)->count(),
        'contenus_publies' => Contenu::where('id_auteur', $user->id)->where('statut', 'publie')->count(),
        'contenus_brouillon' => Contenu::where('id_auteur', $user->id)->where('statut', 'brouillon')->count(),
        'total_commentaires' => Commentaire::count(),
        'derniere_connexion' => $user->updated_at,
        'membre_depuis' => $user->created_at,
    ];
    
    // Dernières activités
    $dernieres_activites = Contenu::where('id_auteur', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    return view('admin.profile', compact('user', 'stats', 'dernieres_activites'));
}

    /**
     * Gestion des contenus - Liste
     */
    public function contenusIndex()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu', 'media'])
            ->where('statut', '!=', 'supprime')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.contenus.index', compact('contenus'));
    }

    /**
     * Gestion des contenus - Création
     */
    public function createContenu()
    {
        $regions = Region::all();
        $langues = Langue::all();
        $types = TypeContenu::all();
        $auteurs = User::whereIn('role', ['admin', 'manager', 'visiteur', 'auteur'])->get();
        
        return view('admin.contenus.create', compact('regions', 'langues', 'types', 'auteurs'));
    }

    /**
     * Gestion des contenus - Enregistrement
     */
    public function storeContenu(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'id_region' => 'nullable|exists:regions,id_region',
            'id_langue' => 'nullable|exists:langues,id_langue',
            'id_type_contenu' => 'nullable|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:users,id',
            'prix' => 'nullable|numeric|min:0',
            'statut' => 'required|in:publie,en attente,brouillon',
            'date_publication' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Définir is_active en fonction du statut
        $validated['is_active'] = $validated['statut'] === 'publie';
        // $validated['is_supprimer'] = false; // Champ supprimé

        // Mapper description vers texte
        if (isset($validated['description'])) {
            $validated['texte'] = $validated['description'];
            unset($validated['description']);
        }

        // Si pas de date de publication, utiliser maintenant
        if (empty($validated['date_publication'])) {
            $validated['date_publication'] = now();
        }

        // Create content
        $contenu = Contenu::create($validated);
        
        // Handle Media Uploads
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                // Determine file type
                $mime = $file->getMimeType();
                $type_fichier = 'autre'; // Default
                
                if (str_starts_with($mime, 'image/')) {
                    $type_fichier = 'image';
                } elseif (str_starts_with($mime, 'video/')) {
                    $type_fichier = 'video';
                } elseif (str_starts_with($mime, 'audio/')) {
                    $type_fichier = 'audio';
                } elseif (in_array($mime, [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'text/plain',
                    'application/rtf'
                ])) {
                    $type_fichier = 'document';
                } elseif ($mime === 'application/epub+zip' || $mime === 'application/x-mobipocket-ebook') {
                    $type_fichier = 'livre';
                }

                $chemin = $file->store('medias', 'public');
                
                Media::create([
                    'titre' => $file->getClientOriginalName(),
                    'nom_fichier' => $file->getClientOriginalName(),
                    'chemin_fichier' => $chemin,
                    'type_fichier' => $type_fichier,
                    'mime_type' => $mime,
                    'extension' => $file->getClientOriginalExtension(),
                    'taille_fichier' => $file->getSize(),
                    'id_contenu' => $contenu->id_contenu,
                    'id_auteur' => Auth::id(), // Or $validated['id_auteur'] if admin uploads on behalf
                    'est_public' => true, // Default to true for content media
                    'est_approuve' => true // Admin uploads are auto-approved
                ]);
            }
        }
        
        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu créé avec succès.');
    }

    /**
     * Gestion des contenus - Détails
     */
    public function showContenu($id)
    {
        $contenu = Contenu::with(['auteur', 'region', 'langue', 'typeContenu', 'media', 'commentaires.user'])
            ->findOrFail($id);
        return view('admin.contenus.show', compact('contenu'));
    }

    /**
     * Gestion des contenus - Édition
     */
    public function editContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $regions = Region::all();
        $langues = Langue::all();
        $types = TypeContenu::all();
        $auteurs = User::whereIn('role', ['admin', 'manager', 'visiteur', 'auteur'])->get();
        
        return view('admin.contenus.edit', compact('contenu', 'regions', 'langues', 'types', 'auteurs'));
    }

    /**
     * Gestion des contenus - Mise à jour
     */
    public function updateContenu(Request $request, $id)
    {
        $contenu = Contenu::findOrFail($id);
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'id_region' => 'nullable|exists:regions,id_region',
            'id_langue' => 'nullable|exists:langues,id_langue',
            'id_type_contenu' => 'nullable|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:users,id',
            'prix' => 'nullable|numeric|min:0',
            'statut' => 'required|in:publie,en attente,brouillon',
            'date_publication' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Définir is_active en fonction du statut
        $validated['is_active'] = $validated['statut'] === 'publie';
        
        // Mapper description vers texte
        if (isset($validated['description'])) {
            $validated['texte'] = $validated['description'];
            unset($validated['description']);
        }
        
        if ($validated['statut'] === 'publie' && empty($validated['date_publication'])) {
             if (empty($contenu->date_publication)) {
                 $validated['date_publication'] = now();
             }
        }

        $contenu->update($validated);
        
        $contenu->update($validated);
        
        // Handle Media Uploads (New additions)
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                // Same logic as create
                 $mime = $file->getMimeType();
                $type_fichier = 'autre';
                
                if (str_starts_with($mime, 'image/')) {
                    $type_fichier = 'image';
                } elseif (str_starts_with($mime, 'video/')) {
                    $type_fichier = 'video';
                } elseif (str_starts_with($mime, 'audio/')) {
                    $type_fichier = 'audio';
                } elseif ($mime === 'application/pdf') {
                    $type_fichier = 'pdf';
                }

                $chemin = $file->store('medias', 'public');
                
                Media::create([
                    'titre' => $file->getClientOriginalName(),
                    'nom_fichier' => $file->getClientOriginalName(),
                    'chemin_fichier' => $chemin,
                    'type_fichier' => $type_fichier,
                    'mime_type' => $mime,
                    'extension' => $file->getClientOriginalExtension(),
                    'taille_fichier' => $file->getSize(),
                    'id_contenu' => $contenu->id_contenu,
                    'id_auteur' => Auth::id(),
                    'est_public' => true,
                    'est_approuve' => true
                ]);
            }
        }
        
        return redirect()->route('admin.contenus.show', $id)
            ->with('success', 'Contenu mis à jour avec succès.');
    }

    /**
     * Gestion des contenus - Suppression
     */
    public function destroyContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        
        // Soft delete: marquer comme supprimé
        // Soft delete: marquer comme supprimé via le statut
        $contenu->update([
            'statut' => 'supprime',
            'is_active' => false
        ]);
        
        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu marqué comme supprimé.');
    }

    /**
     * Gestion des contenus - Suppression définitive
     */
    public function forceDestroyContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        
        // Supprimer les médias associés
        foreach ($contenu->media as $media) {
            if ($media->chemin_fichier) {
                Storage::disk('public')->delete($media->chemin_fichier);
            }
            $media->delete();
        }
        
        // Supprimer les commentaires associés
        $contenu->commentaires()->delete();
        
        // Supprimer le contenu
        $contenu->delete();
        
        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu supprimé définitivement.');
    }

    /**
     * Gestion des médias - Liste
     */
    public function mediaIndex()
    {
        $medias = Media::with(['auteur', 'contenu'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.media.index', compact('medias'));
    }

    /**
     * Gestion des médias - Création
     */
    public function createMedia()
    {
        $contenus = Contenu::active()->get();
        return view('admin.media.create', compact('contenus'));
    }

    /**
     * Gestion des médias - Enregistrement
     */
    public function storeMedia(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_fichier' => 'required|in:image,video,audio,document,pdf',
            'fichier' => 'required|file|max:10240', // 10MB max
            'id_contenu' => 'nullable|exists:contenus,id_contenu',
            'est_public' => 'boolean',
            'prix' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $chemin = $file->store('medias', 'public');
            
            $validated['chemin_fichier'] = $chemin;
            $validated['nom_fichier'] = $file->getClientOriginalName();
            $validated['taille_fichier'] = $file->getSize();
            $validated['extension'] = $file->getClientOriginalExtension();
            $validated['mime_type'] = $file->getMimeType();
            $validated['id_utilisateur'] = Auth::id();
        }

        Media::create($validated);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Média téléchargé avec succès.');
    }

    /**
     * Gestion des médias - Détails
     */
    public function showMedia($id)
    {
        $media = Media::with(['auteur', 'contenu'])->findOrFail($id);
        return view('admin.media.show', compact('media'));
    }

    /**
     * Gestion des médias - Édition
     */
    public function editMedia($id)
    {
        $media = Media::findOrFail($id);
        $contenus = Contenu::active()->get();
        return view('admin.media.edit', compact('media', 'contenus'));
    }

    /**
     * Gestion des médias - Mise à jour
     */
    public function updateMedia(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_fichier' => 'required|in:image,video,audio,document,pdf',
            'id_contenu' => 'nullable|exists:contenus,id_contenu',
            'est_public' => 'boolean',
        ]);

        $media->update($validated);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Média mis à jour avec succès.');
    }

    /**
     * Gestion des médias - Suppression
     */
    public function destroyMedia($id)
    {
        $media = Media::findOrFail($id);
        
        if ($media->chemin_fichier) {
            Storage::disk('public')->delete($media->chemin_fichier);
        }
        
        $media->delete();
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Média supprimé avec succès.');
    }

    /**
     * Modération des commentaires
     */
    public function moderationCommentaires()
    {
        $commentaires = Commentaire::with(['user', 'contenu'])
            ->where('est_modere', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.moderation.commentaires', compact('commentaires'));
    }

    /**
     * Approuver un commentaire
     */
    public function approuverCommentaire($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->update(['est_modere' => true, 'est_approuve' => true]);
        
        return back()->with('success', 'Commentaire approuvé.');
    }

    /**
     * Rejeter un commentaire
     */
    public function rejeterCommentaire($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->update(['est_modere' => true, 'est_approuve' => false]);
        
        return back()->with('success', 'Commentaire rejeté.');
    }

    /**
     * Statistiques
     */
    public function statistics()
    {
        // Statistiques générales
        $stats = [
            'users' => User::count(),
            'users_actifs' => User::where('is_active', true)->count(),
            'contenus' => Contenu::count(),
            'contenus_actifs' => Contenu::where('is_active', true)->where('statut', '!=', 'supprimé')->count(),
            'medias' => Media::count(),
            'regions' => Region::count(),
            'langues' => Langue::count(),
            'commentaires' => Commentaire::count(),
        ];
        
        // Statistiques par type de contenu
        $typesStats = TypeContenu::withCount(['contenus' => function($query) {
            $query->where('is_active', true)->where('statut', '!=', 'supprimé');
        }])->get();
        
        // Évolution des contenus sur les 30 derniers jours
        $evolution = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $evolution[$date] = Contenu::whereDate('created_at', $date)->count();
        }
        
        return view('admin.statistics.index', compact('stats', 'typesStats', 'evolution'));
    }

    /**
     * Paramètres
     */
    public function settings()
    {
        $regions = Region::all();
        $langues = Langue::all();
        $typesContenu = TypeContenu::all();
        
        return view('admin.settings.index', compact('regions', 'langues', 'typesContenu'));
    }

    /**
     * Import de données
     */
    public function import()
    {
        return view('admin.import.index');
    }

    /**
     * Analytics
     */
    public function analytics()
    {
        return view('admin.analytics.index');
    }

    /**
     * Rapports
     */
    public function reports()
    {
        return view('admin.reports.index');
    }
    
    /**
     * Valider un contenu
     */
    public function validateContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->update([
            'statut' => 'validé',
            'is_active' => true
        ]);
        
        return back()->with('success', 'Contenu validé avec succès.');
    }
    
    /**
     * Rejeter un contenu
     */
    public function rejectContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->update([
            'statut' => 'rejete',
            'is_active' => false
        ]);
        
        return back()->with('success', 'Contenu rejeté.');
    }
    
    /**
     * Publier un contenu
     */
    public function publishContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->update([
            'statut' => 'publie',
            'is_active' => true,
            'date_publication' => now()
        ]);
        
        return back()->with('success', 'Contenu publié.');
    }
    
    /**
     * Dé-publier un contenu
     */
    public function unpublishContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->update([
            'statut' => 'brouillon',
            'is_active' => false
        ]);
        
        return back()->with('success', 'Contenu dépublié.');
    }
    
    /**
     * Approuver un média
     */
    public function approveMedia($id)
    {
        $media = Media::findOrFail($id);
        $media->update(['est_approuve' => true]);
        
        return back()->with('success', 'Média approuvé.');
    }
    
    /**
     * Rejeter un média
     */
    public function rejectMedia($id)
    {
        $media = Media::findOrFail($id);
        $media->update(['est_approuve' => false]);
        
        return back()->with('success', 'Média rejeté.');
    }

    /**
     * Gestion des utilisateurs
     */
    public function utilisateursIndex()
    {
        $users = User::withCount(['contenus', 'commentaires'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.utilisateurs.index', compact('users'));
    }

    /**
     * Gestion des langues
     */
    public function languesIndex()
    {
        $langues = Langue::withCount(['contenus', 'utilisateurs'])->orderBy('nom_langue')->paginate(15);
        return view('admin.langues.index', compact('langues'));
    }

    /**
     * Gestion des régions
     */
    public function regionsIndex()
    {
        $regions = Region::withCount(['contenus', 'utilisateurs'])->orderBy('nom_region')->paginate(15);
        return view('admin.regions.index', compact('regions'));
    }
}