<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (Auth::check()) {
            // Si déjà connecté, rediriger selon le rôle
            return view('auth.login', [
                'alreadyLoggedIn' => true
            ]);
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Récupérer l'utilisateur
        $user = Auth::user();
        
        // Message de bienvenue
        $welcomeMessages = [
            "Bienvenue {$user->name} ! Prêt à partager notre culture ?",
            "Content de vous revoir {$user->name} !",
            "{$user->name}, votre contribution compte pour notre patrimoine !"
        ];
        
        session()->flash('success', $welcomeMessages[array_rand($welcomeMessages)]);

        // Redirection selon le type d'utilisateur
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Rediriger selon le rôle de l'utilisateur
     */
    private function redirectBasedOnRole($user): RedirectResponse
    {
        // Liste des emails admin/manager
        $adminEmails = ['maurice.comlan@uac.bj', 'arnaudkpodji@gmail.com'];
        
        if (in_array($user->email, $adminEmails) || $user->estAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Vous êtes déconnecté.');
    }
}