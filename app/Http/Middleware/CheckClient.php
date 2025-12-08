<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClient
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $adminEmails = ['maurice.comlan@uac.bj', 'arnaudkpodji@gmail.com'];
        
        // Utilisez estAdmin() de votre modèle User
        $isAdminByEmail = in_array($user->email, $adminEmails);
        $isAdminByRole = $user->estAdmin(); // CHANGÉ ICI
        
        if ($isAdminByEmail || $isAdminByRole) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Les administrateurs doivent utiliser le tableau de bord administrateur.');
        }

        return $next($request);
    }
}