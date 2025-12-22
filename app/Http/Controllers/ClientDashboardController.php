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
            $recentContents = Contenu::where('statut', 'publie')
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
                'contents' => Contenu::where('statut', '!=', 'supprime')->count(),
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
            $livres = Contenu::where('statut', 'publie')
                ->whereHas('typeContenu', function($query) {
                    $query->where('nom', 'LIKE', '%livre%')->orWhere('id_type_contenu', 1);
                })
                ->take(5)
                ->get();

            return view('client.dashboard', compact(
                'user', 'stats', 'recentContents', 'livres', 'medias', 'contenusRecents'
            ));

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return view('client.dashboard', [
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
            ])
            ->where('statut', '!=', 'supprime')
            ->orderBy('date_creation', 'desc')
            ->paginate(20);

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
            $statut = $request->input('status', 'publie');
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

            // Filtre par prix
            $price = $request->input('price', 'all');
            if ($price === 'free') {
                $query->where(function($q) {
                    $q->where('prix', 0)
                      ->orWhereNull('prix');
                });
            } elseif ($price === 'paid') {
                $query->where('prix', '>', 0);
            }

            // Filtre par date
            $date = $request->input('date');
            if ($date) {
                switch ($date) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year);
                        break;
                }
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
                        ->where('statut', 'publie')
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
            // Récupérer le contenu avec toutes les relations
            $contenu = Contenu::with([
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
                    ->with('error', 'Contenu non trouvé.');
            }

            // Vérifier si le contenu est accessible (publié ou auteur)
            if ($contenu->statut !== 'publie' && Auth::id() !== $contenu->id_auteur) {
                 Log::warning('Accès refusé au contenu non publié: ' . $id);
                 return redirect()->route('client.contenus.index')
                    ->with('error', 'Ce contenu n\'est pas encore public.');
            }

            // Vérifier si le contenu est payant et si l'utilisateur a payé
            if ($contenu->prix > 0) {
                $dejaPaye = $contenu->paiements->isNotEmpty();
                
                // Exception: l'auteur et les admins ont toujours accès
                $isAuteur = (Auth::id() === $contenu->id_auteur);
                $isAdmin = (Auth::user()->role === 'admin' || Auth::user()->role === 'moderateur');
                
                if (!$dejaPaye && !$isAuteur && !$isAdmin) {
                    Log::info('Redirection vers paiement pour contenu payant non payé');
                    return redirect()->route('client.contenus.paiement', $id)
                        ->with('info', 'Ce contenu est payant. Veuillez effectuer le paiement pour y accéder.');
                }
            }

            // Enregistrer la vue si l'utilisateur est connecté
            if (Auth::check()) {
                try {
                    \App\Models\View::create([
                        'user_id' => Auth::id(),
                        'id_contenu' => $id
                    ]);
                } catch (\Exception $e) {
                    // Ignorer les erreurs d'enregistrement de vue pour ne pas bloquer l'affichage
                    Log::error('Erreur enregistrement vue: ' . $e->getMessage());
                }
            }

            Log::info('Contenu trouvé: ' . $contenu->titre);

            // Vérifier si l'utilisateur a déjà payé pour ce contenu
            $dejaPaye = false;
            if ($contenu->prix > 0) {
                $dejaPaye = $contenu->paiements->isNotEmpty();
            }

            // Récupérer les contenus similaires
            $relatedBooks = Contenu::where('statut', 'publie')
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
            
            // Préparer l'URL du PDF si c'est un document
            $pdfUrl = null;
            if ($contenu->media->isNotEmpty()) {
                $document = $contenu->media->first(function($m) {
                    return $m->isDocument() || $m->isLivre() || $m->type_fichier === 'pdf';
                });
                if ($document) {
                    $pdfUrl = asset('storage/' . $document->chemin_fichier);
                }
            }

            return view('client.contenus.detail', compact('contenu', 'relatedBooks', 'dejaPaye', 'pdfUrl'));

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
            Log::info('--- Contenus Paiement Request ---', ['id' => $id, 'user_id' => Auth::id()]);
            
            $contenu = Contenu::where('statut', 'publie')
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
        /**
     * Traitement du paiement pour contenu avec FedaPay
     */
    public function processContenuPaiement(Request $request, $id)
    {
        try {
            $contenu = Contenu::findOrFail($id);
            $user = Auth::user();

            // Configuration FedaPay
            \FedaPay\FedaPay::setApiKey('sk_sandbox_84rTs3kVKX2nk47Grg2holt7');
            \FedaPay\FedaPay::setEnvironment('sandbox');

            // Créer la transaction
            $transaction = \FedaPay\Transaction::create([
                "description" => "Achat contenu: " . $contenu->titre,
                "amount" => (int)$contenu->prix,
                "currency" => ["iso" => "XOF"],
                "callback_url" => route('client.contenus.paiement.success', ['id' => $id]),
                "customer" => [
                    "firstname" => $user->name,
                    "lastname" => "",
                    "email" => $user->email,
                    "phone_number" => [
                        "number" => "90000000", // Numéro par défaut ou à demander
                        "country" => "bj"
                    ]
                ]
            ]);

            // Générer le token de paiement (lien)
            $token = $transaction->generateToken();
            
            return redirect($token->url);

        } catch (\Exception $e) {
            Log::error('FedaPay Process Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'initialisation du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Page de succès après paiement
     */
    public function contenusPaiementSuccess(Request $request, $id)
    {
        try {
            // Log all request parameters for debugging
            Log::info('=== Payment Success Callback ===', [
                'contenu_id' => $id,
                'all_params' => $request->all(),
                'query_params' => $request->query(),
                'user_id' => Auth::id()
            ]);

            $contenu = Contenu::findOrFail($id);
            $user = Auth::user();
            
            // FedaPay renvoie le statut et l'ID de la transaction
            $status = $request->input('status');
            $transactionId = $request->input('id'); // ID de la transaction FedaPay

            Log::info('Payment callback details', [
                'status' => $status,
                'transaction_id' => $transactionId
            ]);

            if ($status === 'approved') {
                // Vérifier si le paiement existe déjà pour éviter les doublons
                $existingPayment = Paiement::where('transaction_id', $transactionId)->first();

                if (!$existingPayment) {
                    // Enregistrer le paiement
                    $paiement = Paiement::create([
                        'user_id' => $user->id,
                        'contenu_id' => $id,
                        'montant' => $contenu->prix,
                        'statut' => 'completed',
                        'transaction_id' => $transactionId,
                        'payment_method' => 'fedapay',
                        'payment_details' => json_encode([
                            'method' => 'fedapay',
                            'transaction_id' => $transactionId,
                            'timestamp' => now()
                        ]),
                    ]);

                    Log::info('Payment record created', ['paiement_id' => $paiement->id]);
                }

                return view('client.contenus.paiement-success', compact('contenu'));
            } else {
                 Log::warning('Payment not approved', ['status' => $status]);
                 return redirect()->route('client.contenus.detail', $id)
                    ->with('error', 'Le paiement a échoué ou a été annulé.');
            }

        } catch (\Exception $e) {
            Log::error('Paiement success error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return redirect()->route('client.contenus.index')
                ->with('error', 'Erreur lors de la vérification du paiement.');
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
    /**
     * Lire un livre
     */
    public function readBook($id, Request $request)
    {
        try {
            $contenu = Contenu::where('statut', 'publie')
                ->where('id_contenu', $id)
                ->with(['media'])
                ->firstOrFail();

            // Vérifier si l'utilisateur a accès (gratuit ou payé)
            if ($contenu->prix > 0) {
                // Auteur et Admin ont toujours accès
                $isAuteur = (Auth::id() === $contenu->id_auteur);
                $isAdmin = (Auth::user()->role === 'admin' || Auth::user()->role === 'moderateur');

                if (!$isAuteur && !$isAdmin) {
                    $paiement = Paiement::where('user_id', Auth::id())
                        ->where('contenu_id', $id)
                        ->where('statut', 'completed')
                        ->first();

                    if (!$paiement) {
                        return redirect()->route('client.contenus.paiement', $id)
                            ->with('error', 'Vous devez acheter ce contenu pour le lire.');
                    }
                }
            }
            
            // Chercher un fichier PDF/Document pour lecture
            $pdfMedia = $contenu->media->first(function ($media) {
                return in_array(strtolower($media->extension), ['pdf']);
            });

            $pdfUrl = null;
            if ($pdfMedia) {
                $pdfUrl = asset('storage/' . $pdfMedia->chemin_fichier);
            }

            // Logique de pagination pour le texte brut (fallback ou contenu texte principal)
            $currentPage = $request->query('page', 1);
            $wordsPerPage = 250;
            $words = str_word_count($contenu->texte, 1);
            $totalPages = ceil(count($words) / $wordsPerPage);
            if ($totalPages < 1) $totalPages = 1;

            $start = ($currentPage - 1) * $wordsPerPage;
            $pageWords = array_slice($words, $start, $wordsPerPage);
            $content = implode(' ', $pageWords);

            return view('client.contenus.read', compact('contenu', 'currentPage', 'totalPages', 'content', 'pdfUrl'));

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
            $medias = Media::whereIn('type_fichier', ['image', 'video', 'audio'])
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
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return view('client.media.index', ['images' => $medias]);

        } catch (\Exception $e) {
            Log::error('Media index error: ' . $e->getMessage());
            return view('client.media.index', ['images' => collect([])]);
        }
    }

    /**
     * Liste des vidéos
     */
    public function mediaVideo()
    {
        try {
            $videos = Media::where('type_fichier', 'video')
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
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return view('client.media.video', ['videos' => $videos]);

        } catch (\Exception $e) {
            Log::error('Media video error: ' . $e->getMessage());
            return redirect()->route('client.dashboard')->with('error', 'Erreur chargement vidéos');
        }
    }

    /**
     * Liste des audios
     */
    public function mediaAudio()
    {
        try {
            $audios = Media::where('type_fichier', 'audio')
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
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('client.media.audio', ['audios' => $audios]);

        } catch (\Exception $e) {
            Log::error('Media audio error: ' . $e->getMessage());
            return redirect()->route('client.dashboard')->with('error', 'Erreur chargement audios');
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
     * Page de paiement pour un média
     */
    public function mediaPaiement($id)
    {
        try {
            $media = Media::where('prix', '>', 0)->findOrFail($id);

            // Vérifier si déjà payé
            $existingPayment = Paiement::where('user_id', Auth::id())
                ->where('media_id', $id)
                ->where('statut', 'completed')
                ->first();

            if ($existingPayment) {
                return redirect()->route('client.media.detail', $id)
                    ->with('info', 'Vous avez déjà acheté ce média.');
            }

            return view('client.media.paiement', compact('media'));

        } catch (\Exception $e) {
            Log::error('Media paiement error: ' . $e->getMessage());
            return redirect()->route('client.media.detail', $id)
                ->with('error', 'Ce média n\'est pas disponible à l\'achat.');
        }
    }

    /**
     * Traitement du paiement pour média
     */
    public function processMediaPaiement(Request $request, $id)
    {
        try {
            $request->validate([
                'payment_method' => 'required|string',
                'card_number' => 'required_if:payment_method,card|string|size:16',
                'card_expiry' => 'required_if:payment_method,card|string',
                'card_cvc' => 'required_if:payment_method,card|string|size:3',
            ]);

            $media = Media::findOrFail($id);
            $user = Auth::user();

            // Simuler un paiement
            $transactionId = 'PAY_MEDIA_' . strtoupper(uniqid());

            // Créer l'enregistrement de paiement
            $paiement = Paiement::create([
                'user_id' => $user->id,
                'media_id' => $id,
                'montant' => $media->prix,
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

            return redirect()->route('client.media.paiement.success', $id)
                ->with('success', 'Paiement effectué avec succès !');

        } catch (\Exception $e) {
            Log::error('Process media paiement error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Page de succès après paiement média
     */
    public function mediaPaiementSuccess($id)
    {
        try {
            $media = Media::findOrFail($id);
            return view('client.media.paiement-success', compact('media'));
        } catch (\Exception $e) {
            Log::error('Media paiement success error: ' . $e->getMessage());
            return redirect()->route('client.media.index')
                ->with('error', 'Média non trouvé.');
        }
    }

    /**
     * Télécharger un média
     */
    public function downloadMedia($id)
    {
        try {
            $media = Media::findOrFail($id);

            // Vérifier les droits d'accès
            if ($media->prix > 0) {
                // Auteur et Admin ont toujours accès
                $isAuteur = (Auth::id() === $media->id_utilisateur);
                $isAdmin = (Auth::user()->role === 'admin' || Auth::user()->role === 'moderateur');

                if (!$isAuteur && !$isAdmin) {
                    $paiement = Paiement::where('user_id', Auth::id())
                        ->where('media_id', $id)
                        ->where('statut', 'completed')
                        ->first();

                    if (!$paiement) {
                        return redirect()->route('client.media.paiement', $id)
                            ->with('error', 'Vous devez acheter ce média pour le télécharger.');
                    }
                }
            }

            if (Storage::disk('public')->exists($media->chemin_fichier)) {
                return Storage::disk('public')->download(
                    $media->chemin_fichier, 
                    $media->nom_fichier
                );
            }

            return redirect()->back()->with('error', 'Fichier introuvable.');

        } catch (\Exception $e) {
            Log::error('Download media error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors du téléchargement.');
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
                'contenusPublies' => Contenu::where('statut', 'publie')->count(),
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
     * Paramètres du compte client
     */
    public function accountSettings()
    {
        try {
            $user = Auth::user();
            return view('client.settings.account', compact('user'));
        } catch (\Exception $e) {
            Log::error('Account settings error: ' . $e->getMessage());
            return redirect()->route('client.dashboard')
                ->with('error', 'Impossible d\'accéder aux paramètres du compte.');
        }
    }

    /**
     * Paramètres généraux du client
     */
    public function clientSettings()
    {
        return redirect()->route('client.settings.account');
    }

    /**
     * Paramètres de notifications
     */
    public function notificationSettings()
    {
        // À implémenter : vue spécifique si nécessaire
        return redirect()->route('client.settings.account')
            ->with('info', 'Les paramètres de notification seront bientôt disponibles.');
    }

    /**
     * Paramètres de confidentialité
     */
    public function privacySettings()
    {
        // À implémenter : vue spécifique si nécessaire
        return redirect()->route('client.settings.account')
            ->with('info', 'Les paramètres de confidentialité seront bientôt disponibles.');
    }

    /**
     * Mise à jour des paramètres client
     */
    public function updateClientSettings(Request $request, $section)
    {
        try {
            $user = Auth::user();

            if ($section === 'profile') {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                    'sexe' => 'nullable|in:M,F,Autre',
                    'age' => 'nullable|integer|min:0|max:120',
                    'langue' => 'nullable|string|in:fr,en,fon,yor',
                    'photo' => 'nullable|image|max:1024',
                    'current_password' => 'nullable|required_with:password|current_password',
                    'password' => 'nullable|string|min:8|confirmed',
                ]);

                // Mise à jour des infos de base
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->sexe = $validated['sexe'] ?? null;
                $user->age = $validated['age'] ?? null;
                $user->langue = $validated['langue'] ?? 'fr';
                
                // DEBUG SPECIFIQUE
                $debugData = [
                    'timestamp' => now()->toDateTimeString(),
                    'request_all' => $request->all(),
                    'files_superglobal' => $_FILES,
                    'has_photo' => $request->hasFile('photo'),
                    'validated' => $validated,
                    'user_attributes' => $user->getAttributes()
                ];
                file_put_contents(public_path('debug_log.txt'), print_r($debugData, true) . "\n\n", FILE_APPEND);

                // Mise à jour de la photo
                if ($request->hasFile('photo')) {
                    if ($user->profile_photo_path) {
                        Storage::disk('public')->delete($user->profile_photo_path);
                    }
                    $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
                }

                // Mise à jour du mot de passe
                if (!empty($validated['password'])) {
                    $user->password = bcrypt($validated['password']);
                }

                $saved = $user->save();
                $user->refresh(); // Force reload from DB
                
                // DEBUG SPECIFIQUE FINALE
                $debugData['saved_status'] = $saved;
                $debugData['user_after_save'] = $user->toArray();
                file_put_contents(public_path('debug_log.txt'), print_r($debugData, true) . "\n\n", FILE_APPEND);

                return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
            }

            return redirect()->back()->with('error', 'Section de paramètres inconnue.');

        } catch (\Exception $e) {
            Log::error('Update settings error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

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
     * Détail d'un utilisateur
     */
    public function userDetail($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('client.users.detail', compact('user'));
        } catch (\Exception $e) {
            Log::error('User detail error: ' . $e->getMessage());
            return redirect()->route('client.users.index')
                ->with('error', 'Utilisateur non trouvé.');
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
                ->where('statut', 'publie')
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
                ->where('statut', 'publie')
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
    /**
     * Télécharger un contenu
     */
    public function downloadContenu($id)
    {
        try {
            $contenu = Contenu::where('statut', 'publie')
                ->with([
                    'media',
                    'paiements' => function($query) {
                        $query->where('user_id', Auth::id())
                              ->where('statut', 'completed');
                    },
                    'auteur'
                ])
                ->findOrFail($id);

            Log::info('=== DOWNLOAD CONTENU ===', [
                'contenu_id' => $id,
                'prix' => $contenu->prix,
                'user_id' => Auth::id(),
                'paiements_count' => $contenu->paiements->count()
            ]);

            // Vérifier les droits d'accès
            if ($contenu->prix > 0) {
                Log::info('Contenu payant détecté', ['prix' => $contenu->prix]);
                
                // Pour l'auteur lui-même ou un admin, l'accès est toujours autorisé
                $isAuteur = (Auth::id() === $contenu->id_auteur);
                $isAdmin = (Auth::user()->role === 'admin' || Auth::user()->role === 'moderateur');
                
                Log::info('Vérification des droits', [
                    'isAuteur' => $isAuteur,
                    'isAdmin' => $isAdmin
                ]);
                
                if (!$isAuteur && !$isAdmin) {
                    // Vérifier si l'utilisateur a déjà payé
                    $dejaPaye = $contenu->paiements->isNotEmpty();
                    
                    Log::info('Vérification paiement', [
                        'dejaPaye' => $dejaPaye,
                        'paiements' => $contenu->paiements->toArray()
                    ]);

                    if (!$dejaPaye) {
                        Log::warning('Tentative de téléchargement sans paiement');
                        return redirect()->route('client.contenus.paiement', $id)
                            ->with('info', 'Ce contenu est payant. Veuillez effectuer le paiement pour le télécharger.');
                    }
                }
            }

            // Chercher un fichier joint (PDF, Doc, etc.)
            $mediaDocument = $contenu->media->first(function ($media) {
                return in_array($media->type_fichier, ['document', 'livre', 'video', 'audio']);
            });

            if ($mediaDocument && Storage::disk('public')->exists($mediaDocument->chemin_fichier)) {
                return Storage::disk('public')->download(
                    $mediaDocument->chemin_fichier, 
                    $mediaDocument->nom_fichier
                );
            }

            // Fallback: Créer un fichier texte si aucun média n'est associé mais qu'il y a du texte
            if (!empty($contenu->texte)) {
                $fileName = Str::slug($contenu->titre) . '.txt';
                $fileContent = "Titre: {$contenu->titre}\n\n";
                $fileContent .= "Auteur: " . ($contenu->auteur->name ?? 'Inconnu') . "\n\n";
                $fileContent .= strip_tags($contenu->texte);

                $tempPath = 'temp/' . $fileName;
                Storage::disk('public')->put($tempPath, $fileContent);
                
                return Storage::disk('public')->download($tempPath)->deleteFileAfterSend(true);
            }

            return redirect()->back()->with('error', 'Aucun fichier disponible pour ce contenu.');

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
     * Bibliothèque
     */
    public function library()
    {
        return view('client.library.index');
    }

    /**
     * Bibliothèque - Contenus
     */
    public function libraryContenus()
    {
        return view('client.library.index');
    }

    /**
     * Bibliothèque - Médias
     */
    public function libraryMedia()
    {
        return view('client.library.index');
    }

    /**
     * Favoris (Contenus les plus vus par l'utilisateur)
     */
    public function favorites()
    {
        try {
            $userId = Auth::id();
            
            // Récupérer les ID des contenus les plus vus
            $topViewedIds = \App\Models\View::where('user_id', $userId)
                ->select('id_contenu', DB::raw('count(*) as total'))
                ->groupBy('id_contenu')
                ->orderByDesc('total')
                ->take(20) // Top 20
                ->pluck('id_contenu');
            
            // Récupérer les détails des contenus
            // Note: whereIn ne garantit pas l'ordre, donc on doit trier manuellement si on veut l'ordre exact des vues
            $contenus = Contenu::whereIn('id_contenu', $topViewedIds)
                ->with(['auteur', 'media', 'typeContenu'])
                ->get()
                ->sortBy(function($model) use ($topViewedIds) {
                    return array_search($model->id_contenu, $topViewedIds->toArray());
                });

            return view('client.library.favorites', compact('contenus'));
        } catch (\Exception $e) {
            Log::error('Favorites error: ' . $e->getMessage());
            return view('client.library.favorites', ['contenus' => collect([])]);
        }
    }

    /**
     * Basculer favori (Stub)
     */
    public function toggleFavorite($type, $id)
    {
        // À implémenter avec une table favoris
        return response()->json(['success' => true]);
    }

    /**
     * Voir tous les avis de la médiathèque
     */
    public function mediaReviews()
    {
        try {
            $reviews = \App\Models\Commentaire::with(['user', 'contenu'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            return view('client.media.reviews', compact('reviews'));
        } catch (\Exception $e) {
            Log::error('Media reviews error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible de charger les avis.');
        }
    }

    /**
     * Ajouter un commentaire via API
     */
    public function apiAddComment(Request $request, $type, $id)
    {
        try {
            $request->validate([
                'texte' => 'required|string|max:1000',
                'note' => 'nullable|integer|min:1|max:5'
            ]);

            $commentaire = \App\Models\Commentaire::create([
                'texte' => $request->texte,
                'note' => $request->note,
                'id_contenu' => $id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre commentaire !',
                'comment' => $commentaire->load('user')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ajouter une note via API
     */
    public function apiAddRating(Request $request, $type, $id)
    {
        return $this->apiAddComment($request, $type, $id);
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