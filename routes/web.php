<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\TypeContenuController;
use App\Http\Controllers\PublicController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route d'accueil
Route::get('/', function () {
    return view('home');
})->name('home');

// Route de redirection après connexion
Route::get('/redirect', [AuthController::class, 'redirectToDashboard'])->name('redirect');

// Les routes d'authentification sont gérées par routes/auth.php

// Routes publiques pour les catégories culturelles
Route::get('/musique', [PublicController::class, 'musique'])->name('musique');
Route::get('/danse', [PublicController::class, 'danse'])->name('danse');
Route::get('/art', [PublicController::class, 'art'])->name('art');
Route::get('/art-rue', [PublicController::class, 'artRue'])->name('art-rue');
Route::get('/histoire', [PublicController::class, 'histoire'])->name('histoire');
Route::get('/gastronomie', [PublicController::class, 'gastronomie'])->name('gastronomie');
Route::get('/mode', [PublicController::class, 'mode'])->name('mode');
Route::get('/themes', [PublicController::class, 'themes'])->name('themes');
Route::get('/theme/{slug}', [PublicController::class, 'themeDetail'])->name('theme.detail');

// Routes accessibles après vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {
    // Routes du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes pour les contenus (accès public mais avec authentification)
    Route::prefix('contenus')->name('contenus.')->group(function () {
        Route::get('/', [ContenuController::class, 'index'])->name('index');
        Route::get('/{id}', [ContenuController::class, 'show'])->name('show');
        Route::get('/{id}/read', [ContenuController::class, 'read'])->name('read');
        Route::get('/{id}/download', [ContenuController::class, 'download'])->name('download');
    });
    
    // Routes pour les médias (accès public mais avec authentification)
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('/{id}', [MediaController::class, 'show'])->name('show');
        Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
    });
    
    // Routes de paiement
    Route::prefix('paiement')->name('paiement.')->group(function () {
        Route::get('/{type}/{id}', [PaymentController::class, 'show'])->name('show');
        Route::post('/process/{type}/{id}', [PaymentController::class, 'process'])->name('process');
        Route::get('/success/{type}/{id}', [PaymentController::class, 'success'])->name('success');
        Route::get('/cancel/{type}/{id}', [PaymentController::class, 'cancel'])->name('cancel');
    });
});

// Routes du tableau de bord admin
Route::middleware(['auth', 'verified', 'check.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Tableau de bord admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Profil admin
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    
    // Gestion des utilisateurs (admin)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/activate', [UserController::class, 'activate'])->name('activate');
        Route::post('/{id}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
        Route::post('/{id}/make-admin', [UserController::class, 'makeAdmin'])->name('make-admin');
        Route::post('/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('remove-admin');
    });
    
    // Gestion des contenus (admin)
    Route::prefix('contenus')->name('contenus.')->group(function () {
        Route::get('/', [AdminController::class, 'contenusIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'createContenu'])->name('create');
        Route::post('/', [AdminController::class, 'storeContenu'])->name('store');
        Route::get('/{id}', [AdminController::class, 'showContenu'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'editContenu'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateContenu'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroyContenu'])->name('destroy');
        Route::post('/{id}/validate', [AdminController::class, 'validateContenu'])->name('validate');
        Route::post('/{id}/reject', [AdminController::class, 'rejectContenu'])->name('reject');
        Route::post('/{id}/publish', [AdminController::class, 'publishContenu'])->name('publish');
        Route::post('/{id}/unpublish', [AdminController::class, 'unpublishContenu'])->name('unpublish');
    });
    
    // Gestion des médias (admin)
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [AdminController::class, 'mediaIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'createMedia'])->name('create');
        Route::post('/', [AdminController::class, 'storeMedia'])->name('store');
        Route::get('/{id}', [AdminController::class, 'showMedia'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'editMedia'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateMedia'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroyMedia'])->name('destroy');
        Route::post('/{id}/approve', [AdminController::class, 'approveMedia'])->name('approve');
        Route::post('/{id}/reject', [AdminController::class, 'rejectMedia'])->name('reject');
    });
    
    // Gestion des langues (admin)
    Route::prefix('langues')->name('langues.')->group(function () {
        Route::get('/', [LangueController::class, 'index'])->name('index');
        Route::get('/create', [LangueController::class, 'create'])->name('create');
        Route::post('/', [LangueController::class, 'store'])->name('store');
        Route::get('/{langue}', [LangueController::class, 'show'])->name('show');
        Route::get('/{langue}/edit', [LangueController::class, 'edit'])->name('edit');
        Route::put('/{langue}', [LangueController::class, 'update'])->name('update');
        Route::delete('/{langue}', [LangueController::class, 'destroy'])->name('destroy');
    });
    
    // Gestion des régions (admin)
    Route::prefix('regions')->name('regions.')->group(function () {
        Route::get('/', [RegionController::class, 'index'])->name('index');
        Route::get('/create', [RegionController::class, 'create'])->name('create');
        Route::post('/', [RegionController::class, 'store'])->name('store');
        Route::get('/{region}', [RegionController::class, 'show'])->name('show');
        Route::get('/{region}/edit', [RegionController::class, 'edit'])->name('edit');
        Route::put('/{region}', [RegionController::class, 'update'])->name('update');
        Route::delete('/{region}', [RegionController::class, 'destroy'])->name('destroy');
    });
    
    // Gestion des types de contenu (admin)
    Route::prefix('types-contenu')->name('type_contenus.')->group(function () {
        Route::get('/', [TypeContenuController::class, 'index'])->name('index');
        Route::get('/create', [TypeContenuController::class, 'create'])->name('create');
        Route::post('/', [TypeContenuController::class, 'store'])->name('store');
        Route::get('/{typeContenu}', [TypeContenuController::class, 'show'])->name('show');
        Route::get('/{typeContenu}/edit', [TypeContenuController::class, 'edit'])->name('edit');
        Route::put('/{typeContenu}', [TypeContenuController::class, 'update'])->name('update');
        Route::delete('/{typeContenu}', [TypeContenuController::class, 'destroy'])->name('destroy');
    });
    
    // Modération (admin)
    Route::prefix('moderation')->name('moderation.')->group(function () {
        Route::get('/', [ModerationController::class, 'index'])->name('index');
        Route::get('/contenus', [ModerationController::class, 'contenus'])->name('contenus');
        Route::get('/media', [ModerationController::class, 'media'])->name('media');
        Route::get('/comments', [ModerationController::class, 'comments'])->name('comments');
        Route::post('/{type}/{id}/approve', [ModerationController::class, 'approve'])->name('approve');
        Route::post('/{type}/{id}/reject', [ModerationController::class, 'reject'])->name('reject');
        Route::post('/{type}/{id}/flag', [ModerationController::class, 'flag'])->name('flag');
        Route::post('/{type}/{id}/unflag', [ModerationController::class, 'unflag'])->name('unflag');
    });
    
    // Statistiques (admin)
    Route::prefix('statistics')->name('statistics.')->group(function () {
        Route::get('/', [AdminController::class, 'statistics'])->name('index');
        Route::get('/contenus', [AdminController::class, 'statisticsContenus'])->name('contenus');
        Route::get('/users', [AdminController::class, 'statisticsUsers'])->name('users');
        Route::get('/media', [AdminController::class, 'statisticsMedia'])->name('media');
        Route::get('/sales', [AdminController::class, 'statisticsSales'])->name('sales');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/export/{type}', [AdminController::class, 'exportData'])->name('export');
    });
    
    // Paramètres (admin)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminController::class, 'settings'])->name('index');
        Route::get('/general', [AdminController::class, 'generalSettings'])->name('general');
        Route::get('/payment', [AdminController::class, 'paymentSettings'])->name('payment');
        Route::get('/email', [AdminController::class, 'emailSettings'])->name('email');
        Route::get('/notifications', [AdminController::class, 'notificationSettings'])->name('notifications');
        Route::post('/update/{section}', [AdminController::class, 'updateSettings'])->name('update');
    });
});

// Routes du tableau de bord client
Route::middleware(['auth', 'verified', 'check.client'])->prefix('client')->name('client.')->group(function () {
    // Tableau de bord client
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des contenus (client)
    Route::prefix('contenus')->name('contenus.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'contenusIndex'])->name('index');
        Route::get('/manage', [ClientDashboardController::class, 'manage'])->name('manage');
        Route::get('/create', [ClientDashboardController::class, 'create'])->name('create');
        Route::post('/', [ClientDashboardController::class, 'store'])->name('store');
        Route::get('/{id}', [ClientDashboardController::class, 'contenusDetail'])->name('detail');
        Route::get('/{id}/edit', [ClientDashboardController::class, 'editContenu'])->name('edit');
        Route::put('/{id}', [ClientDashboardController::class, 'updateContenu'])->name('update');
        Route::delete('/{id}', [ClientDashboardController::class, 'destroyContenu'])->name('destroy');
        
        // Paiement pour contenus
        Route::get('/{id}/paiement', [ClientDashboardController::class, 'contenusPaiement'])->name('paiement');
        Route::post('/{id}/paiement', [ClientDashboardController::class, 'processContenuPaiement'])->name('paiement.process');
        Route::get('/{id}/paiement/success', [ClientDashboardController::class, 'contenusPaiementSuccess'])->name('paiement.success');
        Route::get('/{id}/download', [ClientDashboardController::class, 'downloadContenu'])->name('download');
        
        // Routes pour la lecture
        Route::get('/{id}/read', [ClientDashboardController::class, 'readBook'])->name('read');
        
        // Route d'alias pour compatibilité
        Route::get('/books/{id}', [ClientDashboardController::class, 'bookDetails'])->name('books.detail');
    });
    
    // Gestion des médias (client)
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'mediaIndex'])->name('index');
        Route::get('/video', [ClientDashboardController::class, 'mediaVideo'])->name('video');
        Route::get('/audio', [ClientDashboardController::class, 'mediaAudio'])->name('audio');
        Route::get('/reviews', [ClientDashboardController::class, 'mediaReviews'])->name('reviews');
        Route::get('/{id}', [ClientDashboardController::class, 'mediaDetail'])->name('detail');
        Route::post('/upload', [ClientDashboardController::class, 'uploadMedia'])->name('upload');
        
        // Paiement pour médias
        Route::get('/{id}/paiement', [ClientDashboardController::class, 'mediaPaiement'])->name('paiement');
        Route::post('/{id}/paiement', [ClientDashboardController::class, 'processMediaPaiement'])->name('paiement.process');
        Route::get('/{id}/paiement/success', [ClientDashboardController::class, 'mediaPaiementSuccess'])->name('paiement.success');
        Route::get('/{id}/download', [ClientDashboardController::class, 'downloadMedia'])->name('download');
    });
    
    // Contribution
    Route::prefix('contribute')->name('contribute.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'contribute'])->name('index');
        Route::get('/contenus', [ClientDashboardController::class, 'contributeContenus'])->name('contenus');
        Route::get('/media', [ClientDashboardController::class, 'contributeMedia'])->name('media');
        Route::post('/submit', [ClientDashboardController::class, 'submitContribution'])->name('submit');
    });
    
    // Bibliothèque (contenus achetés/téléchargés)
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'library'])->name('index');
        Route::get('/contenus', [ClientDashboardController::class, 'libraryContenus'])->name('contenus');
        Route::get('/media', [ClientDashboardController::class, 'libraryMedia'])->name('media');
        Route::get('/favorites', [ClientDashboardController::class, 'favorites'])->name('favorites');
        Route::post('/{type}/{id}/favorite', [ClientDashboardController::class, 'toggleFavorite'])->name('favorite');
    });
    
    // Historique d'activité
    Route::prefix('activity')->name('activity.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'activity'])->name('index');
        Route::get('/purchases', [ClientDashboardController::class, 'purchases'])->name('purchases');
        Route::get('/uploads', [ClientDashboardController::class, 'uploads'])->name('uploads');
        Route::get('/views', [ClientDashboardController::class, 'views'])->name('views');
    });
    
    // Recherche
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'search'])->name('index');
        Route::get('/advanced', [ClientDashboardController::class, 'advancedSearch'])->name('advanced');
        Route::post('/results', [ClientDashboardController::class, 'searchResults'])->name('results');
    });
    
    // Langues
    Route::prefix('languages')->name('languages.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'languagesIndex'])->name('index');
        Route::get('/{id}', [ClientDashboardController::class, 'languageDetail'])->name('detail');
    });
    
    // Régions
    Route::prefix('regions')->name('regions.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'regionsIndex'])->name('index');
        Route::get('/{id}', [ClientDashboardController::class, 'regionDetail'])->name('detail');
    });
    
    // Utilisateurs (client view)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'usersIndex'])->name('index');
        Route::get('/{id}', [ClientDashboardController::class, 'userDetail'])->name('detail');
        Route::post('/{id}/follow', [ClientDashboardController::class, 'followUser'])->name('follow');
        Route::post('/{id}/unfollow', [ClientDashboardController::class, 'unfollowUser'])->name('unfollow');
    });
    
    // Statistiques (client)
    Route::get('/stats', [ClientDashboardController::class, 'getStats'])->name('stats');
    
    // Paramètres client
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [ClientDashboardController::class, 'clientSettings'])->name('index');
        Route::get('/account', [ClientDashboardController::class, 'accountSettings'])->name('account');
        Route::get('/notifications', [ClientDashboardController::class, 'notificationSettings'])->name('notifications');
        Route::get('/privacy', [ClientDashboardController::class, 'privacySettings'])->name('privacy');
        Route::post('/update/{section}', [ClientDashboardController::class, 'updateClientSettings'])->name('update');
    });
});

// Routes API pour AJAX
Route::middleware(['auth', 'verified'])->prefix('api')->name('api.')->group(function () {
    // Recherche en temps réel
    Route::get('/search', [ClientDashboardController::class, 'apiSearch'])->name('search');
    
    // Statistiques
    Route::get('/stats', [ClientDashboardController::class, 'apiStats'])->name('stats');
    
    // Upload média
    Route::post('/media/upload', [ClientDashboardController::class, 'apiUploadMedia'])->name('media.upload');
    
    // Favoris
    Route::post('/favorite/{type}/{id}', [ClientDashboardController::class, 'apiToggleFavorite'])->name('favorite');
    
    // Commentaires
    Route::post('/comment/{type}/{id}', [ClientDashboardController::class, 'apiAddComment'])->name('comment.add');
    Route::delete('/comment/{id}', [ClientDashboardController::class, 'apiDeleteComment'])->name('comment.delete');
    
    // Évaluations
    Route::post('/rating/{type}/{id}', [ClientDashboardController::class, 'apiAddRating'])->name('rating.add');
    
    // Notifications
    Route::get('/notifications', [ClientDashboardController::class, 'apiNotifications'])->name('notifications');
    Route::post('/notifications/read/{id}', [ClientDashboardController::class, 'apiMarkNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [ClientDashboardController::class, 'apiMarkAllNotificationsRead'])->name('notifications.read-all');
});

// Les routes de vérification d'email et de confirmation de mot de passe sont gérées par routes/auth.php
require_once __DIR__.'/auth.php';

// Routes de santé/statut
Route::get('/health', function () {
    return response()->json(['status' => 'OK', 'timestamp' => now()]);
});

Route::get('/status', function () {
    return response()->json([
        'status' => 'OK',
        'app' => config('app.name'),
        'env' => config('app.env'),
        'debug' => config('app.debug'),
        'url' => config('app.url'),
        'timezone' => config('app.timezone'),
        'version' => app()->version(),
    ]);
});

// Route de secours pour les erreurs 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// Routes de débogage (uniquement en local)
if (app()->environment('local')) {
    Route::get('/debug/routes', function () {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        });
        
        return response()->json($routes);
    });
    
    Route::get('/debug/config', function () {
        return response()->json([
            'app' => config('app'),
            'auth' => config('auth'),
            'database' => config('database'),
            'mail' => config('mail'),
            'services' => config('services'),
        ]);
    });
}