<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::withCount('contenus')
                        ->orderBy('id_region', 'desc')
                        ->paginate(15);
        
        return view('regions.index', compact('regions'));
    }

    public function create()
    {
        return view('regions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_region' => 'required|string|max:100|unique:regions,nom_region',
            'description' => 'nullable|string',
        ]);
        
        Region::create($data);
        
        return redirect()->route('admin.regions.index')
                         ->with('success', 'Région créée avec succès.');
    }

    public function show(Region $region)
    {
        // Charger les contenus associés avec pagination
        $contenus = $region->contenus()
                          ->with(['langue', 'typeContenu', 'auteur'])
                          ->orderBy('id_contenu', 'desc')
                          ->paginate(10);
        
        $region->loadCount('contenus');
        
        return view('regions.show', compact('region', 'contenus'));
    }

    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $data = $request->validate([
            'nom_region' => 'required|string|max:100|unique:regions,nom_region,' . $region->id_region . ',id_region',
            'description' => 'nullable|string',
        ]);
        
        $region->update($data);
        
        return redirect()->route('admin.regions.index')
                         ->with('success', 'Région mise à jour avec succès.');
    }

    public function destroy(Region $region)
    {
        // Vérifier si la région est utilisée
        if ($region->contenus()->count() > 0) {
            return redirect()->route('admin.regions.index')
                             ->with('error', 'Impossible de supprimer cette région car elle est associée à des contenus.');
        }
        
        $region->delete();
        
        return redirect()->route('admin.regions.index')
                         ->with('success', 'Région supprimée avec succès.');
    }
    
    public function indexClient()
    {
        $regions = Region::withCount('contenus')
                        ->orderBy('nom_region')
                        ->get();
        
        return view('client.regions.index', compact('regions'));
    }
}