<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Vérifier si l'utilisateur vient de se connecter
        if (Auth::check() && session()->has('logged_in')) {
            $user = Auth::user();
            
            // Liste des emails admin/manager
            $adminEmails = ['maurice.comlan@uac.bj', 'arnaudkpodji@gmail.com'];
            
            if (in_array($user->email, $adminEmails)) {
                // Rediriger vers l'admin
                return redirect()->route('admin.dashboard');
            } else {
                // Rediriger vers le layout client
                return redirect()->route('client.dashboard');
            }
        }
        
        return $response;
    }
}