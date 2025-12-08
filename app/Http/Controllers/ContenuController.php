<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\TypeContenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contenus = Contenu::with(['langue', 'region', 'typeContenu', 'auteur', 'moderateur'])
                          ->withCount(['media', 'commentaires'])
                          ->orderBy('date_creation', 'desc')
                          ->paginate(15);
        
        $langues = Langue::orderBy('nom_langue')->get();
        $regions = Region::orderBy('nom_region')->get();
        $typesContenu = TypeContenu::orderBy('nom')->get();
        $auteurs = User::whereIn('role', ['auteur', 'admin', 'moderateur'])->orderBy('name')->get();
        
        return view('contenus.index', compact('contenus', 'langues', 'regions', 'typesContenu', 'auteurs'));
    }

    /**
     * Get data for create/edit forms
     */
    private function getFormData()
    {
        $langues = Langue::orderBy('nom_langue')->get();
        $regions = Region::orderBy('nom_region')->get();
        $typesContenu = TypeContenu::orderBy('nom')->get();
        // Filtrer les auteurs : seulement Admin et Visiteur
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
            'statut' => 'required|in:publié,en attente,brouillon,rejeté',
            'date_validation' => 'nullable|date',
            'date_creation' => 'nullable|date',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_moderateur' => 'nullable|exists:users,id',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:users,id',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'texte.required' => 'Le contenu texte est obligatoire.',
            'id_region.required' => 'La région est obligatoire.',
            'id_langue.required' => 'La langue est obligatoire.',
            'id_type_contenu.required' => 'Le type de contenu est obligatoire.',
            'id_auteur.required' => 'L\'auteur est obligatoire.',
        ]);
        
        try {
            // Si date_creation n'est pas fournie, utiliser la date actuelle
            if (empty($data['date_creation'])) {
                $data['date_creation'] = now();
            }
            
            // Si le statut est publié et pas de modérateur, utiliser l'utilisateur courant si modérateur/admin
            if ($data['statut'] == 'publié' && empty($data['id_moderateur']) && 
                (Auth::user()->role == 'moderateur' || Auth::user()->role == 'admin')) {
                $data['id_moderateur'] = Auth::id();
            }
            
            // Si le statut est publié et pas de date de validation, utiliser la date actuelle
            if ($data['statut'] == 'publié' && empty($data['date_validation'])) {
                $data['date_validation'] = now();
            }
            
            Contenu::create($data);
            
            return redirect()->route('contenus.index')
                             ->with('success', 'Contenu créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création contenu: ' . $e->getMessage());
            
            return back()->withInput()
                         ->with('error', 'Erreur lors de la création. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contenu $contenu)
    {
        $contenu->load(['langue', 'region', 'typeContenu', 'auteur', 'moderateur']);
        $contenu->loadCount(['media', 'commentaires']);
        
        return view('contenus.show', compact('contenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contenu $contenu)
    {
        $data = $this->getFormData();
        $data['contenu'] = $contenu;
        return view('contenus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contenu $contenu)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'statut' => 'required|in:publié,en attente,brouillon,rejeté',
            'date_validation' => 'nullable|date',
            'date_creation' => 'required|date',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_moderateur' => 'nullable|exists:users,id',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:users,id',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'texte.required' => 'Le contenu texte est obligatoire.',
            'date_creation.required' => 'La date de création est obligatoire.',
            'id_region.required' => 'La région est obligatoire.',
            'id_langue.required' => 'La langue est obligatoire.',
            'id_type_contenu.required' => 'Le type de contenu est obligatoire.',
            'id_auteur.required' => 'L\'auteur est obligatoire.',
        ]);
        
        try {
            // Si le statut passe à publié et pas de modérateur, utiliser l'utilisateur courant si modérateur/admin
            if ($data['statut'] == 'publié' && empty($data['id_moderateur']) && 
                (Auth::user()->role == 'moderateur' || Auth::user()->role == 'admin')) {
                $data['id_moderateur'] = Auth::id();
            }
            
            // Si le statut passe à publié et pas de date de validation, utiliser la date actuelle
            if ($data['statut'] == 'publié' && empty($data['date_validation'])) {
                $data['date_validation'] = now();
            }
            
            $contenu->update($data);
            
            return redirect()->route('contenus.index')
                             ->with('success', 'Contenu mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour contenu: ' . $e->getMessage());
            
            return back()->withInput()
                         ->with('error', 'Erreur lors de la mise à jour. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contenu $contenu)
    {
        try {
            // Vérifier s'il y a des médias associés
            if ($contenu->media()->exists()) {
                return redirect()->route('contenus.index')
                                 ->with('error', 'Impossible de supprimer : ce contenu est associé à ' . $contenu->media()->count() . ' média(s).');
            }
            
            // Vérifier s'il y a des commentaires
            if ($contenu->commentaires()->exists()) {
                return redirect()->route('contenus.index')
                                 ->with('error', 'Impossible de supprimer : ce contenu a ' . $contenu->commentaires()->count() . ' commentaire(s).');
            }
            
            $contenu->delete();
            
            return redirect()->route('contenus.index')
                             ->with('success', 'Contenu supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression contenu: ' . $e->getMessage());
            
            return back()->with('error', 'Erreur lors de la suppression. Veuillez réessayer.');
        }
    }

    /**
     * Valider un contenu (pour modérateurs/admins)
     */
    public function valider(Request $request, Contenu $contenu)
    {
        try {
            if (!$contenu->peutEtreValide()) {
                return back()->with('error', 'Ce contenu ne peut pas être validé dans son état actuel.');
            }
            
            $contenu->valider(Auth::id());
            
            return redirect()->route('contenus.show', $contenu)
                             ->with('success', 'Contenu validé et publié avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur validation contenu: ' . $e->getMessage());
            
            return back()->with('error', 'Erreur lors de la validation. Veuillez réessayer.');
        }
    }

    /**
     * Rejeter un contenu (pour modérateurs/admins)
     */
    public function rejeter(Request $request, Contenu $contenu)
    {
        try {
            $request->validate([
                'raison' => 'nullable|string|max:500'
            ]);
            
            $contenu->rejeter(Auth::id());
            
            return redirect()->route('contenus.show', $contenu)
                             ->with('success', 'Contenu rejeté avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur rejet contenu: ' . $e->getMessage());
            
            return back()->with('error', 'Erreur lors du rejet. Veuillez réessayer.');
        }
    }

    /**
     * Changer le statut d'un contenu
     */
    public function changerStatut(Request $request, Contenu $contenu)
    {
        $request->validate([
            'statut' => 'required|in:publié,en attente,brouillon,rejeté'
        ]);
        
        try {
            $data = ['statut' => $request->statut];
            
            // Si le statut passe à publié, ajouter le modérateur et la date
            if ($request->statut == 'publié') {
                $data['id_moderateur'] = Auth::id();
                $data['date_validation'] = now();
            }
            
            $contenu->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur changement statut: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut.'
            ], 500);
        }
    }

    /**
     * Display contents for client view
     */
    public function indexClient()
    {
        $contenus = Contenu::with(['langue', 'region', 'typeContenu', 'auteur'])
                          ->where('statut', 'publié')
                          ->orderBy('date_creation', 'desc')
                          ->paginate(12);
        
        return view('client.contenus.index', compact('contenus'));
    }

    /**
     * Afficher les contenus par auteur
     */
    public function byAuteur(User $auteur)
    {
        $contenus = Contenu::with(['langue', 'region', 'typeContenu'])
                          ->where('id_auteur', $auteur->id)
                          ->withCount(['media', 'commentaires'])
                          ->orderBy('date_creation', 'desc')
                          ->paginate(15);
        
        return view('contenus.by-auteur', compact('contenus', 'auteur'));
    }
}