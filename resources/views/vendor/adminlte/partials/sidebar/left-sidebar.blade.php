<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @can('users.index')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                      <p class="ml-3">Usuarios</p>
                    </a>
                     </li>
                @endcan

                 @if(auth()->user()->hasRole('client'))
                    <li class="nav-item">
                        <a href="{{ route('mails.index') }}" class="nav-link {{ request()->is('mails') || request()->is('mails/*') ? 'active' : '' }}">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        <p class="ml-3">Correos</p>
                        </a>
                     </li>
                @endif

                {{-- @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item') --}}
            </ul>
        </nav>
    </div>

</aside>
