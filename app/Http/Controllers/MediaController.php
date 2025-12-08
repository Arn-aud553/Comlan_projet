<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::paginate(15);
        return view('media.index', compact('media'));
    }

    public function create()
    {
        // Les médias sont maintenant liés aux contenus, pas directement aux utilisateurs
        $contenus = \App\Models\Contenu::orderBy('titre')->get();
        $users = \App\Models\User::orderBy('name')->get();
        return view('media.create', compact('contenus', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fichier' => 'required|file|max:512000', // Max 500MB
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'id_contenu' => 'nullable|integer|exists:contenus,id_contenu',
            'id_utilisateur' => 'required|integer|exists:users,id',
        ]);

        if (!$request->hasFile('fichier')) {
            return back()->withErrors(['fichier' => 'Veuillez sélectionner un fichier.']);
        }

        $file = $request->file('fichier');
        
        // Déterminer le type de fichier
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        
        $typeMapping = [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'],
            'video' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'],
            'livre' => ['epub', 'mobi', 'azw', 'azw3', 'pdf'],
            'document' => ['doc', 'docx', 'txt', 'odt', 'rtf', 'xls', 'xlsx', 'ppt', 'pptx'],
        ];
        
        $typeFichier = 'document'; // Par défaut
        foreach ($typeMapping as $type => $extensions) {
            if (in_array(strtolower($extension), $extensions)) {
                $typeFichier = $type;
                break;
            }
        }
        
        // Générer un nom unique
        $nomFichier = time() . '_' . uniqid() . '.' . $extension;
        $dossier = 'contenus/' . $typeFichier . 's';
        
        // Stocker le fichier
        $cheminFichier = $file->storeAs($dossier, $nomFichier, 'public');
        
        // Créer l'entrée média
        Media::create([
            'nom_fichier' => $file->getClientOriginalName(),
            'titre' => $validated['titre'] ?? null,
            'description' => $validated['description'] ?? null,
            'chemin_fichier' => $cheminFichier,
            'type_fichier' => $typeFichier,
            'extension' => $extension,
            'taille_fichier' => $file->getSize(),
            'mime_type' => $mimeType,
            'id_contenu' => $validated['id_contenu'] ?? null,
            'id_utilisateur' => $validated['id_utilisateur'],
        ]);
        
        return redirect()->route('media.index')
            ->with('success', 'Média créé avec succès.');
    }
    public function show(Media $media)
    {
        return view('media.show', compact('media'));
    }

    public function edit(Media $media)
    {
        $contenus = \App\Models\Contenu::orderBy('titre')->get();
        $users = \App\Models\User::orderBy('name')->get();
        return view('media.edit', compact('media', 'contenus', 'users'));
    }

    public function update(Request $request, Media $media)
    {
        $data = $request->validate([
            'nom_fichier' => 'required|string|max:255',
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type_fichier' => 'required|string|in:image,video,document,livre',
            'extension' => 'required|string|max:10',
            'id_contenu' => 'nullable|integer|exists:contenus,id_contenu',
            'id_utilisateur' => 'required|integer|exists:users,id',
        ]);
        $media->update($data);
        return redirect()->route('media.index')
            ->with('success', 'Média mis à jour avec succès.');
    }
    public function destroy(Media $media)
    {
        // Supprimer le fichier physique si nécessaire
        if ($media->chemin_fichier && \Storage::disk('public')->exists($media->chemin_fichier)) {
            \Storage::disk('public')->delete($media->chemin_fichier);
        }
        
        $media->delete();
        return redirect()->route('media.index')
            ->with('success', 'Média supprimé avec succès.');
    }
}
