<?php

namespace App\Http\Controllers;

use App\Models\TypeContenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TypeContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typesContenu = TypeContenu::withCount('contenus')
                                  ->orderBy('id_type_contenu', 'desc')
                                  ->paginate(15);
        
        return view('type_contenus.index', compact('typesContenu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type_contenus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100|unique:type_contenus,nom'
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.unique' => 'Ce type de contenu existe déjà.',
            'nom.max' => 'Le nom ne peut pas dépasser 100 caractères.'
        ]);
        
        try {
            TypeContenu::create($data);
            
            return redirect()->route('type_contenus.index')
                             ->with('success', 'Type de contenu créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création type_contenu: ' . $e->getMessage());
            
            return back()->withInput()
                         ->with('error', 'Erreur lors de la création. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeContenu $typeContenu)
    {
        // Note: utiliser 'date_creation' au lieu de latest() car contenus n'a pas 'created_at'
        $typeContenu->load(['contenus' => function($query) {
            $query->orderBy('date_creation', 'desc')->take(10);
        }]);
        
        return view('type_contenus.show', compact('typeContenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeContenu $typeContenu)
    {
        return view('type_contenus.edit', compact('typeContenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeContenu $typeContenu)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100|unique:type_contenus,nom,' . $typeContenu->id_type_contenu . ',id_type_contenu'
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.unique' => 'Ce type de contenu existe déjà.',
            'nom.max' => 'Le nom ne peut pas dépasser 100 caractères.'
        ]);
        
        try {
            $typeContenu->update($data);
            
            return redirect()->route('type_contenus.index')
                             ->with('success', 'Type de contenu mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour type_contenu: ' . $e->getMessage());
            
            return back()->withInput()
                         ->with('error', 'Erreur lors de la mise à jour. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeContenu $typeContenu)
    {
        try {
            // Vérifier si des contenus utilisent ce type
            if ($typeContenu->contenus()->exists()) {
                return redirect()->route('type_contenus.index')
                                 ->with('error', 'Impossible de supprimer : ce type est utilisé par ' . $typeContenu->contenus()->count() . ' contenu(s).');
            }
            
            $typeContenu->delete();
            
            return redirect()->route('type_contenus.index')
                             ->with('success', 'Type de contenu supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression type_contenu: ' . $e->getMessage());
            
            return back()->with('error', 'Erreur lors de la suppression. Veuillez réessayer.');
        }
    }
}