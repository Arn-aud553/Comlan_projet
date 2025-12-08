<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Region;
use App\Models\Langue;
use App\Models\Contenu;
use App\Models\Commentaire;

class DashboardController extends Controller
{
    public function index()
    {
        // Compter les éléments dans chaque table
        $users_count = User::count();
        $regions_count = Region::count();
        $langues_count = Langue::count();
        $contenus_count = Contenu::count();
        $commentaires_count = Commentaire::count();
        
        return view('dashboard', compact(
            'users_count',
            'regions_count',
            'langues_count',
            'contenus_count',
            'commentaires_count'
        ));
    }
}