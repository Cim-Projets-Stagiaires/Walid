<!doctype html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon-cim.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="route{{ 'home' }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" width="210"
                            style="margin: 10px 0px;" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-layout-dashboard"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                        @endif
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Menu</span>
                        </li>
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('demande-de-stage.index') }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-files"></i>
                                    </span>
                                    <span class="hide-menu">Demandes de stage</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('entretiens.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-bell"></i>
                                    </span>
                                    <span class="hide-menu">Entretiens</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'responsable admin' ||
                                (Auth::user()->type == 'encadrant' && Auth::user()->permanent) ||
                                Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('stagiaires.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <span class="hide-menu">Stagiaires</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'encadrant')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('encadrants.stagiaires', Auth::user()->id) }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <span class="hide-menu">Stagiaires</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('stagiaires.candidats') }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <span class="hide-menu">Candidats</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('encadrants.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-user-plus"></i>
                                    </span>
                                    <span class="hide-menu">Encadrants</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('admins.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-user-check"></i>
                                    </span>
                                    <span class="hide-menu">Admins</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'stagiaire' || Auth::user()->type == 'directeur')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('rapports.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-report"></i>
                                    </span>
                                    <span class="hide-menu">Rapports</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == 'responsable admin' ||
                                Auth::user()->type == 'stagiaire' ||
                                Auth::user()->type == 'directeur' ||
                                Auth::user()->type == 'encadrant')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('presentations.index') }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-slideshow"></i>
                                    </span>
                                    <span class="hide-menu">Presentations</span>
                                </a>
                            </li>
                        @endif
                        <!-- Archives Dropdown -->
                        @if (Auth::user()->type == 'responsable admin' || Auth::user()->type == 'directeur')
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow justify-content-between" href="javascript:void(0)"
                                aria-expanded="false">
                                <div class="d-flex">
                                    <span>
                                        <i class="ti ti-archive"></i>
                                    </span>
                                    <span class="hide-menu" style="padding-left: 15px;">Archives</span>
                                </div>
                                <i class="ti ti-chevron-up"></i>
                            </a>
                            <ul id="archivesDropdown" aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('stagiaires.archive') }}" class="sidebar-link">
                                        <span class="hide-menu">Stagiaires Archivés</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('encadrants.archive') }}" class="sidebar-link">
                                        <span class="hide-menu">Encadrants Archivés</span>
                                    </a>
                                </li>
                                <!-- Add more archived items if needed -->
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->type == 'encadrant')
                            <li class="sidebar-item">
                                <a class="sidebar-link"
                                    href="{{ route('encadrant.rapports', ['id' => Auth::user()->id]) }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-report"></i>
                                    </span>
                                    <span class="hide-menu">Rapports</span>
                                </a>
                            </li>
                        @endif
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <a href="#" target="_blank" class="btn btn-primary">Profile</a>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                            alt="Profile Picture"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <img src="{{ asset('/assets/images/profile/default-profile.png') }}"
                                            alt="Default Profile Picture"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                    {{-- <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt=""
                                        width="35" height="35" class="rounded-circle"> --}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        @if (Auth::user()->type == 'directeur')
                                            <a href="{{ route('directeur.show', Auth::user()->id) }}"
                                                class="d-flex align-items-center gap-2 dropdown-item">
                                                <i class="ti ti-user fs-6"></i>
                                                <p class="mb-0 fs-3">My Profile</p>
                                            </a>
                                        @endif
                                        @if (Auth::user()->type == 'stagiaire')
                                            <a href="{{ route('stagiaires.show', Auth::user()->id) }}"
                                                class="d-flex align-items-center gap-2 dropdown-item">
                                                <i class="ti ti-user fs-6"></i>
                                                <p class="mb-0 fs-3">My Profile</p>
                                            </a>
                                        @endif
                                        @if (Auth::user()->type == 'encadrant')
                                            <a href="{{ route('encadrants.show', Auth::user()->id) }}"
                                                class="d-flex align-items-center gap-2 dropdown-item">
                                                <i class="ti ti-user fs-6"></i>
                                                <p class="mb-0 fs-3">My Profile</p>
                                            </a>
                                        @endif
                                        @if (Auth::user()->type == 'responsable admin')
                                            <a href="{{ route('admins.show', Auth::user()->id) }}"
                                                class="d-flex align-items-center gap-2 dropdown-item">
                                                <i class="ti ti-user fs-6"></i>
                                                <p class="mb-0 fs-3">My Profile</p>
                                            </a>
                                        @endif
                                        {{-- <a href="route" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a> --}}
                                        <form method="POST" action="{{ route('logout') }}" class="d-block">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const archiveDropdown = document.querySelector('.sidebar-item .has-arrow[href="javascript:void(0)"]');
            const icons = archiveDropdown.querySelectorAll('.ti');
            const archives = document.querySelector('#archivesDropdown');
            const lastIcon = icons[icons.length - 1];

            // Toggle icon and add animation when clicking
            archiveDropdown.addEventListener('click', function() {
                const collapseElement = this.nextElementSibling;

                // Toggle the active state of the dropdown
                collapseElement.classList.toggle('show');

                /* const children = archives.children; */
                /* for (let i = 0; i < children.length; i++) {
                    children[i].style.transition = 'all 1s ease-in-out';
                } */
                archives.style.transition = 'all 1s ease-in-out';

                if (collapseElement.classList.contains('show')) {
                    // If the dropdown is open (active), change icon and add animation
                    lastIcon.classList.remove('ti-chevron-up');
                    lastIcon.classList.add('ti-chevron-down');

                    // Add a simple animation class for visual effect
                    lastIcon.style.transition = 'all 0.3s ease-in-out';
                    lastIcon.style.maxHeight = '500px'; // or any max height you prefer
                } else {
                    // If the dropdown is closed (not active), revert to original icon
                    lastIcon.classList.remove('ti-chevron-down');
                    lastIcon.classList.add('ti-chevron-up');
                }
            });
        });
    </script>
    @yield('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> --}}
</body>

</html>
