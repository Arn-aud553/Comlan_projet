<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        $user = Auth::user();

        // Liste des emails administrateurs
        $adminEmails = ['maurice.comlan@uac.bj', 'arnaudkpodji@gmail.com'];

        // Vérifie si l'utilisateur est admin par email ou par rôle
        $isAdmin = in_array($user->email, $adminEmails) || ($user->role === 'admin' || method_exists($user, 'estAdmin') && $user->estAdmin());

        if (!$isAdmin) {
            // Redirige vers le tableau de bord client si pas admin
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès réservé aux administrateurs.');
        }

        // Continue la requête
        return $next($request);
    }
}
