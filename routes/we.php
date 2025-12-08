<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\TypeContenuController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\DashboardController; // AJOUTER CETTE LIGNE
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Routes publiques
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/themes', function () {
    return view('themes');
});

Route::get('/themes/{slug}', [App\Http\Controllers\ThemeController::class, 'show'])->name('theme.detail');

// ==================== ROUTES D'AUTHENTIFICATION ====================

// Route pour afficher le formulaire de login (doit être AVANT le groupe auth)
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Route pour traiter la connexion
Route::post('/login-custom', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Essayer d'abord la connexion ADMIN
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        // Vérifier si c'est un admin autorisé
        if (in_array($user->email, ['maurice.comlan@uac.bj', 'arnaudkpodji@gmail.com'])) {
            return redirect('/admin/dashboard'); // Redirection admin
        }
        
        // Si c'est un utilisateur Breeze normal, le déconnecter
        Auth::logout();
    }

    // Essayer la connexion CLIENT
    if (Auth::guard('client')->attempt($credentials)) {
        return redirect()->route('client.dashboard'); // Redirection client
    }

    // Si aucune connexion ne fonctionne
    return back()->withErrors([
        'email' => 'Les informations d\'identification fournies sont incorrectes.',
    ]);
})->name('login.custom');

// ==================== ROUTES ADMIN ====================
Route::middleware(['auth'])->group(function () {
    // MODIFIER CETTE LIGNE POUR UTILISER LE CONTROLLER
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/welcome', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes CRUD admin
    Route::resource('users', UserController::class);
    Route::resource('langues', LangueController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('commentaires', CommentaireController::class);
    Route::resource('contenus', ContenuController::class);
    Route::resource('type_contenus', TypeContenuController::class);
    Route::resource('media', MediaController::class);
});

// ==================== ROUTES CLIENT ====================
Route::prefix('client')->group(function () {
    // INSCRIPTION client
    Route::get('/register', [ClientAuthController::class, 'showRegisterForm'])->name('client.register');
    Route::post('/register', [ClientAuthController::class, 'register']);

    // DÉCONNEXION client
    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('client.logout');

    // Dashboard client (protégé)
    Route::middleware(['client.auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('client.dashboard');
        
        // Routes en lecture seule pour les clients
        Route::get('/contenus', [ContenuController::class, 'indexClient'])->name('client.contenus.index');
        Route::get('/langues', [LangueController::class, 'indexClient'])->name('client.langues.index');
        Route::get('/regions', [RegionController::class, 'indexClient'])->name('client.regions.index');
    });
});

require __DIR__.'/auth.php';


// Ajoutez ces routes à la fin de votre fichier web.php, avant require __DIR__.'/auth.php';

// Routes pour les secteurs culturels
Route::get('/danse', function () {
    return view('danse');
})->name('danse');

Route::get('/musique', function () {
    return view('musique');
})->name('musique');

Route::get('/theatre', function () {
    return view('theatre');
})->name('theatre');

Route::get('/art-rue', function () {
    return view('art-rue');
})->name('art-rue');