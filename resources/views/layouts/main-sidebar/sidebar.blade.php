<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- dashboard --}}
        <li class="nav-item">
            <a  class="nav-link" href="{{ url('/home') }}">
                <span class="menu-title">{{ __('sidebar.dashboard') }}</span>
            <i class="fa fa-home menu-icon"></i> </a>
        </li>
        @can('session-year-create')
            <li class="nav-item">
                <a href="
                {{ route('web.session-years.index') }}
                " class="nav-link"> <span
                        class="menu-title">{{ __('sidebar.session_years') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
                </a>
            </li>
        @endcan
        @can('grade-list')

        <li class="nav-item">
            <a href="
            {{ route('web.grades.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('sidebar.grades') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan

        @can('classes-list')

        <li class="nav-item">
            <a href="
            {{ route('web.classes.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('classes.classes') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan

        @can('school-list',)
        <li class="nav-item">
            <a href="
            {{ route('web.schools.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('sidebar.schools') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan
        @can('role-list')
        <li class="nav-item">
            <a href="
            {{ route('web.roles.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('sidebar.role_permission') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan
        @can('trimester-list')
        <li class="nav-item">
            <a href="
            {{ route('web.trimesters.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('trimester.trimesters') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan
        @can('announcement-list')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('web.announcement.index') }}">
                <span class="menu-title">  {{ __('sidebar.announcement') }}</span>
                <i class="fa fa-bell menu-icon"></i> </a>
        </li>
        @endcan


            @canany(['setting-create', 'acadimic-create', 'users-create'])
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#settings-menu" aria-expanded="false"
                        aria-controls="settings-menu"> <span class="menu-title">{{ __('sidebar.system_settings') }}</span> <i
                            class="fa fa-cog menu-icon"></i> </a>
                    <div class="collapse" id="settings-menu">
                        <ul class="nav flex-column sub-menu">
                            @can('setting-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('app-settings') }}">
                                        {{ __('sidebar.app_settings') }}</a>
                                </li>
                            @endcan
                            @can('setting-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('settings') }}">
                                        {{ __('sidebar.general_settings') }}</a>
                                </li>
                            @endcan

                        @can('acadimic-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('managements') }}">
                                    {{ __('sidebar.acadimic') }}</a>
                            </li>
                        @endcan


                        @can('users-create')
                          <li class="nav-item">
                            <a class="nav-link" href="{{ url('users') }}">
                                {{ __('sidebar.users') }}</a>
                        </li>
                        @endcan
                        </ul>
                    </div>
                </li>

            @endcanany








        </ul>
    </nav>
