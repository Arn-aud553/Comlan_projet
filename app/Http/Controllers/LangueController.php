<?php

namespace App\Http\Controllers;

use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LangueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Note: 'media' retiré car la table media n'a plus de colonne id_langue
        $langues = Langue::withCount(['contenus', 'users'])
                        ->orderBy('id_langue', 'desc')
                        ->paginate(15);
        
        return view('langues.index', compact('langues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('langues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_langue' => 'required|string|max:100|unique:langues,nom_langue',
            'code_langue' => 'required|string|max:5|unique:langues,code_langue',
            'description' => 'nullable|string|max:10000',
        ], [
            'nom_langue.required' => 'Le nom de la langue est obligatoire.',
            'nom_langue.unique' => 'Cette langue existe déjà.',
            'code_langue.required' => 'Le code de la langue est obligatoire.',
            'code_langue.unique' => 'Ce code de langue existe déjà.',
        ]);
        
        try {
            Langue::create($data);
            
            return redirect()->route('admin.langues.index')
                             ->with('success', 'Langue créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création langue: ' . $e->getMessage());
            
            return back()->withInput()
                         ->with('error', 'Erreur lors de la création. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Langue $langue)
    {
        // Chargement des compteurs
        $langue->loadCount(['contenus', 'users']);

        $contenus = $langue->contenus()
                           ->with(['region', 'typeContenu', 'auteur'])
                           ->orderBy('id_contenu', 'desc')
                           ->paginate(10);
        
        return view('langues.show', compact('langue', 'contenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Langue $langue)
    {
        return view('langues.edit', compact('langue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Langue $langue)
    {
        $data = $request->validate([
            'nom_langue' => 'required|string|max:100|unique:langues,nom_langue,' . $langue->id_langue . ',id_langue',
            'code_langue' => 'required|string|max:5|unique:langues,code_langue,' . $langue->id_langue . ',id_langue',
            'description' => 'nullable|string|max:10000',
        ], [
            'nom_langue.required' => 'Le nom de la langue est obligatoire.',
            'nom_langue.unique' => 'Cette langue existe déjà.',
            'code_langue.required' => 'Le code de la langue est obligatoire.',
            'code_langue.unique' => 'Ce code de langue existe déjà.',
        ]);
        
        try {
            $langue->update($data);
            
            return redirect()->route('admin.langues.index')
                             ->with('success', 'Langue mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour langue: ' . $e->getMessage());
            
            return back()->withInput()
                         ->with('error', 'Erreur lors de la mise à jour. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Langue $langue)
    {
        try {
            // Vérifier si des contenus utilisent cette langue
            if ($langue->contenus()->exists()) {
                return redirect()->route('admin.langues.index')
                                 ->with('error', 'Impossible de supprimer : cette langue est utilisée par ' . $langue->contenus()->count() . ' contenu(s).');
            }
            
            // Vérifier si des médias utilisent cette langue
            if ($langue->media()->exists()) {
                return redirect()->route('admin.langues.index')
                                 ->with('error', 'Impossible de supprimer : cette langue est utilisée par ' . $langue->media()->count() . ' média(s).');
            }
            
            // Vérifier si des utilisateurs utilisent cette langue (maintenant possible)
            if ($langue->users()->exists()) {
                return redirect()->route('admin.langues.index')
                                 ->with('error', 'Impossible de supprimer : cette langue est utilisée par ' . $langue->users()->count() . ' utilisateur(s).');
            }
            
            $langue->delete();
            
            return redirect()->route('admin.langues.index')
                             ->with('success', 'Langue supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression langue: ' . $e->getMessage());
            
            return back()->with('error', 'Erreur lors de la suppression. Veuillez réessayer.');
        }
    }
    
    /**
     * Display languages for client view
     */
    public function indexClient()
    {
        $langues = Langue::withCount('contenus')
                        ->orderBy('nom_langue')
                        ->get();
        
        return view('client.langues.index', compact('langues'));
    }
}