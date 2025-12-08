<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function show($slug)
    {
        $themes = [
            'arts-et-traditions' => [
                'title' => 'Arts et traditions',
                'content' => 'La culture béninoise se distingue par une grande richesse artistique. Masques, statues, bronzes et calebasses gravées reflètent les savoir-faire ancestraux. L\'art traditionnel est lié aux rites, cérémonies et histoires des peuples du pays. Danses, rythmes des tam-tams et tissus tissés main témoignent d\'une créativité transmise de génération en génération.'
            ],
            'histoires-et-patrimoines' => [
                'title' => 'Histoires et patrimoines',
                'content' => 'Le Bénin possède un patrimoine historique majeur en Afrique de l\'Ouest. Royaumes d\'Abomey, Allada, Nikki et Porto-Novo : palais royaux, récits guerriers et symboles de pouvoir. Le pays est aussi un lieu clé de la traite négrière, avec la Route de l\'Esclave à Ouidah. Sites, musées et traditions orales préservent cette mémoire.'
            ],
            'langues-et-ethnies' => [
                'title' => 'Langues et ethnies',
                'content' => 'Plus de 50 groupes ethniques coexistent au Bénin, chacun avec ses traditions. Langues les plus parlées : fon, goun, yoruba, bariba, dendi, mina, nagot, adja. Cette diversité linguistique enrichit chants, contes, noms, proverbes et célébrations.'
            ],
            'gastronomie' => [
                'title' => 'Gastronomie',
                'content' => 'Cuisine variée et généreuse, basée sur maïs, manioc, igname et sauces locales. Plats phares : amiwo, akassa, wassa-wassa, gari frit, tchoukoutou (boisson traditionnelle). Recettes régionales mais goût authentique et convivial.'
            ],
            'litteratures-et-arts-modernes' => [
                'title' => 'Littératures et arts modernes',
                'content' => 'Littérature béninoise mêlant oralité, contes et auteurs contemporains. Théâtre, cinéma et arts plastiques explorent quotidien, politique, mémoire et identité. Festivals comme FITHEB encouragent ces expressions.'
            ],
            'symboles-et-identites' => [
                'title' => 'Symboles et identité',
                'content' => 'Symboles : emblèmes royaux, mythes fondateurs, récits des ancêtres. Danhomè – requin, arc, jarre, tambour – symbolisent courage, sagesse et protection. Ces signes renforcent l\'appartenance et l\'héritage historique.'
            ],
            'danses' => [
                'title' => 'Danses',
                'content' => 'Danses centrales dans vie sociale et spirituelle. Styles régionaux : agbadja, tèkè, zinli, tchink-tchink, gèlèdè. Accompagnées de tam-tams et chants. Célébration, honneur aux ancêtres, accueil des visiteurs, unité du groupe.'
            ],
            'media-culturelle' => [
                'title' => 'Médias culturels',
                'content' => 'Médias béninois diffusent et préservent le patrimoine : radios communautaires, télévisions, plateformes en ligne, journaux. Valorisation des traditions, événements artistiques et production locale. Maintien et adaptation culturelle aux nouveaux médias.'
            ],
            'culture-et-territoires' => [
                'title' => 'Culture et Territoire',
                'content' => 'La culture béninoise est profondément liée à son territoire. Chaque région du pays possède ses propres traditions, langues, danses, musiques et savoir-faire artisanaux. Le territoire influence la vie sociale, les pratiques agricoles, les fêtes locales et les rites spirituels. Les zones forestières, savanes et littoraux façonnent les modes de vie et les expressions culturelles : par exemple, les communautés du sud sont célèbres pour leurs masques et cérémonies vodoun, tandis que le nord valorise les danses guerrières et les récits des royaumes traditionnels. Les sites historiques, les palais royaux, les villages anciens et les paysages naturels constituent un patrimoine vivant qui relie les habitants à leur histoire et à leur identité. La culture et le territoire s\'entrelacent pour créer un sentiment d\'appartenance et renforcer la transmission des savoirs d\'une génération à l\'autre.'
            ]
        ];

        if (!array_key_exists($slug, $themes)) {
            abort(404);
        }

        return view('theme-detail', [
            'theme' => $themes[$slug]
        ]);
    }
}