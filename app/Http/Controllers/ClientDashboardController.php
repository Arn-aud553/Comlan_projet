<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Contenu;
use App\Models\TypeContenu;
use App\Models\Media;
use App\Models\User;
use App\Models\Langue;
use App\Models\Region;
use App\Models\Paiement;

class ClientDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord client
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Récupérer les contenus récents avec gestion d'erreurs
            $contenusRecents = Contenu::with([
                'typeContenu' => function($query) {
                    try {
                        return $query->select('id_type_contenu', 'nom');
                    } catch (\Exception $e) {
                        return null;
                    }
                },
                'langue' => function($query) {
                    try {
                        return $query->select('id_langue', 'nom_langue');
                    } catch (\Exception $e) {
                        return null;
                    }
                },
                'region' => function($query) {
                    try {
                        return $query->select('id_region', 'nom_region');
                    } catch (\Exception $e) {
                        return null;
                    }
                },
                'auteur' => function($query) {
                    try {
                        return $query->select('id', 'name', 'email');
                    } catch (\Exception $e) {
                        return null;
                    }
                },
                'media'
            ])->orderBy('date_creation', 'desc')->take(10)->get();

            // Récupérer les médias récents
            $medias = Media::whereIn('type_fichier', ['image', 'video'])
                ->with(['contenu', 'utilisateur'])
                ->orderBy('created_at', 'desc')
                ->take(12)
                ->get();

            // Contenus récents publiés
            $recentContents = Contenu::where('statut', 'publié')
                ->with([
                    'typeContenu' => function($query) {
                        try { return $query->select('id_type_contenu', 'nom'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'langue' => function($query) {
                        try { return $query->select('id_langue', 'nom_langue'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'region' => function($query) {
                        try { return $query->select('id_region', 'nom_region'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'auteur' => function($query) {
                        try { return $query->select('id', 'name'); } 
                        catch (\Exception $e) { return null; }
                    }
                ])
                ->orderBy('date_creation', 'desc')
                ->take(5)
                ->get();

            // Calculer les statistiques avec gestion d'erreurs
            $stats = [
                'contents' => Contenu::count(),
                'medias' => Media::count(),
                'users' => User::count(),
                'languages' => 0,
                'regions' => 0
            ];

            try {
                if (class_exists('App\Models\Langue')) {
                    $stats['languages'] = Langue::count();
                }
            } catch (\Exception $e) {
                $stats['languages'] = 0;
            }

            try {
                if (class_exists('App\Models\Region')) {
                    $stats['regions'] = Region::count();
                }
            } catch (\Exception $e) {
                $stats['regions'] = 0;
            }

            // Récupérer les livres (type contenu 1)
            $livres = Contenu::where('statut', 'publié')
                ->whereHas('typeContenu', function($query) {
                    $query->where('nom', 'LIKE', '%livre%')->orWhere('id_type_contenu', 1);
                })
                ->take(5)
                ->get();

            return view('layouts.client', compact(
                'user', 'stats', 'recentContents', 'livres', 'medias', 'contenusRecents'
            ));

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return view('layouts.client', [
                'user' => Auth::user(),
                'stats' => ['contents' => 0, 'medias' => 0, 'users' => 0, 'languages' => 0, 'regions' => 0],
                'recentContents' => collect([]),
                'livres' => collect([]),
                'medias' => collect([]),
                'contenusRecents' => collect([])
            ]);
        }
    }

    /**
     * Gérer les contenus (pour l'administration client)
     */
    public function manage()
    {
        try {
            $contenus = Contenu::with([
                'typeContenu' => function($query) {
                    try { return $query->select('id_type_contenu', 'nom'); } 
                    catch (\Exception $e) { return null; }
                },
                'langue' => function($query) {
                    try { return $query->select('id_langue', 'nom_langue'); } 
                    catch (\Exception $e) { return null; }
                },
                'region' => function($query) {
                    try { return $query->select('id_region', 'nom_region'); } 
                    catch (\Exception $e) { return null; }
                },
                'auteur' => function($query) {
                    try { return $query->select('id', 'name'); } 
                    catch (\Exception $e) { return null; }
                }
            ])->orderBy('date_creation', 'desc')->paginate(20);

            return view('client.contenus.manage', compact('contenus'));

        } catch (\Exception $e) {
            Log::error('Manage contenus error: ' . $e->getMessage());
            return redirect()->route('client.dashboard')
                ->with('error', 'Erreur lors du chargement des contenus.');
        }
    }

    /**
     * Liste des contenus pour les clients
     */
    public function contenusIndex(Request $request)
    {
        try {
            // Récupérer les paramètres de recherche
            $search = $request->input('search');
            $type = $request->input('type');
            $region = $request->input('region');
            $langue = $request->input('langue');
            $statut = $request->input('statut', 'publié');
            $sort = $request->input('sort', 'recent');
            $perPage = $request->input('per_page', 12);

            // Construction de la requête
            $query = Contenu::query();

            // Filtre par statut (par défaut: publié)
            if ($statut) {
                $query->where('statut', $statut);
            }

            // Filtre par recherche
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('titre', 'LIKE', "%{$search}%")
                      ->orWhere('texte', 'LIKE', "%{$search}%");
                });
            }

            // Filtre par type
            if ($type) {
                $query->where('id_type_contenu', $type);
            }

            // Filtre par région
            if ($region) {
                $query->where('id_region', $region);
            }

            // Filtre par langue
            if ($langue) {
                $query->where('id_langue', $langue);
            }

            // Trier les résultats
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('date_creation', 'asc');
                    break;
                case 'title_asc':
                    $query->orderBy('titre', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('titre', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('prix', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('prix', 'desc');
                    break;
                default:
                    $query->orderBy('date_creation', 'desc');
            }

            // Relations avec gestion d'erreurs
            $query->with([
                'typeContenu' => function($query) {
                    try { return $query->select('id_type_contenu', 'nom'); } 
                    catch (\Exception $e) { return null; }
                },
                'langue' => function($query) {
                    try { return $query->select('id_langue', 'nom_langue'); } 
                    catch (\Exception $e) { return null; }
                },
                'region' => function($query) {
                    try { return $query->select('id_region', 'nom_region'); } 
                    catch (\Exception $e) { return null; }
                },
                'auteur' => function($query) {
                    try { return $query->select('id', 'name'); } 
                    catch (\Exception $e) { return null; }
                },
                'media'
            ]);

            $contenus = $query->paginate($perPage);

            // Récupérer les données pour les filtres
            $regions = $this->getRegions();
            $langues = $this->getLangues();
            $typeContenus = $this->getTypeContenus();

            // Préparer les catégories pour la vue
            $categories = $typeContenus->map(function($type) {
                return (object)[
                    'id' => $type->id_type_contenu ?? $type->id,
                    'nom' => $type->nom,
                    'contenus_count' => Contenu::where('id_type_contenu', $type->id_type_contenu ?? $type->id)
                        ->where('statut', 'publié')
                        ->count()
                ];
            });

            return view('client.contenus.index', compact(
                'contenus', 'regions', 'langues', 'typeContenus', 'categories'
            ));

        } catch (\Exception $e) {
            Log::error('Contenus index error: ' . $e->getMessage());
            return view('client.contenus.index', [
                'contenus' => collect([]),
                'regions' => collect([]),
                'langues' => collect([]),
                'typeContenus' => collect([]),
                'categories' => collect([])
            ])->with('error', 'Erreur lors du chargement des contenus.');
        }
    }

    /**
     * Détail d'un contenu
     */
    public function contenusDetail($id)
    {
        try {
            Log::info('=== CONTENUS DETAIL START ===');
            Log::info('Contenu ID: ' . $id);
            Log::info('User ID: ' . Auth::id());

            // Récupérer le contenu avec toutes les relations
            $contenu = Contenu::where('statut', 'publié')
                ->with([
                    'typeContenu' => function($query) {
                        try { return $query->select('id_type_contenu', 'nom'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'langue' => function($query) {
                        try { return $query->select('id_langue', 'nom_langue'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'region' => function($query) {
                        try { return $query->select('id_region', 'nom_region'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'auteur' => function($query) {
                        try { return $query->select('id', 'name', 'email'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'media',
                    'paiements' => function($query) {
                        $query->where('user_id', Auth::id())
                            ->where('statut', 'completed');
                    }
                ])
                ->find($id);

            if (!$contenu) {
                Log::warning('Contenu non trouvé: ' . $id);
                return redirect()->route('client.contenus.index')
                    ->with('error', 'Contenu non trouvé ou non publié.');
            }

            Log::info('Contenu trouvé: ' . $contenu->titre);

            // Vérifier si l'utilisateur a déjà payé pour ce contenu
            $dejaPaye = false;
            if ($contenu->prix > 0) {
                $dejaPaye = $contenu->paiements->isNotEmpty();
            }

            // Récupérer les contenus similaires
            $relatedBooks = Contenu::where('statut', 'publié')
                ->where('id_contenu', '!=', $id)
                ->where('id_type_contenu', $contenu->id_type_contenu)
                ->with([
                    'typeContenu' => function($query) {
                        try { return $query->select('id_type_contenu', 'nom'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'auteur' => function($query) {
                        try { return $query->select('id', 'name'); } 
                        catch (\Exception $e) { return null; }
                    }
                ])
                ->take(8)
                ->get();

            return view('client.contenus.detail', compact('contenu', 'relatedBooks', 'dejaPaye'));

        } catch (\Exception $e) {
            Log::error('Contenu detail error: ' . $e->getMessage());
            return redirect()->route('client.contenus.index')
                ->with('error', 'Erreur lors du chargement du contenu.');
        }
    }

    /**
     * Page de paiement pour un contenu
     */
    public function contenusPaiement($id)
    {
        try {
            $contenu = Contenu::where('statut', 'publié')
                ->where('prix', '>', 0)
                ->with([
                    'typeContenu' => function($query) {
                        try { return $query->select('id_type_contenu', 'nom'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'auteur' => function($query) {
                        try { return $query->select('id', 'name'); } 
                        catch (\Exception $e) { return null; }
                    }
                ])
                ->find($id);

            if (!$contenu) {
                return redirect()->route('client.contenus.index')
                    ->with('error', 'Ce contenu n\'est pas disponible à l\'achat.');
            }

            // Vérifier si déjà payé
            $existingPayment = Paiement::where('user_id', Auth::id())
                ->where('contenu_id', $id)
                ->where('statut', 'completed')
                ->first();

            if ($existingPayment) {
                return redirect()->route('client.contenus.detail', $id)
                    ->with('info', 'Vous avez déjà acheté ce contenu.');
            }

            return view('client.contenus.paiement', compact('contenu'));

        } catch (\Exception $e) {
            Log::error('Contenu paiement error: ' . $e->getMessage());
            return redirect()->route('client.contenus.detail', $id)
                ->with('error', 'Ce contenu n\'est pas disponible à l\'achat.');
        }
    }

    /**
     * Traitement du paiement pour contenu
     */
    public function processContenuPaiement(Request $request, $id)
    {
        try {
            // Valider la requête
            $request->validate([
                'payment_method' => 'required|string',
                'card_number' => 'required_if:payment_method,card|string|size:16',
                'card_expiry' => 'required_if:payment_method,card|string',
                'card_cvc' => 'required_if:payment_method,card|string|size:3',
            ]);

            $contenu = Contenu::findOrFail($id);
            $user = Auth::user();

            // Simuler un paiement (à remplacer par une vraie intégration)
            $transactionId = 'PAY_' . strtoupper(uniqid());

            // Créer l'enregistrement de paiement
            $paiement = Paiement::create([
                'user_id' => $user->id,
                'contenu_id' => $id,
                'montant' => $contenu->prix,
                'statut' => 'completed',
                'transaction_id' => $transactionId,
                'payment_method' => $request->payment_method,
                'payment_details' => json_encode([
                    'method' => $request->payment_method,
                    'timestamp' => now(),
                    'user_ip' => $request->ip(),
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Paiement réussi', [
                'user_id' => $user->id,
                'contenu_id' => $id,
                'paiement_id' => $paiement->id,
                'transaction_id' => $transactionId
            ]);

            return redirect()->route('client.contenus.paiement.success', $id)
                ->with('success', 'Paiement effectué avec succès !');

        } catch (\Exception $e) {
            Log::error('Process paiement error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Page de succès après paiement
     */
    public function contenusPaiementSuccess($id)
    {
        try {
            $contenu = Contenu::findOrFail($id);
            return view('client.contenus.paiement-success', compact('contenu'));
        } catch (\Exception $e) {
            Log::error('Paiement success error: ' . $e->getMessage());
            return redirect()->route('client.contenus.index')
                ->with('error', 'Contenu non trouvé.');
        }
    }

    /**
     * Détails d'un livre (alias pour contenusDetail)
     */
    public function bookDetails($id)
    {
        return $this->contenusDetail($id);
    }

    /**
     * Lire un livre
     */
    public function readBook($id, Request $request)
    {
        try {
            $contenu = Contenu::where('statut', 'publié')
                ->where('id_contenu', $id)
                ->with(['media'])
                ->firstOrFail();

            // Vérifier si l'utilisateur a accès (gratuit ou payé)
            if ($contenu->prix > 0) {
                $paiement = Paiement::where('user_id', Auth::id())
                    ->where('contenu_id', $id)
                    ->where('statut', 'completed')
                    ->first();

                if (!$paiement) {
                    return redirect()->route('client.contenus.paiement', $id)
                        ->with('error', 'Vous devez acheter ce contenu pour le lire.');
                }
            }

            $currentPage = $request->query('page', 1);
            $totalPages = ceil(str_word_count($contenu->texte) / 250); // Estimation

            // Simuler le contenu paginé
            $words = str_word_count($contenu->texte, 1);
            $wordsPerPage = 250;
            $start = ($currentPage - 1) * $wordsPerPage;
            $pageWords = array_slice($words, $start, $wordsPerPage);
            $content = implode(' ', $pageWords);

            return view('client.contenus.read', compact('contenu', 'currentPage', 'totalPages', 'content'));

        } catch (\Exception $e) {
            Log::error('Read book error: ' . $e->getMessage());
            return redirect()->route('client.contenus.index')
                ->with('error', 'Impossible de lire ce livre.');
        }
    }

    /**
     * Page de contribution
     */
    public function contribute()
    {
        try {
            $typesContenu = $this->getTypeContenus();
            $langues = $this->getLangues();
            $regions = $this->getRegions();

            return view('client.contribute.index', compact('typesContenu', 'langues', 'regions'));
        } catch (\Exception $e) {
            Log::error('Contribute error: ' . $e->getMessage());
            return view('client.contribute.index', [
                'typesContenu' => collect([]),
                'langues' => collect([]),
                'regions' => collect([])
            ]);
        }
    }

    /**
     * Liste des médias
     */
    public function mediaIndex()
    {
        try {
            $medias = Media::whereIn('type_fichier', ['image', 'video'])
                ->with([
                    'contenu' => function($query) {
                        try { return $query->select('id_contenu', 'titre'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'utilisateur' => function($query) {
                        try { return $query->select('id', 'name'); } 
                        catch (\Exception $e) { return null; }
                    }
                ])
                ->orderBy('created_at', 'asc')
                ->paginate(12);

            return view('client.media.index', ['images' => $medias]);

        } catch (\Exception $e) {
            Log::error('Media index error: ' . $e->getMessage());
            return view('client.media.index', ['images' => collect([])]);
        }
    }

    /**
     * Détail d'un média
     */
    public function mediaDetail($id)
    {
        try {
            Log::info('=== MEDIA DETAIL START ===');
            Log::info('Media ID: ' . $id);
            Log::info('User ID: ' . Auth::id());

            $media = Media::with([
                'contenu' => function($query) {
                    try { return $query->select('id_contenu', 'titre'); } 
                    catch (\Exception $e) { return null; }
                },
                'utilisateur' => function($query) {
                    try { return $query->select('id', 'name'); } 
                    catch (\Exception $e) { return null; }
                },
                'paiements' => function($query) {
                    $query->where('user_id', Auth::id())
                        ->where('statut', 'completed');
                }
            ])->findOrFail($id);

            Log::info('Media trouvé: ' . ($media->titre ?? $media->nom_fichier));

            // Vérifier si l'utilisateur a déjà payé pour ce média
            $dejaPaye = false;
            if ($media->prix > 0) {
                $dejaPaye = $media->paiements->isNotEmpty();
            }

            return view('client.media.detail', compact('media', 'dejaPaye'));

        } catch (\Exception $e) {
            Log::error('Media detail error: ' . $e->getMessage());
            return redirect()->route('client.media.index')
                ->with('error', 'Média non trouvé.');
        }
    }

    /**
     * Formulaire de création de contenu
     */
    public function create()
    {
        try {
            $typesContenu = $this->getTypeContenus();
            $langues = $this->getLangues();
            $regions = $this->getRegions();

            return view('client.contenus.create', compact('typesContenu', 'langues', 'regions'));
        } catch (\Exception $e) {
            Log::error('Create form error: ' . $e->getMessage());
            return view('client.contenus.create', [
                'typesContenu' => collect([]),
                'langues' => collect([]),
                'regions' => collect([])
            ]);
        }
    }

    /**
     * Stocker un nouveau contenu
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'texte' => 'required|string',
                'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
                'id_langue' => 'required|exists:langues,id_langue',
                'id_region' => 'required|exists:regions,id_region',
                'prix' => 'nullable|numeric|min:0',
                'couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Gérer l'upload de l'image de couverture
            $couverturePath = null;
            if ($request->hasFile('couverture')) {
                $couverturePath = $request->file('couverture')->store('couvertures', 'public');
            }

            // Création du contenu
            $contenu = Contenu::create([
                'titre' => $validated['titre'],
                'texte' => $validated['texte'],
                'id_type_contenu' => $validated['id_type_contenu'],
                'id_langue' => $validated['id_langue'],
                'id_region' => $validated['id_region'],
                'id_auteur' => Auth::id(),
                'date_creation' => now(),
                'prix' => $validated['prix'] ?? 0,
                'couverture' => $couverturePath,
                'statut' => 'en attente',
            ]);

            return redirect()->route('client.contenus.manage')
                ->with('success', 'Contenu créé avec succès ! Il sera publié après validation.');

        } catch (\Exception $e) {
            Log::error('Store contenu error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du contenu: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les statistiques
     */
    public function getStats()
    {
        try {
            $stats = [
                'totalContenus' => Contenu::count(),
                'totalMedias' => Media::count(),
                'totalUtilisateurs' => User::count(),
                'contenusPublies' => Contenu::where('statut', 'publié')->count(),
                'contenusEnAttente' => Contenu::where('statut', 'en attente')->count(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Get stats error: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors du calcul des statistiques'], 500);
        }
    }

    /**
     * Upload de média
     */
    public function uploadMedia(Request $request)
    {
        try {
            $request->validate([
                'media' => 'required|file|max:10240',
                'titre' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'prix' => 'nullable|numeric|min:0',
                'id_contenu' => 'nullable|exists:contenus,id_contenu',
            ]);

            // Logique d'upload
            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                $path = $file->storeAs('media', $fileName, 'public');

                // Déterminer le type de fichier
                $typeFichier = $this->determineFileType($extension);

                // Créer le média
                $media = Media::create([
                    'nom_fichier' => $file->getClientOriginalName(),
                    'chemin_fichier' => $path,
                    'type_fichier' => $typeFichier,
                    'extension' => $extension,
                    'taille_fichier' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'titre' => $request->titre,
                    'description' => $request->description,
                    'prix' => $request->prix ?? 0,
                    'id_contenu' => $request->id_contenu,
                    'id_utilisateur' => Auth::id(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Média uploadé avec succès',
                    'media' => $media
                ]);
            }

            return response()->json(['error' => 'Aucun fichier'], 400);

        } catch (\Exception $e) {
            Log::error('Upload media error: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'upload'], 500);
        }
    }

    /**
     * Déterminer le type de fichier
     */
    private function determineFileType($extension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];
        $documentExtensions = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'];
        $audioExtensions = ['mp3', 'wav', 'ogg', 'm4a'];
        $livreExtensions = ['epub', 'mobi', 'azw'];

        $ext = strtolower($extension);
        
        if (in_array($ext, $imageExtensions)) return 'image';
        if (in_array($ext, $videoExtensions)) return 'video';
        if (in_array($ext, $documentExtensions)) return 'document';
        if (in_array($ext, $audioExtensions)) return 'audio';
        if (in_array($ext, $livreExtensions)) return 'livre';

        return 'autre';
    }

    /**
     * Liste des utilisateurs
     */
    public function usersIndex()
    {
        try {
            $users = User::orderBy('created_at', 'asc')->get();
            return view('client.users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Users index error: ' . $e->getMessage());
            return view('client.users.index', ['users' => collect([])]);
        }
    }

    /**
     * Liste des langues
     */
    public function languagesIndex()
    {
        try {
            $languages = $this->getLangues();
            return view('client.languages.index', compact('languages'));
        } catch (\Exception $e) {
            Log::error('Languages index error: ' . $e->getMessage());
            return view('client.languages.index', ['languages' => collect([])]);
        }
    }

    /**
     * Détail d'une langue
     */
    public function languageDetail($id)
    {
        try {
            $langue = Langue::findOrFail($id);
            $contenus = Contenu::where('id_langue', $id)
                ->where('statut', 'publié')
                ->with([
                    'typeContenu' => function($query) {
                        try { return $query->select('id_type_contenu', 'nom'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'auteur' => function($query) {
                        try { return $query->select('id', 'name'); } 
                        catch (\Exception $e) { return null; }
                    }
                ])
                ->paginate(12);

            return view('client.languages.detail', compact('langue', 'contenus'));
        } catch (\Exception $e) {
            Log::error('Language detail error: ' . $e->getMessage());
            return redirect()->route('client.languages.index')
                ->with('error', 'Langue non trouvée.');
        }
    }

    /**
     * Liste des régions
     */
    public function regionsIndex()
    {
        try {
            $regions = $this->getRegions();
            return view('client.regions.index', compact('regions'));
        } catch (\Exception $e) {
            Log::error('Regions index error: ' . $e->getMessage());
            return view('client.regions.index', ['regions' => collect([])]);
        }
    }

    /**
     * Détail d'une région
     */
    public function regionDetail($id)
    {
        try {
            $region = Region::findOrFail($id);
            $contenus = Contenu::where('id_region', $id)
                ->where('statut', 'publié')
                ->with([
                    'typeContenu' => function($query) {
                        try { return $query->select('id_type_contenu', 'nom'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'auteur' => function($query) {
                        try { return $query->select('id', 'name'); } 
                        catch (\Exception $e) { return null; }
                    },
                    'langue' => function($query) {
                        try { return $query->select('id_langue', 'nom_langue'); } 
                        catch (\Exception $e) { return null; }
                    }
                ])
                ->paginate(12);

            return view('client.regions.detail', compact('region', 'contenus'));
        } catch (\Exception $e) {
            Log::error('Region detail error: ' . $e->getMessage());
            return redirect()->route('client.regions.index')
                ->with('error', 'Région non trouvée.');
        }
    }

    /**
     * Télécharger un contenu
     */
    public function downloadContenu($id)
    {
        try {
            $contenu = Contenu::where('statut', 'publié')
                ->with(['media'])
                ->findOrFail($id);

            // Vérifier les droits d'accès
            if ($contenu->prix > 0) {
                $paiement = Paiement::where('user_id', Auth::id())
                    ->where('contenu_id', $id)
                    ->where('statut', 'completed')
                    ->first();

                if (!$paiement) {
                    return redirect()->route('client.contenus.paiement', $id)
                        ->with('error', 'Vous devez acheter ce contenu pour le télécharger.');
                }
            }

            // Créer un fichier texte avec le contenu
            $fileName = Str::slug($contenu->titre) . '.txt';
            $fileContent = "Titre: {$contenu->titre}\n\n";
            $fileContent .= "Contenu:\n{$contenu->texte}\n\n";
            
            if ($contenu->auteur) {
                $fileContent .= "Auteur: {$contenu->auteur->name}\n";
            }
            
            if ($contenu->date_creation) {
                $fileContent .= "Date: {$contenu->date_creation->format('d/m/Y')}\n";
            }

            // Créer le fichier temporaire
            $tempPath = storage_path('app/public/temp/' . $fileName);
            file_put_contents($tempPath, $fileContent);

            // Télécharger le fichier
            return response()->download($tempPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Download contenu error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors du téléchargement: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les régions avec gestion d'erreurs
     */
    private function getRegions()
    {
        try {
            if (class_exists('App\Models\Region')) {
                return Region::orderBy('nom_region', 'asc')->get();
            }
            return collect([]);
        } catch (\Exception $e) {
            Log::warning('Cannot load regions: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Obtenir les langues avec gestion d'erreurs
     */
    private function getLangues()
    {
        try {
            if (class_exists('App\Models\Langue')) {
                return Langue::orderBy('nom_langue', 'asc')->get();
            }
            return collect([]);
        } catch (\Exception $e) {
            Log::warning('Cannot load langues: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Obtenir les types de contenu avec gestion d'erreurs
     */
    private function getTypeContenus()
    {
        try {
            if (class_exists('App\Models\TypeContenu')) {
                return TypeContenu::orderBy('nom', 'asc')->get();
            }
            return collect([]);
        } catch (\Exception $e) {
            Log::warning('Cannot load type contenus: ' . $e->getMessage());
            return collect([]);
        }
    }
}