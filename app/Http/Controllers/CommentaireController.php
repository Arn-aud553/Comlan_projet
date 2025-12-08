<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Contenu;
use App\Models\User;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function index()
    {
        $commentaires = Commentaire::with(['contenu', 'utilisateur'])
                                  ->orderBy('id_commentaire', 'desc')
                                  ->paginate(15);
        
        return view('commentaires.index', compact('commentaires'));
    }

    public function create()
    {
        // Récupérer la liste des contenus pour le formulaire
        $contenus = Contenu::select('id_contenu', 'titre')
                          ->orderBy('titre')
                          ->get();
        
        // Récupérer la liste des utilisateurs pour le formulaire
        $utilisateurs = User::select('id', 'name', 'email')
                           ->orderBy('name')
                           ->get();
        
        return view('commentaires.create', compact('contenus', 'utilisateurs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'texte' => 'required|string|max:2000',
            'note' => 'nullable|integer|min:0|max:5',
            'id_contenu' => 'required|integer|exists:contenus,id_contenu',
            'id_utilisateur' => 'nullable|integer|exists:users,id', // Changé ici
        ]);
        
        Commentaire::create($data);
        
        return redirect()->route('commentaires.index')
                         ->with('success', 'Commentaire créé avec succès.');
    }

    public function show(Commentaire $commentaire)
    {
        $commentaire->load(['contenu', 'utilisateur']);
        
        return view('commentaires.show', compact('commentaire'));
    }

    public function edit(Commentaire $commentaire)
    {
        // Récupérer la liste des contenus pour le formulaire
        $contenus = Contenu::select('id_contenu', 'titre')
                          ->orderBy('titre')
                          ->get();
        
        // Récupérer la liste des utilisateurs pour le formulaire
        $utilisateurs = User::select('id', 'name', 'email')
                           ->orderBy('name')
                           ->get();
        
        return view('commentaires.edit', compact('commentaire', 'contenus', 'utilisateurs'));
    }

    public function update(Request $request, Commentaire $commentaire)
    {
        $data = $request->validate([
            'texte' => 'required|string|max:2000',
            'note' => 'nullable|integer|min:0|max:5',
            'id_contenu' => 'required|integer|exists:contenus,id_contenu',
            'id_utilisateur' => 'nullable|integer|exists:users,id', // Changé ici
        ]);
        
        $commentaire->update($data);
        
        return redirect()->route('commentaires.index')
                         ->with('success', 'Commentaire mis à jour avec succès.');
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();
        
        return redirect()->route('commentaires.index')
                         ->with('success', 'Commentaire supprimé avec succès.');
    }
}