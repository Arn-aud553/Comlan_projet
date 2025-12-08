<!doctype html>
<html lang="fr">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'AdminLTE v4 | Dashboard')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="color-scheme" content="light" />
    <meta name="theme-color" content="#c9ced3ff" />
 <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Tableau de bord" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
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
    <!-- DataTables CSS (centralized) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">
    @stack('styles')
    <style>
      .app-sidebar {
        background-color: #f8f9fa; /* Light background for sidebar */
        color: #343a40; /* Dark text for better readability */
      }
      .app-sidebar .nav-link {
        color: #495057; /* Neutral gray for links */
      }
      .app-sidebar .nav-link.active {
        color: #007bff; /* Bright blue for active links */
        font-weight: bold; /* Bold text for emphasis */
      }
      .app-sidebar .nav-header {
        color: #6c757d; /* Muted gray for section headers */
        font-size: 0.95rem; /* Slightly larger font for better visibility */
      }
      .dashboard-images {
        display: flex;
        gap: 20px;
        margin-top: 20px;
        justify-content: center; /* Center the images */
      }
      .dashboard-images .image-container {
        text-align: center;
      }
      .dashboard-images .image-container img {
        width: 250px; /* Keep the increased image size */
        height: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
      }
      .dashboard-images .image-container input {
        margin-top: 10px;
        width: 90%; /* Adjust text input width */
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px;
        font-size: 0.9rem; /* Reduce the font size of the text */
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
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
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
            <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-chat-text"></i>
                <span class="navbar-badge badge text-bg-danger">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="{{ asset('admin/img/user1-128x128.jpg') }}"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-end fs-7 text-danger"
                          ><i class="bi bi-star-fill"></i
                        ></span>
                      </h3>
                      <p class="fs-7">Call me whenever you can...</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="{{ asset('admin/img/user8-128x128.jpg') }}"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        John Pierce
                        <span class="float-end fs-7 text-secondary">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">I got your message bro</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="{{ asset('admin/img/user3-128x128.jpg') }}"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Nora Silvester
                        <span class="float-end fs-7 text-warning">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">The subject goes here</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <!--end::Messages Dropdown Menu-->
            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i>
                <span class="navbar-badge badge text-bg-warning">25</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-envelope me-2"></i> 12 new messages
                  <span class="float-end text-secondary fs-7">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-people-fill me-2"></i> 8 friend requests
                  <span class="float-end text-secondary fs-7">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-file-earmark-fill me-2"></i> 22 new reports
                  <span class="float-end text-secondary fs-7">4 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
              </div>
            </li>
            <!--end::Notifications Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="{{ asset('admin/img/user2-160x160.jpg') }}"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline">KPODJI Arnaud-Aristide</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="{{ asset('admin/img/user2-160x160.jpg') }}"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    KPODJI Arnaud-Aristide - Web Developer
                    <small>Member since Nov. 2023</small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-4 text-center"><a href="#">Followers</a></div>
                    <div class="col-4 text-center"><a href="#">Sales</a></div>
                    <div class="col-4 text-center"><a href="#">Friends</a></div>
                  </div>
                  <!--end::Row-->
                </li>
                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
            <!-- Theme toggle -->
            <li class="nav-item d-flex align-items-center ms-2">
              <button id="theme-toggle" class="btn btn-sm btn-outline-secondary" title="Basculer thème">
                <i class="bi bi-moon-fill" id="theme-icon"></i>
              </button>
            </li>
            <!--begin::Profile Dropdown-->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="#">Information</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Se déconnecter</button>
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
          <!--begin::Brand Link-->
            <a href="{{ url('/') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{ asset('admin/img/ballon-benin.jpg') }}"
              alt="CULTURE BENIN"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light"></span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            @php
              $isDashboard = Request::is('/') || Request::is('analytics*') || Request::is('reports*');
              $isLangues = Request::is('langues*');
              $isRegions = Request::is('regions*');
            @endphp
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
              <!-- Tableau de bord -->
              <li class="nav-item {{ $isDashboard ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isDashboard ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer2"></i>
                  <p>Tableau de bord <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Vue d'ensemble</p></a></li>
                    <li class="nav-item"><a href="{{ url('/analytics') }}" class="nav-link {{ Request::is('analytics*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Analytics</p></a></li>
                    <li class="nav-item"><a href="{{ url('/reports') }}" class="nav-link {{ Request::is('reports*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Rapports</p></a></li>
                </ul>
              </li>
              <!-- Langues -->
              <li class="nav-item {{ $isLangues ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isLangues ? 'active' : '' }}">
                  <i class="nav-icon bi bi-translate"></i>
                  <p>Langue <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('langues.index') }}" class="nav-link {{ Request::is('langues') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Liste</p></a></li>
                  <li class="nav-item"><a href="{{ route('langues.create') }}" class="nav-link {{ Request::is('langues/create') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Ajouter</p></a></li>
                  <li class="nav-item"><a href="{{ url('/langues/import') }}" class="nav-link {{ Request::is('langues/import') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Importer</p></a></li>
                </ul>
              </li>
              <!-- Régions -->
              <li class="nav-item {{ $isRegions ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isRegions ? 'active' : '' }}">
                  <i class="nav-icon bi bi-geo-alt-fill"></i>
                  <p>Région <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('regions.index') }}" class="nav-link {{ Request::is('regions') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Liste</p></a></li>
                  <li class="nav-item"><a href="{{ route('regions.create') }}" class="nav-link {{ Request::is('regions/create') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Ajouter</p></a></li>
                  <li class="nav-item"><a href="{{ url('/regions/import') }}" class="nav-link {{ Request::is('regions/import') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Importer</p></a></li>
                </ul>
              </li>
              <!-- Gestion des entités issues des migrations -->
              @php
                $isContenus = Request::is('contenus*');
                $isCommentaires = Request::is('commentaires*');
                $isTypeContenus = Request::is('type_contenus*') || Request::is('type-contenus*');
                $isMedia = Request::is('media*') || Request::is('medias*');
              @endphp

              <li class="nav-header">GESTION</li>
              <li class="nav-item {{ $isContenus ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isContenus ? 'active' : '' }}">
                  <i class="nav-icon bi bi-file-earmark-text"></i>
                  <p>Contenus <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('contenus.index') }}" class="nav-link {{ Request::is('contenus') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Liste</p></a></li>
                  <li class="nav-item"><a href="{{ route('contenus.create') }}" class="nav-link {{ Request::is('contenus/create') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Ajouter</p></a></li>
                  <li class="nav-item"><a href="{{ url('/contenus/moderation') }}" class="nav-link {{ Request::is('contenus/moderation') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Modération</p></a></li>
                </ul>
              </li>

              <li class="nav-item {{ $isCommentaires ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isCommentaires ? 'active' : '' }}">
                  <i class="nav-icon bi bi-chat-left-text"></i>
                  <p>Commentaires <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('commentaires.index') }}" class="nav-link {{ Request::is('commentaires') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Liste</p></a></li>
                  <li class="nav-item"><a href="{{ url('/commentaires/moderation') }}" class="nav-link {{ Request::is('commentaires/moderation') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Modérer</p></a></li>
                  <li class="nav-item"><a href="{{ url('/commentaires/stats') }}" class="nav-link {{ Request::is('commentaires/stats') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Statistiques</p></a></li>
                </ul>
              </li>

              <li class="nav-item {{ $isTypeContenus ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isTypeContenus ? 'active' : '' }}">
                  <i class="nav-icon bi bi-tags"></i>
                  <p>Type de contenus <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('type_contenus.index') }}" class="nav-link {{ Request::is('type_contenus') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Liste</p></a></li>
                  <li class="nav-item"><a href="{{ route('type_contenus.create') }}" class="nav-link {{ Request::is('type_contenus/create') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Ajouter</p></a></li>
                  <li class="nav-item"><a href="{{ url('/type_contenus/import') }}" class="nav-link {{ Request::is('type_contenus/import') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Importer</p></a></li>
                </ul>
              </li>

              <li class="nav-item {{ $isMedia ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isMedia ? 'active' : '' }}">
                  <i class="nav-icon bi bi-image"></i>
                  <p>Médias <i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('media.index') }}" class="nav-link {{ Request::is('media') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Liste</p></a></li>
                  <li class="nav-item"><a href="{{ route('media.create') }}" class="nav-link {{ Request::is('media/create') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Upload</p></a></li>
                  <li class="nav-item"><a href="{{ url('/media/settings') }}" class="nav-link {{ Request::is('media/settings') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Paramètres</p></a></li>
                </ul>
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
        <!-- App Content Header removed to simplify pages -->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
      {{-- Main content section (use 'content' in views). Keep 'contenu' as fallback for older views. --}}
      @if(View::hasSection('content'))
        @yield('content')
      @elseif(View::hasSection('contenu'))
        @yield('contenu')
      @endif
            <!-- /.row (main row) -->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer" align='center'>
            <!--begin::Copyright-->
          @php
            $startYear = 2025;
            $currentYear = date('Y');
          @endphp
          <strong>
            Copyright &copy;
            {{ $startYear }}@if($startYear < $currentYear)-{{ $currentYear }}@endif&nbsp;
            <a href="https://adminlte.io" class="text-decoration-none">CultureBénin</a>.
          </strong>
          Tous droits réservés.
          <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('admin/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
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
    </script>
    <!--end::OverlayScrollbars Configure-->
    <script>
      // Theme toggle: persist in localStorage and apply data-theme attribute on <html>
      (function(){
        const root = document.documentElement;
        const toggle = function(theme){
          if(theme === 'dark') root.setAttribute('data-theme','dark');
          else root.removeAttribute('data-theme');
          localStorage.setItem('site-theme', theme || 'light');
          const icon = document.getElementById('theme-icon');
          if(icon) icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        };

        // init
        const saved = localStorage.getItem('site-theme');
        if(saved === 'dark') toggle('dark');
        else if(saved === 'light') toggle('light');
      })();
    </script>
    <!--end::Theme Toggle Script-->
    <!-- DataTables JS (centralized) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!--end::DataTables JS-->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const tables = document.querySelectorAll('table');
        tables.forEach(function (table, index) {
          // Ensure the table is wrapped in a container
          const tableContainer = table.parentNode;

          // Create a container for the search bar and button
          const searchContainer = document.createElement('div');
          searchContainer.classList.add('d-flex', 'align-items-center', 'mb-3', 'justify-content-end'); // Align to the right

          // Create the search input field
          const searchInput = document.createElement('input');
          searchInput.type = 'text';
          searchInput.placeholder = 'Rechercher...';
          searchInput.classList.add('form-control', 'me-2');
          searchInput.style.width = '250px'; // Adjust width for better visibility
          searchInput.id = `search-input-${index}`;

          // Create the search button
          const searchButton = document.createElement('button');
          searchButton.textContent = 'Rechercher';
          searchButton.classList.add('btn', 'btn-primary');
          searchButton.addEventListener('click', function () {
            const searchValue = searchInput.value;
            $(table).DataTable().search(searchValue).draw();
          });

          // Append the input and button to the search container
          searchContainer.appendChild(searchInput);
          searchContainer.appendChild(searchButton);

          // Insert the search container before the table
          tableContainer.insertBefore(searchContainer, table);

          // Initialize DataTables
          if (!$(table).hasClass('dataTable')) {
            $(table).DataTable({
              language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
              }
            });
          }
        });
      });
    </script>
    <!--end::Script-->
  </body>
</html>