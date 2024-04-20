<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- dashboard --}}
        <li class="nav-item">
            <a  class="nav-link" href="{{ url('/') }}">
                <span class="menu-title">{{ __('dashboard') }}</span>
            <i class="fa fa-home menu-icon"></i> </a>
        </li>
        @can('session-year-create')
            <li class="nav-item">
                <a href="
                {{ route('session-years.index') }}
                " class="nav-link"> <span
                        class="menu-title">{{ __('session_years') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
                </a>
            </li>
        @endcan

        {{-- @can('session-year-create') --}}
        <li class="nav-item">
            <a href="
            {{ route('web.grades.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('Grades') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>

        @can('school-list',)
        <li class="nav-item">
            <a href="
            {{ route('web.schools.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('Schools') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan
    {{-- @endcan --}}

        {{-- @hasrole('Super Admin') --}}
            {{-- academics --}}
            {{-- @canany(['medium-create', 'section-create', 'subject-create', 'class-create', 'subject-create',
                'class-teacher-create', 'subject-teacher-list', 'subject-teachers-create', 'assign-class-to-new-student',
                'promote-student-create']) --}}
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#settings-menu" aria-expanded="false"
                        aria-controls="settings-menu"> <span class="menu-title">{{ __('system_settings') }}</span> <i
                            class="fa fa-cog menu-icon"></i> </a>
                    <div class="collapse" id="settings-menu">
                        <ul class="nav flex-column sub-menu">
                            @can('setting-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('app-settings') }}">
                                        {{ __('app_settings') }}</a>
                                </li>
                            @endcan
                            @can('setting-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('settings') }}">
                                        {{ __('general_settings') }}</a>
                                </li>
                            @endcan
                            @can('school-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('schools') }}">
                                    {{ __('Schools') }}</a>
                            </li>
                        @endcan
                        @can('management-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('managements') }}">
                                    {{ __('Managements') }}</a>
                            </li>
                        @endcan


                        {{-- @can('management-create') --}}
                          <li class="nav-item">
                            <a class="nav-link" href="{{ url('users') }}">
                                {{ __('users') }}</a>
                        </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    {{-- <a class="nav-link" data-toggle="collapse" href="#academics-menu" aria-expanded="false"
                        aria-controls="academics-menu"> <span class="menu-title">{{ __('academics') }}</span> <i
                            class="fa fa-university menu-icon"></i> </a> --}}
                    <div class="collapse" id="academics-menu">
                        <ul class="nav flex-column sub-menu">
                            @can('medium-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="
                                    {{-- {{ route('medium.index') }} --}}
                                    "> {{ __('medium') }} </a>
                                </li>
                            @endcan

                            @can('section-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="
                                    {{-- {{ route('section.index') }} --}}
                                    "> {{ __('section') }} </a>
                                </li>
                            @endcan

                            @can('stream-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="
                                    {{-- {{ route('stream.index') }} --}}
                                    "> {{ __('stream') }} </a>
                                </li>
                            @endcan

                            @can('shift-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('shifts.index') }}"> {{ __('shifts') }} </a>
                            </li>
                            @endcan

                            @can('subject-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('subject.index') }}"> {{ __('subject') }} </a>
                                </li>
                            @endcan

                            @can('class-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('class.index') }}"> {{ __('class') }} </a>
                                </li>
                            @endcan

                            @can('subject-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('class.subject') }}">{{ __('assign_class_subject') }} </a>
                                </li>
                            @endcan
                            @can('class-teacher-create')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('class.teacher') }}">
                                        {{ __('assign_class_teacher') }}
                                    </a>
                                </li>
                            @endcan

                            @canany(['subject-teacher-list', 'subject-teacher-create', 'subject-teacher-edit',
                                'subject-teacher-delete'])
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('subject-teachers.index') }}">
                                        {{ __('assign') . ' ' . __('subject') . ' ' . __('teacher') }}
                                    </a>
                                </li>
                            @endcan
                            @can('assign-class-to-new-student')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('students.assign-class') }}">
                                        {{ __('assign_new_student_class') }}
                                    </a>
                                </li>
                            @endcan
                            {{-- @can('promote-student-create') --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="">
                                        {{ __('promote_student') }}
                                    </a>
                                </li>
                            {{-- @endcan --}}
                        </ul>
                    </div>
                </li>
            {{-- @endcanany --}}
        {{-- @endrole --}}







        </ul>
    </nav>
