<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\TypeContenu;
use App\Models\User;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contenus = Contenu::with(['langue', 'region', 'typeContenu', 'auteur', 'moderateur'])
                          ->withCount(['media', 'commentaires'])
                          ->where('statut', 'publie')
                          ->orderBy('date_creation', 'desc')
                          ->paginate(15);
        
        $langues = Langue::orderBy('nom_langue')->get();
        $regions = Region::orderBy('nom_region')->get();
        $typesContenu = TypeContenu::orderBy('nom')->get();
        $auteurs = User::whereIn('role', ['auteur', 'admin', 'moderateur'])->orderBy('name')->get();
        
        return view('contenus.index', compact('contenus', 'langues', 'regions', 'typesContenu', 'auteurs'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contenu = Contenu::with(['langue', 'region', 'typeContenu', 'auteur', 'media', 'commentaires.user'])
                          ->where('statut', 'publie')
                          ->findOrFail($id);
        
        return view('contenus.show', compact('contenu'));
    }

    /**
     * Read the specified content.
     */
    public function read($id)
    {
        $contenu = Contenu::where('statut', 'publie')->findOrFail($id);
        return view('contenus.read', compact('contenu'));
    }

    /**
     * Download the specified content.
     */
    public function download($id)
    {
        $contenu = Contenu::with(['media'])->where('statut', 'publie')->findOrFail($id);
        
        $media = $contenu->media->first();
        
        if ($media && Storage::disk('public')->exists($media->chemin_fichier)) {
            return Storage::disk('public')->download($media->chemin_fichier, $media->nom_fichier);
        }
        
        return back()->with('error', 'Fichier non disponible au téléchargement.');
    }

    /**
     * Get data for create/edit forms
     */
    private function getFormData()
    {
        $langues = Langue::orderBy('nom_langue')->get();
        $regions = Region::orderBy('nom_region')->get();
        $typesContenu = TypeContenu::orderBy('nom')->get();
        $auteurs = User::whereIn('role', ['admin', 'visiteur'])->orderBy('name')->get();
        $moderateurs = User::whereIn('role', ['moderateur', 'admin'])->orderBy('name')->get();

        return compact('langues', 'regions', 'typesContenu', 'auteurs', 'moderateurs');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->getFormData();
        return view('contenus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'statut' => 'required|in:publie,en attente,brouillon,rejete',
            'date_validation' => 'nullable|date',
            'date_creation' => 'nullable|date',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_moderateur' => 'nullable|exists:users,id',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:users,id',
            'medias.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ]);
        
        try {
            if (empty($data['date_creation'])) {
                $data['date_creation'] = now();
            }
            if ($data['statut'] == 'publie' && empty($data['id_moderateur']) && 
                (Auth::user()->role == 'moderateur' || Auth::user()->role == 'admin')) {
                $data['id_moderateur'] = Auth::id();
            }
            if ($data['statut'] == 'publie' && empty($data['date_validation'])) {
                $data['date_validation'] = now();
            }
            $contenu = Contenu::create($data);
            if ($request->hasFile('medias')) {
                $this->handleMediaUploads($request->file('medias'), $contenu);
            }
            return redirect()->route('contenus.index')->with('success', 'Contenu créé.');
        } catch (\Exception $e) {
            Log::error('Erreur création contenu: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contenu $contenu)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'statut' => 'required|in:publie,en attente,brouillon,rejete,supprimé',
            'date_validation' => 'nullable|date',
            'date_creation' => 'required|date',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_moderateur' => 'nullable|exists:users,id',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:users,id',
            'medias.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ]);
        
        try {
            if ($data['statut'] == 'publie' && empty($data['id_moderateur']) && 
                (Auth::user()->role == 'moderateur' || Auth::user()->role == 'admin')) {
                $data['id_moderateur'] = Auth::id();
            }
            if ($data['statut'] == 'publie' && empty($data['date_validation'])) {
                $data['date_validation'] = now();
            }
            $contenu->update($data);
            if ($request->hasFile('medias')) {
                $this->handleMediaUploads($request->file('medias'), $contenu);
            }
            return redirect()->route('contenus.index')->with('success', 'Mis à jour.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour contenu: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erreur.');
        }
    }

    /**
     * Gérer l'upload de multiples fichiers média
     */
    private function handleMediaUploads($files, Contenu $contenu)
    {
        foreach ($files as $file) {
            $path = $file->storeAs('uploads/contenus/' . $contenu->id_contenu, uniqid() . '.' . $file->getClientOriginalExtension(), 'public');
            Media::create([
                'nom_fichier' => $file->getClientOriginalName(),
                'titre' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'chemin_fichier' => $path,
                'type_fichier' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : (str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'document'),
                'extension' => $file->getClientOriginalExtension(),
                'taille_fichier' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'id_contenu' => $contenu->id_contenu,
                'id_utilisateur' => Auth::id(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contenu $contenu)
    {
        $contenu->delete();
        return redirect()->route('contenus.index')->with('success', 'Supprimé.');
    }

    public function valider(Contenu $contenu)
    {
        $contenu->update(['statut' => 'publie', 'id_moderateur' => Auth::id(), 'date_validation' => now()]);
        return back()->with('success', 'Validé.');
    }

    public function rejeter(Contenu $contenu)
    {
        $contenu->update(['statut' => 'rejete', 'id_moderateur' => Auth::id()]);
        return back()->with('success', 'Rejeté.');
    }

    public function changerStatut(Request $request, Contenu $contenu)
    {
        $contenu->update(['statut' => $request->statut]);
        return response()->json(['success' => true]);
    }

    public function indexClient()
    {
        $contenus = Contenu::where('statut', 'publie')->paginate(12);
        return view('client.contenus.index', compact('contenus'));
    }

    public function byAuteur(User $auteur)
    {
        $contenus = Contenu::where('id_auteur', $auteur->id)->paginate(15);
        return view('contenus.by-auteur', compact('contenus', 'auteur'));
    }
}