<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Afficher la page de connexion
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Message de bienvenue
            $user = Auth::user();
            $welcomeMessages = [
                "Bienvenue {$user->nom_complet} ! Prêt à partager notre culture ?",
                "Content de vous revoir {$user->nom_complet} !",
                "{$user->nom_complet}, votre contribution compte pour notre patrimoine !"
            ];
            
            session()->flash('success', $welcomeMessages[array_rand($welcomeMessages)]);
            
            return $this->redirectBasedOnRole();
        }

        return redirect()->back()
            ->withInput()
            ->withErrors(['email' => 'Les identifiants sont incorrects.']);
    }

    /**
     * Rediriger selon le rôle de l'utilisateur
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        // Liste des emails admin/manager
        $adminEmails = ['maurice.comlan@uac.bj', 'arnaudkpodji@gmail.com'];
        
        if (in_array($user->email, $adminEmails) || $user->estAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('info', 'Vous êtes déconnecté.');
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Traiter l'inscription
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'nom_complet' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Le mutator va le hasher
        ]);

        Auth::login($user);
        
        session()->flash('success', 'Compte créé avec succès ! Bienvenue sur Culture Benin.');
        
        return $this->redirectBasedOnRole();
    }

    // ========== MÉTHODES CRUD POUR ROUTE RESOURCE ==========

    /**
     * Afficher la liste des utilisateurs (pour admin)
     */
    public function index()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'utilisateur
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistrer un nouvel utilisateur (méthode CRUD)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,manager,editeur,auteur,visiteur',
            'langue' => 'nullable|string',
        ]);

        // Générer un mot de passe automatique : email + "123"
        $emailPrefix = explode('@', $validated['email'])[0];
        $autoPassword = $emailPrefix . '123';

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'nom_complet' => $validated['name'], // Assurer que le nom complet est rempli
            'email' => $validated['email'],
            'password' => $autoPassword,
            'role' => $validated['role'],
            'langue' => $validated['langue'] ?? 'fr',
            'email_verified_at' => now(), // Marquer comme vérifié immédiatement
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Utilisateur créé avec succès. Mot de passe : {$autoPassword}");
    }

    /**
     * Afficher un utilisateur spécifique
     */
    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Afficher le formulaire d'édition d'un utilisateur
     */
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,manager,editeur,auteur,visiteur',
            'langue' => 'nullable|string',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'langue' => $validated['langue'] ?? $user->langue,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Empêcher la suppression de son propre compte
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}