<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Admin CULTURE BENIN</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Utiliser le même CSS que admin/dashboard.blade.php */
        :root {
            --admin-primary: #2c3e50;
            --admin-secondary: #34495e;
            --admin-accent: #e63946;
            --admin-success: #27ae60;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
            background: #f5f7fa;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: var(--admin-primary);
            color: white;
        }
        
        .admin-logo {
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .admin-logo h2 {
            color: white;
            font-size: 24px;
        }
        
        .admin-logo p {
            color: #bdc3c7;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .admin-nav {
            padding: 20px 0;
        }
        
        .nav-item {
            display: block;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--admin-accent);
        }
        
        .nav-item i {
            width: 20px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .admin-header {
            background: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .header-left h1 {
            color: var(--admin-primary);
            font-size: 24px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--admin-accent), #ffb347);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .admin-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .page-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="admin-logo">
                <h2>CULTURE BENIN</h2>
                <p>Administration</p>
            </div>
            
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('admin.import') }}" class="nav-item {{ Request::is('admin/import') ? 'active' : '' }}">
                    <i class="fas fa-file-import"></i> Import
                </a>
                <a href="{{ route('admin.moderation') }}" class="nav-item {{ Request::is('admin/moderation') ? 'active' : '' }}">
                    <i class="fas fa-gavel"></i> Modération
                </a>
                <a href="{{ route('admin.analytics') }}" class="nav-item {{ Request::is('admin/analytics') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Analytics
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item {{ Request::is('admin/reports') ? 'active' : '' }}">
                    <i class="fas fa-flag"></i> Reports
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item {{ Request::is('admin/settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="{{ route('client.dashboard') }}" class="nav-item" style="margin-top: 20px; background: rgba(39, 174, 96, 0.1);">
                    <i class="fas fa-exchange-alt"></i> Vue Client
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <h1>{{ $title ?? 'Page Admin' }}</h1>
                    <p style="color: #7f8c8d; margin-top: 5px;">Gestion de l'administration</p>
                </div>
                
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->nom_complet, 0, 2)) }}
                    </div>
                    <div>
                        <strong>{{ $user->nom_complet }}</strong>
                        <p style="color: #7f8c8d; font-size: 14px;">{{ $user->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="margin-left: 15px;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #e63946; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Content spécifique à la page -->
            <main class="admin-content">
                <div class="page-content">
                    <div class="content-header" style="margin-bottom: 30px;">
                        <h2 style="color: #2c3e50; font-size: 28px; margin-bottom: 10px;">
                            <i class="fas fa-cogs"></i> {{ $title }}
                        </h2>
                        <p style="color: #7f8c8d;">Gestion des fonctionnalités d'administration</p>
                    </div>
                    
                    <!-- Contenu spécifique de la page -->
                    <div class="content-body">
                        <p style="color: #5d6d7e; line-height: 1.6;">
                            Cette page est dédiée à la gestion de <strong>{{ strtolower($title) }}</strong>.
                            Ici, vous pouvez gérer toutes les fonctionnalités liées à cette section.
                        </p>
                        
                        <!-- Exemple de contenu selon la page -->
                        @if($title == 'Import')
                        <div style="margin-top: 30px;">
                            <h3 style="color: #2c3e50; margin-bottom: 20px;">Importer des données</h3>
                            <div style="border: 2px dashed #ddd; padding: 40px; text-align: center; border-radius: 10px;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 50px; color: #7f8c8d; margin-bottom: 20px;"></i>
                                <p style="color: #7f8c8d; margin-bottom: 20px;">Glissez et déposez vos fichiers ici</p>
                                <button style="background: #e63946; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer;">
                                    <i class="fas fa-folder-open"></i> Sélectionner des fichiers
                                </button>
                            </div>
                        </div>
                        @endif
                        
                        @if($title == 'Moderation')
                        <div style="margin-top: 30px;">
                            <h3 style="color: #2c3e50; margin-bottom: 20px;">Contenus à modérer</h3>
                            <!-- Tableau de modération -->
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background: #f8f9fa;">
                                            <th style="padding: 15px; text-align: left; border-bottom: 2px solid #ddd;">ID</th>
                                            <th style="padding: 15px; text-align: left; border-bottom: 2px solid #ddd;">Titre</th>
                                            <th style="padding: 15px; text-align: left; border-bottom: 2px solid #ddd;">Auteur</th>
                                            <th style="padding: 15px; text-align: left; border-bottom: 2px solid #ddd;">Date</th>
                                            <th style="padding: 15px; text-align: left; border-bottom: 2px solid #ddd;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <td style="padding: 15px;">#001</td>
                                            <td style="padding: 15px;">Contenu à modérer</td>
                                            <td style="padding: 15px;">Utilisateur Test</td>
                                            <td style="padding: 15px;">2024-01-15</td>
                                            <td style="padding: 15px;">
                                                <button style="background: #27ae60; color: white; border: none; padding: 8px 15px; border-radius: 5px; margin-right: 5px; cursor: pointer;">
                                                    <i class="fas fa-check"></i> Approuver
                                                </button>
                                                <button style="background: #e63946; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                                                    <i class="fas fa-times"></i> Rejeter
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>