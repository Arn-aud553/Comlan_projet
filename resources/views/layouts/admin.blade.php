<!doctype html>
<html lang="fr">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'Tableau de bord - Culture Bénin')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="color-scheme" content="light" />
    <meta name="theme-color" content="#ffffff" />
 <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="Culture Bénin | Tableau de bord Admin" />
    <meta name="author" content="Culture Bénin" />
    <meta
      name="description"
      content="Plateforme de gestion du patrimoine culturel et linguistique béninois"
    />
    <meta
      name="keywords"
      content="culture bénin, patrimoine, langues, régions, contenus, administration"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light" />
    <link rel="preload" href="{{ asset('admin/css/adminlte.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <noscript><link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}" /></noscript>
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    
    <!-- ========== DATATABLES CSS ========== -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.5.0/css/searchBuilder.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">
    @stack('styles')
    
    <style>
      .app-sidebar {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        color: #333;
        border-right: 1px solid #e9ecef;
      }
      
      .app-sidebar .nav-link {
        color: #555;
        transition: all 0.3s ease;
      }
      
      .app-sidebar .nav-link:hover,
      .app-sidebar .nav-link.active {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
      }
      
      .app-sidebar .nav-link.active {
        font-weight: bold;
        border-left: 3px solid #0d6efd;
      }
      
      .app-sidebar .nav-header {
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 20px;
        padding-left: 15px;
        border-top: 1px solid #e9ecef;
        padding-top: 10px;
      }
      
      .sidebar-brand .brand-link {
        color: #333;
        text-decoration: none;
      }
      
      .sidebar-brand .brand-text {
        color: #333;
        font-weight: 600;
      }
      
      /* Amélioration de la sidebar */
      .nav-treeview {
        background-color: rgba(0, 0, 0, 0.03);
        border-left: 3px solid rgba(13, 110, 253, 0.2);
        margin-left: 15px;
        padding-left: 10px;
      }
      
      .nav-treeview .nav-link {
        padding-left: 25px;
        font-size: 0.9rem;
      }
      
      .nav-treeview .nav-link.active {
        background-color: rgba(13, 110, 253, 0.15);
        border-left: 3px solid #0d6efd;
      }
      
      /* DataTables Styles */
      .dataTables_wrapper {
        padding: 0;
      }
      
      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
      }
      
      .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
      }
      
      .dt-buttons {
        margin-bottom: 10px;
      }
      
      .dt-buttons .btn {
        margin-right: 5px;
        margin-bottom: 5px;
      }
      
      table.dataTable {
        border-collapse: collapse !important;
        margin-top: 10px !important;
      }
      
      table.dataTable thead th {
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
      }
      
      table.dataTable tbody tr {
        transition: background-color 0.15s ease;
      }
      
      table.dataTable tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
      }
      
      table.dataTable tbody td {
        vertical-align: middle;
        color: #333;
      }
      
      .dataTables_info {
        padding-top: 10px;
        color: #666;
      }
      
      .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin-left: 2px;
        border-radius: 0.25rem;
        border: 1px solid #dee2e6;
        color: #0d6efd;
      }
      
      .dataTables_paginate .paginate_button.current {
        background: #0d6efd;
        color: white !important;
        border: 1px solid #0d6efd;
      }
      
      .dataTables_paginate .paginate_button:hover:not(.disabled) {
        background: #0d6efd;
        color: white !important;
        border: 1px solid #0d6efd;
      }
      
      /* Badges pour DataTables */
      .badge {
        font-size: 0.8em;
        padding: 0.4em 0.7em;
      }
      
      /* Boutons d'action */
      .btn-group-sm > .btn, .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
      }
      
      .action-buttons {
        white-space: nowrap;
      }
      
      /* Amélioration du header */
      .app-header {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-bottom: 1px solid #e9ecef;
      }
      
      .app-header .nav-link {
        color: #555;
      }
      
      .app-header .nav-link:hover {
        color: #0d6efd;
      }
      
      /* Amélioration du footer */
      .app-footer {
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 15px 0;
        margin-top: 20px;
        color: #666;
      }
      
      /* Style pour les cartes de contenu */
      .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: white;
      }
      
      .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      }
      
      .card-header {
        background-color: white;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        padding: 15px 20px;
        color: #333;
      }
      
      .card-body {
        padding: 20px;
        color: #333;
      }
      
      /* Style pour les boutons d'action */
      .btn-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border: none;
        color: white;
      }
      
      .btn-success {
        background: linear-gradient(135deg, #198754 0%, #146c43 100%);
        border: none;
        color: white;
      }
      
      .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        border: none;
        color: white;
      }
      
      .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        border: none;
        color: #212529;
      }
      
      .btn-info {
        background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
        border: none;
        color: white;
      }
      
      /* Styles pour les formulaires */
      .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
      }
      
      /* Alerte améliorée */
      .alert {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      }
      
      .alert-success {
        background: linear-gradient(135deg, #d1e7dd 0%, #c1e2d2 100%);
        color: #0f5132;
        border-left: 4px solid #198754;
      }
      
      .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f4c8cc 100%);
        color: #842029;
        border-left: 4px solid #dc3545;
      }
      
      .alert-info {
        background: linear-gradient(135deg, #cff4fc 0%, #b6effb 100%);
        color: #055160;
        border-left: 4px solid #0dcaf0;
      }
      
      .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #664d03;
        border-left: 4px solid #ffc107;
      }
      
      /* Navigation améliorée */
      .nav-tabs {
        border-bottom: 2px solid #e9ecef;
      }
      
      .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
      }
      
      .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        background-color: transparent;
      }
      
      /* Pagination améliorée */
      .pagination {
        margin-bottom: 0;
      }
      
      .page-link {
        color: #0d6efd;
        border: 1px solid #dee2e6;
      }
      
      .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
      }
      
      /* Amélioration des icônes dans la sidebar */
      .nav-icon {
        color: #6c757d;
      }
      
      .nav-link:hover .nav-icon,
      .nav-link.active .nav-icon {
        color: #0d6efd;
      }
      
      /* Style pour le dropdown du profil */
      .dropdown-menu {
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      }
      
      .dropdown-item {
        color: #333;
      }
      
      .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
      }
      
      /* Style pour le toggle du thème */
      #theme-toggle {
        border-color: #ced4da;
        color: #6c757d;
      }
      
      #theme-toggle:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
      }
      
      /* Amélioration des titres */
      h1, h2, h3, h4, h5, h6 {
        color: #333;
      }
      
      /* Style pour les labels */
      label {
        color: #333;
        font-weight: 500;
      }
      
      /* Style pour les textes désactivés */
      .text-muted {
        color: #6c757d !important;
      }
    </style>
  </head>
  <!--end::Head-->
  
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="{{ route('admin.dashboard') }}" class="nav-link">Tableau de bord</a>
            </li>
          </ul>
          <!--end::Start Navbar Links-->
          
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
            <!--end::Navbar Search-->
            
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            
            <!-- Theme toggle -->
            <li class="nav-item d-flex align-items-center ms-2">
              <button id="theme-toggle" class="btn btn-sm btn-outline-secondary" title="Basculer thème">
                <i class="bi bi-sun-fill" id="theme-icon"></i>
              </button>
            </li>
            
            <!--begin::Profile Dropdown-->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <span class="d-none d-md-inline">
                      @auth
                        {{ Auth::user()->name }}
                      @endauth
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="#">
                          <i class="bi bi-person me-2"></i> Mon profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">
                              <i class="bi bi-box-arrow-right me-2"></i> Se déconnecter
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <!--end::Profile Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('admin/img/ballon-benin.jpg') }}" alt="CULTURE BENIN" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">Administration</span>
          </a>
        </div>
        <!--end::Sidebar Brand-->
        
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            @php
              $isDashboard = Request::is('admin/dashboard') || Request::is('/welcome');
              $isLangues = Request::is('admin/langues*');
              $isUsers = Request::is('admin/users*');
              $isRegions = Request::is('admin/regions*');
              $isContenus = Request::is('admin/contenus*');
              $isCommentaires = Request::is('admin/moderation/comments*');
              $isTypeContenus = Request::is('admin/types-contenu*');
              $isMedia = Request::is('admin/media*');
            @endphp
            
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
              <!-- Tableau de bord -->
              <li class="nav-item {{ $isDashboard ? 'menu-open' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $isDashboard ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer2"></i>
                  <p>Tableau de bord</p>
                </a>
              </li>
              
              <!-- Users -->
              <li class="nav-item {{ $isUsers ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ $isUsers ? 'active' : '' }}">
                      <i class="nav-icon bi bi-people-fill"></i>
                      <p>Utilisateurs <i class="nav-arrow bi bi-chevron-right"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users') && !Request::is('admin/users/create') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-list-ul"></i>
                              <p>Liste des utilisateurs</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('admin.users.create') }}" class="nav-link {{ Request::is('admin/users/create') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-person-plus"></i>
                              <p>Nouvel utilisateur</p>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Contenus -->
              <li class="nav-item {{ $isContenus ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isContenus ? 'active' : '' }}">
                  <i class="nav-icon bi bi-file-earmark-text"></i>
                  <p>Contenus <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.contenus.index') }}" class="nav-link {{ Request::is('admin/contenus') && !Request::is('admin/contenus/create') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-list-ul"></i>
                      <p>Liste des contenus</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.contenus.create') }}" class="nav-link {{ Request::is('admin/contenus/create') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-plus-circle"></i>
                      <p>Ajouter un contenu</p>
                    </a>
                  </li>
                </ul>
              </li>
              
              <!-- Langues -->
              <li class="nav-item {{ $isLangues ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isLangues ? 'active' : '' }}">
                  <i class="nav-icon bi bi-translate"></i>
                  <p>Langues <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.langues.index') }}" class="nav-link {{ Request::is('admin/langues') && !Request::is('admin/langues/create') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-list-ul"></i>
                      <p>Liste des langues</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.langues.create') }}" class="nav-link {{ Request::is('admin/langues/create') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-plus-circle"></i>
                      <p>Ajouter une langue</p>
                    </a>
                  </li>
                </ul>
              </li>
              
              <!-- Régions -->
              <li class="nav-item {{ $isRegions ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isRegions ? 'active' : '' }}">
                  <i class="nav-icon bi bi-geo-alt-fill"></i>
                  <p>Régions <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.regions.index') }}" class="nav-link {{ Request::is('admin/regions') && !Request::is('admin/regions/create') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-list-ul"></i>
                      <p>Liste des régions</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.regions.create') }}" class="nav-link {{ Request::is('admin/regions/create') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-plus-circle"></i>
                      <p>Ajouter une région</p>
                    </a>
                  </li>
                </ul>
              </li>
              
              <li class="nav-header mt-3">GESTION AVANCÉE</li>
              
              <!-- Commentaires -->
              <li class="nav-item {{ $isCommentaires ? 'menu-open' : '' }}">
                <a href="{{ route('admin.moderation.comments') }}" class="nav-link {{ $isCommentaires ? 'active' : '' }}">
                  <i class="nav-icon bi bi-chat-left-text"></i>
                  <p>Commentaires</p>
                </a>
              </li>
              
              <!-- Types de contenus -->
              <li class="nav-item {{ $isTypeContenus ? 'menu-open' : '' }}">
                <a href="{{ route('admin.types-contenu.index') }}" class="nav-link {{ $isTypeContenus ? 'active' : '' }}">
                  <i class="nav-icon bi bi-tags"></i>
                  <p>Types de contenus</p>
                </a>
              </li>
              
              <!-- Médias -->
              <li class="nav-item {{ $isMedia ? 'menu-open' : '' }}">
                <a href="{{ route('admin.media.index') }}" class="nav-link {{ $isMedia ? 'active' : '' }}">
                  <i class="nav-icon bi bi-image"></i>
                  <p>Médias</p>
                </a>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content-->
        <div class="app-content">
          <div class="container-fluid">
            <!-- Flash Messages -->
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            
            @if($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            
            <!-- Main Content -->
            @yield('content')
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      
      <!--begin::Footer-->
      <footer class="app-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <strong>Culture Bénin</strong> - Plateforme de gestion du patrimoine culturel
            </div>
            <div class="col-md-6 text-end">
              @php
                $startYear = 2025;
                $currentYear = date('Y');
              @endphp
              <span class="text-muted">
                © {{ $startYear }}@if($startYear < $currentYear)-{{ $currentYear }}@endif 
                Tous droits réservés.
              </span>
            </div>
          </div>
        </div>
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    
    <!-- ========== DATATABLES SCRIPTS ========== -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AdminLTE -->
    <script src="{{ asset('admin/js/adminlte.js') }}"></script>
    
    <!-- OverlayScrollbars -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    
    <!-- DataTables Core -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- DataTables Extensions -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    
    <!-- DataTables Responsive -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- DataTables Select -->
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    
    <!-- Export Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    
    <!-- SearchBuilder -->
    <script src="https://cdn.datatables.net/searchbuilder/1.5.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.5.0/js/searchBuilder.bootstrap5.min.js"></script>
    
    <!-- DateTime -->
    <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
    
    <script>
      // Configuration OverlayScrollbars
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
      
      // Theme toggle - version claire uniquement
      (function(){
        // Forcer le thème clair
        localStorage.setItem('site-theme', 'light');
        const icon = document.getElementById('theme-icon');
        if(icon) icon.className = 'bi bi-sun-fill';
        
        // Désactiver le toggle du thème sombre
        document.getElementById('theme-toggle')?.addEventListener('click', function(e) {
          e.preventDefault();
          // Ne rien faire - on garde le thème clair
          alert('Thème clair activé. Le thème sombre n\'est pas disponible.');
        });
      })();
      
      // Configuration DataTables par défaut
      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
          {
            extend: 'copy',
            className: 'btn btn-secondary btn-sm',
            text: '<i class="bi bi-copy"></i> Copier',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-success btn-sm',
            text: '<i class="bi bi-file-earmark-excel"></i> Excel',
            title: function() {
              return document.title + ' - ' + new Date().toLocaleDateString('fr-FR');
            },
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            className: 'btn btn-danger btn-sm',
            text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
            title: function() {
              return document.title;
            },
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-info btn-sm',
            text: '<i class="bi bi-printer"></i> Imprimer',
            title: function() {
              return document.title;
            },
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'colvis',
            className: 'btn btn-warning btn-sm',
            text: '<i class="bi bi-eye"></i> Colonnes'
          }
        ]
      });
      
      // Initialisation automatique des DataTables
      document.addEventListener('DOMContentLoaded', function() {
        // Initialiser toutes les tables avec la classe .datatable
        $('.datatable').DataTable();
        
        // Initialiser les tables avec boutons d'export
        $('.datatable-buttons').DataTable({
          dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });
        
        // Initialiser les tables avec recherche avancée
        $('.datatable-advanced').DataTable({
          dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          searchBuilder: {
            columns: ':not(.no-search)'
          }
        });
      });
      
      // Fonction pour exporter les données
      window.exportTableToExcel = function(tableId, filename = '') {
        const table = document.getElementById(tableId);
        const wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
        const wbout = XLSX.write(wb, {bookType:'xlsx', type: 'binary'});
        
        function s2ab(s) {
          const buf = new ArrayBuffer(s.length);
          const view = new Uint8Array(buf);
          for (let i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
          return buf;
        }
        
        saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), filename || tableId + '.xlsx');
      };
    </script>
    
    @stack('scripts')
  </body>
</html>