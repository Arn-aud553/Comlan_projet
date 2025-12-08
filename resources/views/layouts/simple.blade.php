<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Culture Bénin')</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Simple Header -->
    <header class="bg-gradient-to-r from-slate-800 to-slate-900 text-white py-4 px-6 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-amber-600 p-2 rounded-lg">
                    <i class="fas fa-landmark text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold">CULTURE BENIN</h1>
                    <p class="text-xs text-gray-300">Patrimoine Culturel National</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('client.dashboard') }}" class="text-sm hover:text-amber-400 transition">
                    <i class="fas fa-home mr-1"></i> Tableau de bord
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm hover:text-amber-400 transition">
                        <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto mt-4 px-4">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl mr-3"></i>
                    <div>
                        <strong class="font-bold">Succès !</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto mt-4 px-4">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                    <div>
                        <strong class="font-bold">Erreur !</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="bg-slate-900 text-gray-400 py-6 mt-12">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Culture Bénin. Tous droits réservés.</p>
            <p class="text-xs mt-2">Plateforme de promotion du patrimoine culturel béninois</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
