<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- dashboard --}}
        <li class="nav-item">
            <a  class="nav-link" href="{{ url('school/home') }}">
                <span class="menu-title">{{ trans('sidebar.dashboard') }}</span>
            <i class="fa fa-home menu-icon"></i> </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('school.subjects.index') }}" class="nav-link">
                    <span class="menu-title">
                        {{ __('sidebar.Subjects') }}
                    </span>
                    <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#timetable-menu" aria-expanded="false"
                aria-controls="timetable-menu"> <span class="menu-title">{{ __('sidebar.timetable') }}</span>

                <i class="fa fa-calendar menu-icon"></i> </a>
            <div class="collapse" id="timetable-menu">
                <ul class="nav flex-column sub-menu">
                    {{-- @can('timetable-create') --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.timetable.index') }}">{{ __('sidebar.create_timetable') }} </a>
                        </li>
                    {{-- @endcan --}}
                    {{-- @canany(['class-timetable', 'class-teacher']) --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('school/class-timetable') }}">
                                {{ __('sidebar.class_timetable') }}
                            </a>
                        </li>
                    {{-- @endcanany --}}
                    {{-- @can('teacher-timetable') --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('school/teacher-timetable') }}">
                                {{ __('sidebar.teacher_timetable') }}
                            </a>
                        </li>
                    {{-- @endcan --}}
                </ul>
            </div>
        </li>



    {{-- view attendance --}}

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#attendance-menu" aria-expanded="false"
                aria-controls="attendance-menu"> <span class="menu-title">{{ __('sidebar.attendance') }}</span> <i
                    class="fa fa-check menu-icon"></i> </a>
            <div class="collapse" id="attendance-menu">
                <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.attendance.index') }}">
                                {{ __('sidebar.add_attendance') }}
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.attendance.view') }}">
                                {{ __('sidebar.view_attendance') }}
                            </a>
                        </li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('school.teachers.index') }}" class="nav-link"> <span
                    class="menu-title">{{ __('sidebar.teacher') }}</span> <i class="fa fa-user menu-icon"></i> </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('school.subject-teachers.index') }}" class="nav-link">
                    <span class="menu-title">
                        {{ __('sidebar.assign') . ' ' . __('sidebar.Subjects') . ' ' . __('sidebar.teacher') }}
                    </span>
                    <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#student-menu" aria-expanded="false"
                aria-controls="settings-menu"> <span class="menu-title">{{ __('sidebar.students') }}</span>
                 <i  class="fa fa-cog menu-icon"></i> </a>
            <div class="collapse" id="student-menu">
                <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.student.create') }}">
                                {{ __('sidebar.new_student') }}</a>
                        </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.student.index') }}">
                            {{ __('sidebar.all_student') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.student.promotions.create') }}">
                            {{ __('sidebar.promote_student') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.tests.index') }}">
                            {{ __('test.tests') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.exams.index') }}">
                            {{ __('exam.exams') }}</a>
                    </li>
                </ul>
            </div>
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

        <li class="nav-item">
            <a href="
            {{ route('web.grades.index') }}
            " class="nav-link"> <span
                    class="menu-title">{{ __('sidebar.grades') }}</span> <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>




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
                            @can('school-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('schools') }}">
                                    {{ __('sidebar.schools') }}</a>
                            </li>
                        @endcan
                        @can('management-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('managements') }}">
                                    {{ __('sidebar.acadimic') }}</a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.user.index') }}">
                                {{ __('sidebar.users') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.role.index') }}">
                                {{ __('genirale.role') }}</a>
                        </li>

                        </ul>
                    </div>
                </li>


        </ul>
    </nav>
