<?php

namespace App\Http\Controllers;

use App\Models\TypeMedia;
use Illuminate\Http\Request;

class TypeMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeMedias = TypeMedia::all();
        return response()->json($typeMedias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_media' => 'required|string|max:255',
        ]);

        $typeMedia = TypeMedia::create($validated);
        return response()->json($typeMedia, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeMedia $typeMedia)
    {
        return response()->json($typeMedia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeMedia $typeMedia)
    {
        $validated = $request->validate([
            'nom_media' => 'required|string|max:255',
        ]);

        $typeMedia->update($validated);
        return response()->json($typeMedia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeMedia $typeMedia)
    {
        $typeMedia->delete();
        return response()->json(null, 204);
    }
}