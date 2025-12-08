<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TypeContenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\User;

class ContenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs nécessaires
        $typeContenu = TypeContenu::first();
        $langue = Langue::first();
        $region = Region::first();
        $auteur = User::first();

        // Vérifier que les données existent
        if (!$typeContenu || !$langue || !$region || !$auteur) {
            $this->command->error('Veuillez d\'abord créer au moins un type de contenu, une langue, une région et un utilisateur.');
            return;
        }

        $contenus = [
            [
                'titre' => 'Les Rois du Dahomey : Histoire et Héritage',
                'texte' => "Le royaume du Dahomey, qui a prospéré du XVIIe au XIXe siècle, a laissé un héritage culturel et historique inestimable au Bénin moderne. Les rois du Dahomey, connus pour leur puissance militaire et leur organisation politique sophistiquée, ont façonné l'identité béninoise.\n\nLe roi Béhanzin, dernier souverain indépendant du Dahomey, a résisté héroïquement à la colonisation française jusqu'en 1894. Son courage et sa détermination symbolisent la résistance africaine face à l'impérialisme européen.\n\nLes palais royaux d'Abomey, classés au patrimoine mondial de l'UNESCO, témoignent de la grandeur de cette civilisation. Chaque roi construisait son propre palais, créant ainsi un complexe architectural unique qui raconte l'histoire du royaume à travers ses bas-reliefs et ses symboles.\n\nAujourd'hui, les traditions royales perdurent à travers les cérémonies, les danses et les chants qui célèbrent la mémoire des ancêtres et transmettent les valeurs culturelles aux nouvelles générations.",
            ],
            [
                'titre' => 'Le Vodoun : Spiritualité et Philosophie Béninoise',
                'texte' => "Le Vodoun, souvent mal compris et stigmatisé, est une religion ancestrale profondément enracinée dans la culture béninoise. Né sur les terres du Bénin actuel, le Vodoun représente bien plus qu'une simple croyance : c'est une philosophie de vie, un système de valeurs et une connexion spirituelle avec les ancêtres.\n\nLe temple des pythons à Ouidah, haut lieu du Vodoun, accueille des milliers de pèlerins chaque année. Les pythons, considérés comme sacrés, symbolisent la sagesse et la protection divine. Les prêtres Vodoun, gardiens des traditions, perpétuent les rituels ancestraux et assurent la transmission du savoir spirituel.\n\nLe festival annuel du Vodoun, célébré le 10 janvier, rassemble des pratiquants du monde entier. Cette célébration colorée et vibrante met en lumière la richesse de cette tradition spirituelle à travers des danses, des chants et des cérémonies sacrées.\n\nLe Vodoun enseigne le respect de la nature, l'harmonie communautaire et la vénération des ancêtres, des valeurs qui résonnent encore fortement dans la société béninoise contemporaine.",
            ],
            [
                'titre' => 'L\'Art du Bronze au Bénin : Chef-d\'œuvre de l\'Humanité',
                'texte' => "Les bronzes du Bénin comptent parmi les plus grandes réalisations artistiques de l'humanité. Créés entre le XIIIe et le XIXe siècle, ces œuvres d'art témoignent du génie créatif et de la maîtrise technique des artisans béninois.\n\nLa technique de la cire perdue, utilisée pour créer ces sculptures, requiert une expertise exceptionnelle. Chaque pièce est unique, représentant des rois, des reines, des guerriers et des scènes de la vie quotidienne avec un réalisme saisissant et une attention minutieuse aux détails.\n\nMalheureusement, lors de l'expédition punitive britannique de 1897, des milliers de ces précieux bronzes ont été pillés et dispersés dans les musées occidentaux. Aujourd'hui, le Bénin mène un combat légitime pour le rapatriement de son patrimoine culturel.\n\nLes artisans contemporains perpétuent cet art ancestral, créant de nouvelles œuvres qui honorent la tradition tout en explorant des thèmes modernes. Leurs créations sont exposées dans les galeries d'art de Cotonou et d'Abomey, attirant collectionneurs et amateurs d'art du monde entier.",
            ],
            [
                'titre' => 'La Gastronomie Béninoise : Saveurs et Traditions',
                'texte' => "La cuisine béninoise est un voyage culinaire fascinant qui reflète la diversité culturelle et géographique du pays. Des plats traditionnels comme le Amiwo, le Akassa et le Kuli-kuli racontent l'histoire d'un peuple et de ses traditions.\n\nLe marché Dantokpa à Cotonou, l'un des plus grands marchés d'Afrique de l'Ouest, est un paradis pour les amateurs de cuisine locale. Les étals débordent de produits frais : ignames, manioc, tomates, piments, poissons fumés et épices aromatiques qui parfument l'air.\n\nLe Amiwo, plat emblématique du sud du Bénin, est une pâte de maïs rouge accompagnée d'une sauce tomate épicée et de poulet ou de poisson. Sa préparation est un art qui se transmet de mère en fille, chaque famille ayant ses propres secrets culinaires.\n\nLes femmes béninoises, véritables gardiennes de la tradition culinaire, perpétuent ces recettes ancestrales tout en les adaptant aux goûts contemporains. Leurs restaurants et maquis sont des lieux de convivialité où se mêlent saveurs authentiques et hospitalité chaleureuse.",
            ],
            [
                'titre' => 'Les Danses Traditionnelles : Expression de l\'Âme Béninoise',
                'texte' => "La danse occupe une place centrale dans la culture béninoise, servant de moyen d'expression, de communication et de célébration. Chaque ethnie possède ses propres danses, chacune racontant une histoire unique et transmettant des valeurs culturelles.\n\nLe Zangbeto, danse mystique des gardiens de la nuit, est l'une des plus spectaculaires. Les danseurs, vêtus de costumes de paille colorés, tourbillonnent au rythme des tambours, incarnant les esprits protecteurs de la communauté. Cette danse, à la fois impressionnante et mystérieuse, fascine les spectateurs par sa puissance et son énergie.\n\nLe Tchinkounmè, danse des chasseurs, célèbre le courage et l'habileté. Les danseurs miment les mouvements de la chasse, accompagnés de chants guerriers et de percussions entraînantes. Cette performance dynamique honore les ancêtres chasseurs et transmet leur bravoure aux jeunes générations.\n\nLes troupes de danse traditionnelle se produisent lors des festivals, des mariages et des cérémonies importantes, préservant ainsi un patrimoine immatériel précieux. Les jeunes apprennent ces danses dès leur plus jeune âge, assurant la pérennité de ces traditions séculaires.",
            ],
            [
                'titre' => 'Les Langues du Bénin : Diversité Linguistique',
                'texte' => "Le Bénin est un véritable carrefour linguistique, abritant plus de 50 langues nationales qui reflètent la richesse de sa diversité ethnique. Le Fon, le Yoruba, le Bariba, le Dendi et le Mina sont parmi les langues les plus parlées, chacune portant sa propre vision du monde et ses traditions orales.\n\nLe Fon, langue du royaume du Dahomey, est parlé par environ 40% de la population. Sa structure tonale et sa richesse lexicale en font une langue fascinante, capable d'exprimer des concepts philosophiques complexes et des nuances émotionnelles subtiles.\n\nLes griots, gardiens de la tradition orale, utilisent ces langues pour transmettre l'histoire, les proverbes et les légendes. Leurs récits, accompagnés de musique traditionnelle, captivent les auditoires et assurent la transmission du savoir ancestral.\n\nAujourd'hui, des efforts sont déployés pour préserver et promouvoir ces langues nationales. Des programmes d'éducation bilingue sont mis en place, et des dictionnaires sont élaborés pour documenter et standardiser ces langues précieuses, garantissant ainsi leur survie pour les générations futures.",
            ],
            [
                'titre' => 'L\'Artisanat Béninois : Savoir-faire Ancestral',
                'texte' => "L'artisanat béninois est le reflet d'un savoir-faire millénaire transmis de génération en génération. Les artisans, véritables artistes, créent des œuvres qui allient beauté esthétique et fonctionnalité pratique.\n\nLes tissus traditionnels, comme le Kente et le batik, sont tissés à la main sur des métiers ancestraux. Chaque motif raconte une histoire, symbolise une valeur ou commémore un événement important. Les couleurs vives et les designs géométriques complexes témoignent de la créativité et de la maîtrise technique des tisserands.\n\nLa poterie, art ancestral pratiqué principalement par les femmes, produit des objets à la fois utilitaires et décoratifs. Les potières façonnent l'argile avec leurs mains expertes, créant des jarres, des plats et des sculptures qui portent la marque de leur talent individuel.\n\nLes sculpteurs sur bois créent des masques, des statues et des objets rituels qui jouent un rôle important dans les cérémonies traditionnelles. Chaque pièce est unique, imprégnée de l'esprit de l'artisan et chargée de signification culturelle et spirituelle.",
            ],
            [
                'titre' => 'La Route de l\'Esclave : Mémoire et Réconciliation',
                'texte' => "La Route de l'Esclave à Ouidah est un lieu de mémoire poignant qui commémore les millions d'Africains déportés lors de la traite négrière. Ce parcours de 4 kilomètres, de la place Chacha jusqu'à la Porte du Non-Retour, retrace le chemin douloureux des esclaves vers les navires négriers.\n\nLe long de cette route, des monuments et des sculptures évoquent les souffrances endurées et honorent la mémoire des ancêtres. L'Arbre de l'Oubli, autour duquel les esclaves devaient tourner pour oublier leur passé, et l'Arbre du Retour, symbole d'espoir et de réconciliation, marquent des étapes importantes de ce parcours mémoriel.\n\nLa Porte du Non-Retour, monument érigé face à l'océan Atlantique, symbolise le point de départ vers l'inconnu et la séparation définitive avec la terre natale. Aujourd'hui, elle est devenue un lieu de pèlerinage pour les descendants d'esclaves du monde entier, venus se recueillir et se reconnecter avec leurs racines africaines.\n\nCe site, classé au patrimoine mondial de l'UNESCO, joue un rôle crucial dans la préservation de la mémoire collective et dans la promotion de la paix et de la réconciliation entre les peuples.",
            ],
        ];

        // Utiliser SQL brut pour contourner la contrainte CHECK de PostgreSQL
        foreach ($contenus as $contenuData) {
            DB::statement("
                INSERT INTO contenus (titre, texte, statut, id_region, id_langue, id_type_contenu, id_auteur, date_creation, created_at, updated_at)
                VALUES (?, ?, DEFAULT, ?, ?, ?, ?, NOW(), NOW(), NOW())
            ", [
                $contenuData['titre'],
                $contenuData['texte'],
                $region->id_region,
                $langue->id_langue,
                $typeContenu->id_type_contenu,
                $auteur->id,
            ]);
        }

        // Mettre à jour tous les contenus créés pour les passer en 'publié'
        DB::statement("UPDATE contenus SET statut = 'publié' WHERE statut = 'brouillon' AND titre IN (?, ?, ?, ?, ?, ?, ?, ?)", [
            'Les Rois du Dahomey : Histoire et Héritage',
            'Le Vodoun : Spiritualité et Philosophie Béninoise',
            'L\'Art du Bronze au Bénin : Chef-d\'œuvre de l\'Humanité',
            'La Gastronomie Béninoise : Saveurs et Traditions',
            'Les Danses Traditionnelles : Expression de l\'Âme Béninoise',
            'Les Langues du Bénin : Diversité Linguistique',
            'L\'Artisanat Béninois : Savoir-faire Ancestral',
            'La Route de l\'Esclave : Mémoire et Réconciliation',
        ]);

        $this->command->info('8 contenus culturels béninois créés avec succès !');
    }
}