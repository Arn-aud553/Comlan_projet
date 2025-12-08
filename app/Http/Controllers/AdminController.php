<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Compter les statistiques
        $users_count = User::count();
        $regions_count = class_exists('App\Models\Region') ? Region::count() : 0;
        $langues_count = class_exists('App\Models\Langue') ? Langue::count() : 0;
        $contenus_count = class_exists('App\Models\Contenu') ? Contenu::count() : 0;
        $commentaires_count = class_exists('App\Models\Commentaire') ? Commentaire::count() : 0;
        
        return view('dashboard', [
            'users_count' => $users_count,
            'regions_count' => $regions_count,
            'langues_count' => $langues_count,
            'contenus_count' => $contenus_count,
            'commentaires_count' => $commentaires_count,
            'user' => $user,
            'title' => 'Tableau de bord - Culture Bénin',
        ]);
    }

    /**
     * Méthode dashboard pour la route /admin/dashboard
     */
    public function dashboard()
    {
        return $this->index(); // Appelle la méthode index() existante
    }

    /**
     * Gestion des contenus - Liste
     */
    public function contenusIndex()
    {
        $contenus = Contenu::with(['user', 'region', 'langue'])->paginate(15);
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
        return view('admin.contenus.create', compact('regions', 'langues', 'types'));
    }

    /**
     * Gestion des contenus - Enregistrement
     */
    public function storeContenu(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'region_id' => 'nullable|exists:regions,id',
            'langue_id' => 'nullable|exists:langues,id',
            'type_contenu_id' => 'nullable|exists:type_contenus,id',
            'est_payant' => 'boolean',
            'prix' => 'nullable|numeric|min:0',
            'est_publie' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        
        Contenu::create($validated);
        
        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu créé avec succès.');
    }

    /**
     * Gestion des contenus - Détails
     */
    public function showContenu($id)
    {
        $contenu = Contenu::with(['user', 'region', 'langue', 'typeContenu'])->findOrFail($id);
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
        return view('admin.contenus.edit', compact('contenu', 'regions', 'langues', 'types'));
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
            'region_id' => 'nullable|exists:regions,id',
            'langue_id' => 'nullable|exists:langues,id',
            'type_contenu_id' => 'nullable|exists:type_contenus,id',
            'est_payant' => 'boolean',
            'prix' => 'nullable|numeric|min:0',
            'est_publie' => 'boolean',
        ]);

        $contenu->update($validated);
        
        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu mis à jour avec succès.');
    }

    /**
     * Gestion des contenus - Suppression
     */
    public function destroyContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->delete();
        
        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu supprimé avec succès.');
    }

    /**
     * Gestion des médias - Liste
     */
    public function mediaIndex()
    {
        $medias = Media::with('user')->paginate(15);
        return view('admin.media.index', compact('medias'));
    }

    /**
     * Gestion des médias - Création
     */
    public function createMedia()
    {
        return view('admin.media.create');
    }

    /**
     * Gestion des médias - Enregistrement
     */
    public function storeMedia(Request $request)
    {
        // Validation et logique d'upload
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,audio,document',
            'fichier' => 'required|file',
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $path = $file->store('medias', 'public');
            $validated['chemin'] = $path;
            $validated['nom_fichier'] = $file->getClientOriginalName();
            $validated['taille'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        $validated['user_id'] = Auth::id();
        
        Media::create($validated);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Média téléchargé avec succès.');
    }

    /**
     * Gestion des médias - Détails
     */
    public function showMedia($id)
    {
        $media = Media::with('user')->findOrFail($id);
        return view('admin.media.show', compact('media'));
    }

    /**
     * Gestion des médias - Édition
     */
    public function editMedia($id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.edit', compact('media'));
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
            'type' => 'required|in:image,video,audio,document',
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
        
        // Supprimer le fichier physique si nécessaire
        if ($media->chemin) {
            Storage::disk('public')->delete($media->chemin);
        }
        
        $media->delete();
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Média supprimé avec succès.');
    }

    /**
     * Modération
     */
    public function moderation()
    {
        return view('admin.moderation.index', ['title' => 'Modération']);
    }

    /**
     * Statistiques
     */
    public function statistics()
    {
        $stats = [
            'users' => User::count(),
            'contenus' => Contenu::count(),
            'medias' => Media::count(),
            'regions' => Region::count(),
            'langues' => Langue::count(),
        ];
        
        return view('admin.statistics.index', compact('stats'));
    }

    /**
     * Paramètres
     */
    public function settings()
    {
        return view('admin.settings.index', ['title' => 'Paramètres']);
    }

    public function import()
    {
        return view('admin.import', ['title' => 'Import']);
    }

    public function analytics()
    {
        return view('admin.analytics', ['title' => 'Analytics']);
    }

    public function reports()
    {
        return view('admin.reports', ['title' => 'Reports']);
    }
    
    // Ajoutez les autres méthodes manquantes pour les routes définies dans web.php
    public function validateContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->est_valide = true;
        $contenu->save();
        
        return back()->with('success', 'Contenu validé avec succès.');
    }
    
    public function rejectContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->est_valide = false;
        $contenu->save();
        
        return back()->with('success', 'Contenu rejeté.');
    }
    
    public function publishContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->est_publie = true;
        $contenu->save();
        
        return back()->with('success', 'Contenu publié.');
    }
    
    public function unpublishContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->est_publie = false;
        $contenu->save();
        
        return back()->with('success', 'Contenu dépublié.');
    }
    
    public function approveMedia($id)
    {
        $media = Media::findOrFail($id);
        $media->est_approuve = true;
        $media->save();
        
        return back()->with('success', 'Média approuvé.');
    }
    
    public function rejectMedia($id)
    {
        $media = Media::findOrFail($id);
        $media->est_approuve = false;
        $media->save();
        
        return back()->with('success', 'Média rejeté.');
    }
}