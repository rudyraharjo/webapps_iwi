<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-red elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/AdminLTELogo.png') }}" alt="{{ config('app.name') }}"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('app/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">{{ __('menu_sidebar.master_data') }}</li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('app/humanresource*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            human Resource
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('employee.index') }}" class="nav-link ml-5">
                                <p>{{ __('menu_sidebar.master_data_employee') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employee.index') }}" class="nav-link ml-5">
                                <p>{{ __('menu_sidebar.master_data_jobposition') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employee.index') }}"
                        class="nav-link {{ request()->is('app/employee*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            {{ __('menu_sidebar.master_data_employee') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('business_partner.index') }}"
                        class="nav-link {{ request()->is('app/business-partner*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            {{ __('menu_sidebar.master_data_customer') }}
                        </p>
                    </a>
                </li>
                @role('root|administrator')
                    <li class="nav-header">{{ __('menu_sidebar.configuration') }}</li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link {{ request()->is('app/configuration/bussines-partner*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                {{ __('menu_sidebar.configuration_bussines_partner') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            <li class="nav-item">
                                <a href="{{ route('bp_designation.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_bussines_partner_designation') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('bp_group.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_bussines_partner_group') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('bp_category.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_bussines_partner_category') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('app/configuration/area*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>
                                {{ __('menu_sidebar.configuration_area') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            <li class="nav-item">
                                <a href="{{ route('province.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_province') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('city.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_city') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('district.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_district') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('village.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.configuration_village') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link {{ request()->is('app/configuration/manage*') ? 'active' : '' }}"">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                {{ __('menu_sidebar.managment_user') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            <li class="nav-item">
                                <a href="{{ route('team.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.managment_user.team') }}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link ml-5">
                                    <p>{{ __('menu_sidebar.managment_user.user') }}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('role.index') }}"
                                    class="nav-link ml-5 {{ request()->is('roles') ? 'active' : '' }}">
                                    <p>{{ __('menu_sidebar.managment_user.role') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permission.index') }}"
                                    class="nav-link ml-5 {{ request()->is('permissions') ? 'active' : '' }}">
                                    <p>{{ __('menu_sidebar.managment_user.permission') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('bank.index') }}"
                            class="nav-link {{ request()->is('app/configuration/bank*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                {{ __('menu_sidebar.configuration_bank') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('identitycard.index') }}"
                            class="nav-link {{ request()->is('app/configuration/identitycard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                {{ __('menu_sidebar.configuration_identitycard') }}
                            </p>
                        </a>
                    </li>
                @endrole

                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            {{ __('menu_sidebar.logout') }}
                        </p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
                {{-- <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Starter Pages
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inactive Page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Simple Link
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
