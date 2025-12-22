<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenu;
use App\Models\Media;
use App\Models\Commentaire;

class ModerationController extends Controller
{
    public function index()
    {
        return view('admin.moderation.index');
    }

    public function contenus()
    {
        $contenus = Contenu::where('statut', 'en attente')->paginate(20);
        return view('admin.moderation.contenus', compact('contenus'));
    }

    public function media()
    {
        // Logique à implémenter
        return view('admin.moderation.media');
    }

    public function comments()
    {
        $commentaires = Commentaire::with(['user', 'contenu'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.moderation.comments', compact('commentaires'));
    }

    public function approve($type, $id)
    {
        if ($type === 'comment') {
            $comment = Commentaire::find($id);
            if ($comment) {
                $comment->update(['statut' => 'approuve']);
                return redirect()->back()->with('success', 'Commentaire approuvé avec succès.');
            }
        }
        
        // Logique pour d'autres types (contenu, media) à ajouter si nécessaire
        return redirect()->back()->with('error', 'Élément non trouvé.');
    }

    public function reject($type, $id)
    {
        if ($type === 'comment') {
            $comment = Commentaire::find($id);
            if ($comment) {
                $comment->update(['statut' => 'rejete']);
                return redirect()->back()->with('success', 'Commentaire rejeté.');
            }
        }
        
        return redirect()->back()->with('error', 'Élément non trouvé.');
    }

    public function flag($type, $id)
    {
        if ($type === 'comment') {
            $comment = Commentaire::find($id);
            if ($comment) {
                $comment->update(['statut' => 'signale']);
                return redirect()->back()->with('success', 'Commentaire signalé.');
            }
        }
        
        return redirect()->back()->with('success', 'Signalé');
    }
    
    public function unflag($type, $id)
    {
        if ($type === 'comment') {
            $comment = Commentaire::find($id);
            if ($comment) {
                $comment->update(['statut' => 'en_attente']);
                return redirect()->back()->with('success', 'Signalement retiré.');
            }
        }
        
        return redirect()->back()->with('success', 'Signalement retiré');
    }
}
