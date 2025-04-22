@php
    $menus = [
        [
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'name' => 'Dashboard',
            'route' => 'dashboard',
        ],
    ];

    $adminMenus = [
        [
            'icon' => 'fas fa-fw fa-users',
            'name' => 'Users',
            'route' => 'users.index',
        ],
        [
            'icon' => 'fas fa-fw fa-briefcase',
            'name' => 'Internship Programs',
            'route' => 'internship-programs.index',
        ],
        [
            'icon' => 'fas fa-fw fa-file-alt',
            'name' => 'Applications',
            'route' => 'application.index',
        ],
    ];
@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(135deg, #6366f1 0%, #e91e63 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">internconnect<sup>⛧𝕽</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (Auth::user()->role == 'mentor')
        @foreach ($adminMenus as $aMenu)
            @if (Route::has($aMenu['route']))
                <li class="nav-item {{ Route::is($aMenu['route']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route($aMenu['route']) }}">
                        @if (array_key_exists('icon', $aMenu))
                            <i class="{{ $aMenu['icon'] }}"></i>
                        @endif
                        <span>{{ $aMenu['name'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    @endif

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @foreach ($menus as $menu)
        @if (Route::has($menu['route']))
            <li class="nav-item {{ Route::is($menu['route']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($menu['route']) }}">
                    @if (array_key_exists('icon', $menu))
                        <i class="{{ $menu['icon'] }}"></i>
                    @endif
                    <span>{{ $menu['name'] }}</span>
                </a>
            </li>
        @endif
    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and
            more!
        </p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div>

</ul>
