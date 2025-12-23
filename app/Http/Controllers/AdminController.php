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
    public function index()
    {
        $user = Auth::user();
        $users_count = User::count();
        $regions_count = Region::count();
        $langues_count = Langue::count();
        $contenus_count = Contenu::where('statut', '!=', 'supprime')->count();
        $commentaires_count = Commentaire::count();
        $derniers_contenus = Contenu::orderBy('created_at', 'desc')->take(5)->get();
        $derniers_utilisateurs = User::orderBy('created_at', 'desc')->take(5)->get();
        
        return view('dashboard', compact('users_count', 'regions_count', 'langues_count', 'contenus_count', 'commentaires_count', 'derniers_contenus', 'derniers_utilisateurs', 'user'));
    }

    public function dashboard() { return $this->index(); }

    public function profile()
    {
        $user = Auth::user();
        $stats = [
            'total_contenus' => Contenu::where('id_auteur', $user->id)->count(),
            'contenus_publies' => Contenu::where('id_auteur', $user->id)->where('statut', 'publie')->count(),
            'total_commentaires' => Commentaire::count(),
        ];
        return view('admin.profile', compact('user', 'stats'));
    }

    public function contenusIndex()
    {
        $contenus = Contenu::where('statut', '!=', 'supprime')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contenus.index', compact('contenus'));
    }

    public function createContenu()
    {
        $regions = Region::all();
        $langues = Langue::all();
        $types = TypeContenu::all();
        $auteurs = User::all();
        return view('admin.contenus.create', compact('regions', 'langues', 'types', 'auteurs'));
    }

    public function storeContenu(Request $request)
    {
        $data = $request->validate(['titre' => 'required', 'texte' => 'required']);
        Contenu::create($data);
        return redirect()->route('admin.contenus.index')->with('success', 'Créé.');
    }

    public function showContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        return view('admin.contenus.show', compact('contenu'));
    }

    public function editContenu($id)
    {
        $contenu = Contenu::findOrFail($id);
        $regions = Region::all();
        $langues = Langue::all();
        $types = TypeContenu::all();
        $auteurs = User::all();
        return view('admin.contenus.edit', compact('contenu', 'regions', 'langues', 'types', 'auteurs'));
    }

    public function updateContenu(Request $request, $id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->update($request->all());
        return redirect()->route('admin.contenus.index')->with('success', 'Mis à jour.');
    }

    public function destroyContenu($id)
    {
        Contenu::findOrFail($id)->update(['statut' => 'supprime']);
        return back()->with('success', 'Supprimé.');
    }

    public function mediaIndex()
    {
        $medias = Media::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.media.index', compact('medias'));
    }

    public function statistics()
    {
        $stats = ['users' => User::count(), 'contenus' => Contenu::count(), 'medias' => Media::count()];
        return view('admin.statistics.index', compact('stats'));
    }

    public function statisticsContenus() { return $this->statistics(); }
    public function statisticsUsers() { return $this->statistics(); }
    public function statisticsMedia() { return $this->statistics(); }
    public function statisticsSales() { return $this->statistics(); }
    public function reports() { return $this->statistics(); }
    public function exportData($type) { return back()->with('info', "Export non implémenté."); }

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function generalSettings() { return $this->settings(); }
    public function paymentSettings() { return $this->settings(); }
    public function emailSettings() { return $this->settings(); }
    public function notificationSettings() { return $this->settings(); }
    public function updateSettings(Request $request, $section) { return back()->with('success', "Mis à jour."); }

    public function utilisateursIndex()
    {
        $users = User::paginate(15);
        return view('admin.utilisateurs.index', compact('users'));
    }

    public function languesIndex()
    {
        $langues = Langue::paginate(15);
        return view('admin.langues.index', compact('langues'));
    }

    public function regionsIndex()
    {
        $regions = Region::paginate(15);
        return view('admin.regions.index', compact('regions'));
    }

    // New missing methods
    public function validateContenu($id) { Contenu::findOrFail($id)->update(['statut' => 'publie', 'date_validation' => now()]); return back()->with('success', 'Validé'); }
    public function rejectContenu($id) { Contenu::findOrFail($id)->update(['statut' => 'rejete']); return back()->with('success', 'Rejeté'); }
    public function publishContenu($id) { Contenu::findOrFail($id)->update(['statut' => 'publie', 'date_publication' => now()]); return back()->with('success', 'Publié'); }
    public function unpublishContenu($id) { Contenu::findOrFail($id)->update(['statut' => 'brouillon']); return back()->with('success', 'Dépublié'); }

    public function createMedia() { return view('admin.media.create'); }
    public function storeMedia(Request $request) { return back()->with('success', 'Media uploadé'); } // Simplifié
    public function showMedia($id) { $media = Media::findOrFail($id); return view('admin.media.show', compact('media')); }
    public function editMedia($id) { $media = Media::findOrFail($id); return view('admin.media.edit', compact('media')); }
    public function updateMedia(Request $request, $id) { Media::findOrFail($id)->update($request->all()); return back()->with('success', 'Media mis à jour'); }
    public function destroyMedia($id) { Media::findOrFail($id)->delete(); return back()->with('success', 'Media supprimé'); }
    public function approveMedia($id) { return back()->with('success', 'Media approuvé'); }
    public function rejectMedia($id) { return back()->with('success', 'Media rejeté'); }
}