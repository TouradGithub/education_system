<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- dashboard --}}
        <li class="nav-item">
            <a  class="nav-link" href="{{ url('teacher/home') }}">
                <span class="menu-title">{{ trans('sidebar.dashboard') }}</span>
            <i class="fa fa-home menu-icon"></i> </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#timetable-menu" aria-expanded="false"
                aria-controls="timetable-menu"> <span class="menu-title">{{ __('sidebar.timetable') }}</span>

                <i class="fa fa-calendar menu-icon"></i> </a>
            <div class="collapse" id="timetable-menu">
                <ul class="nav flex-column sub-menu">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.timetable.index') }}">
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
                            <a class="nav-link" href="{{ route('teacher.attendance.index') }}">
                                {{ __('sidebar.add_attendance') }}
                            </a>
                        </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#student-menu" aria-expanded="false"
                aria-controls="settings-menu"> <span class="menu-title">{{ __('sidebar.students') }}</span>
                <i class="fa fa-graduation-cap menu-icon"></i></a>
            <div class="collapse" id="student-menu">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('teacher.sections.index') }}">
                            {{ __('section.sections') }}
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.tests.index') }}">
                <span class="menu-title">   {{ __('test.tests') }}</span>
                <i class="fa fa-file-text menu-icon"></i></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.exams.index') }}">
                <span class="menu-title">  {{ __('exam.exams') }}</span>
                <i class="fa fa-file-text menu-icon"></i></a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.announcement.index') }}">
                <span class="menu-title">  {{ __('sidebar.announcement') }}</span>
                <i class="fa fa-bell menu-icon"></i> </a>
        </li> --}}

        </ul>
    </nav>
