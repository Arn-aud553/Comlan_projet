<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => User::ROLE_VISITEUR,
        ]);

        // Événement d'inscription
        event(new Registered($user));

        // Connexion automatique
        Auth::login($user);

        // Message de bienvenue
        $welcomeMessages = [
            "Bienvenue {$user->name} ! Prêt à partager notre culture ?",
            "Content de vous accueillir {$user->name} !",
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
}