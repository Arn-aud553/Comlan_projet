<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenu;
use App\Models\TypeContenu;
use App\Models\Region;
use App\Models\Langue;

class PublicController extends Controller
{
    /**
     * Page Musique
     */
    public function musique()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%musique%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('musique', compact('contenus'));
    }

    /**
     * Page Danse
     */
    public function danse()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%danse%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('danse', compact('contenus'));
    }

    /**
     * Page Art
     */
    public function art()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%art%')
                      ->where('nom', 'not like', '%rue%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('art', compact('contenus'));
    }

    /**
     * Page Art de rue
     */
    public function artRue()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%art%')
                      ->where('nom', 'like', '%rue%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('art-rue', compact('contenus'));
    }

    /**
     * Page Histoire
     */
    public function histoire()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%histoire%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('histoire', compact('contenus'));
    }

    /**
     * Page Gastronomie
     */
    public function gastronomie()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%gastronomie%')
                      ->orWhere('nom', 'like', '%cuisine%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('gastronomie', compact('contenus'));
    }

    /**
     * Page Mode
     */
    public function mode()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->whereHas('typeContenu', function($query) {
                $query->where('nom', 'like', '%mode%')
                      ->orWhere('nom', 'like', '%vêtement%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        return view('mode', compact('contenus'));
    }

    /**
     * Page Thèmes (tous les contenus)
     */
    public function themes()
    {
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->orderBy('date_publication', 'desc')
            ->paginate(12);
            
        $types = TypeContenu::withCount(['contenus' => function($query) {
            $query->where('statut', 'publie');
        }])->get();
        
        $regions = Region::withCount(['contenus' => function($query) {
            $query->where('statut', 'publie');
        }])->get();
        
        $langues = Langue::withCount(['contenus' => function($query) {
            $query->where('statut', 'publie');
        }])->get();
            
        return view('themes', compact('contenus', 'types', 'regions', 'langues'));
    }

    /**
     * Page détail d'un thème
     */
    public function themeDetail($slug)
    {
        // Mapper les slugs vers les titres de thèmes
        $themeMapping = [
            'arts-et-traditions' => 'Arts et traditions',
            'histoires-et-patrimoines' => 'Histoires et patrimoines',
            'langues-et-ethnies' => 'Langues et ethnies',
            'gastronomie' => 'Gastronomie',
            'litteratures-et-arts-modernes' => 'Littératures et arts modernes',
            'symboles-et-identites' => 'Symboles et identités',
            'danses' => 'Danses',
            'media-culturelle' => 'Média culturelle',
            'culture-et-territoires' => 'Culture et territoires',
            // Anciens slugs pour compatibilité
            'patrimoine-culturel' => 'Patrimoine culturel',
            'arts-et-artisanat' => 'Arts et artisanat',
            'musique-et-danse' => 'Musique et danse',
            'litterature-orale' => 'Littérature orale',
            'gastronomie-locale' => 'Gastronomie locale',
        ];

        $themeTitle = $themeMapping[$slug] ?? 'Thème';

        // Récupérer les contenus liés au thème (par recherche dans le titre ou description)
        $contenus = Contenu::with(['auteur', 'region', 'langue', 'typeContenu'])
            ->where('statut', 'publie')
            ->where(function($query) use ($themeTitle, $slug) {
                $query->where('titre', 'like', '%' . $themeTitle . '%')
                      ->orWhere('texte', 'like', '%' . $themeTitle . '%')
                      ->orWhere('titre', 'like', '%' . str_replace('-', ' ', $slug) . '%');
            })
            ->orderBy('date_publication', 'desc')
            ->paginate(12);

        return view('theme-detail', compact('contenus', 'themeTitle', 'slug'));
    }
}
