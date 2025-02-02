<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar" >
    <ul class="nav">
        {{-- dashboard --}}
        <li class="nav-item">
            <a  class="nav-link" href="{{ url('school/home') }}">
                <span class="menu-title">{{ trans('sidebar.dashboard') }}</span>
            <i class="fa fa-home menu-icon"></i> </a>
        </li>
        @can('school-sections-index')
        <li class="nav-item">
            <a href="{{ route('school.sections.index') }}" class="nav-link">
                    <span class="menu-title">
                        {{ __('section.section') }}
                    </span>
                    <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan
        @can('school-subject-index')
        <li class="nav-item">
            <a href="{{ route('school.subjects.index') }}" class="nav-link">
                    <span class="menu-title">
                        {{ __('sidebar.Subjects') }}
                    </span>
                    <i class="fa fa-calendar-o menu-icon"></i>
            </a>
        </li>
        @endcan

        @can('school-teachers-index')
            <li class="nav-item">
                <a href="{{ route('school.teachers.index') }}" class="nav-link"> <span
                        class="menu-title">{{ __('sidebar.teacher') }}</span> <i class="fa fa-user menu-icon"></i> </a>
            </li>
        @endcan
        @can('school-subject-teachers')
            <li class="nav-item">
                <a href="{{ route('school.subject-teachers.index') }}" class="nav-link">
                        <span class="menu-title">
                            {{ __('sidebar.assign') . ' ' . __('sidebar.Subjects') . ' ' . __('sidebar.teacher') }}
                        </span>
                        <i class="fa fa-calendar-o menu-icon"></i>
                </a>
            </li>
        @endcan
        @canany(['school-timetable-index','school-class-timetable'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#timetable-menu" aria-expanded="false"
                    aria-controls="timetable-menu"> <span class="menu-title">{{ __('sidebar.timetable') }}</span>

                    <i class="fa fa-calendar menu-icon"></i> </a>
                <div class="collapse" id="timetable-menu">
                    <ul class="nav flex-column sub-menu">
                        @can('school-timetable-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('school.timetable.index') }}">{{ __('sidebar.create_timetable') }} </a>
                            </li>
                        @endcan
                        @can('school-class-timetable')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('school/class-timetable') }}">
                                    {{ __('sidebar.class_timetable') }}
                                </a>
                            </li>
                        @endcanany
                        {{-- @can('teacher-timetable') --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('school/teacher-timetable') }}">
                                    {{ __('sidebar.teacher_timetable') }}
                                </a>
                            </li> --}}
                        {{-- @endcan --}}
                    </ul>
                </div>
            </li>
        @endcanany

        @canany(['school-attendance-index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#attendance-menu" aria-expanded="false"
                    aria-controls="attendance-menu"> <span class="menu-title">{{ __('sidebar.attendance') }}</span> <i
                        class="fa fa-check menu-icon"></i> </a>
                <div class="collapse" id="attendance-menu">
                    <ul class="nav flex-column sub-menu">
                        @can('school-attendance-index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('school.attendance.index') }}">
                                    {{ __('sidebar.add_attendance') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany

        @canany(['school-students-create','school-tests-index',
        'school-students-index','school-tests-create'])
        <li class="nav-item" >
            <a class="nav-link" data-toggle="collapse" href="#student-menu" aria-expanded="false"
                aria-controls="settings-menu"> <span class="menu-title">{{ __('sidebar.students') }}</span>
                 <i  class="fa fa-cog menu-icon"></i> </a>
            <div class="collapse" id="student-menu">
                <ul class="nav flex-column sub-menu">
                    @can('school-students-create')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.student.create') }}">
                                {{ __('sidebar.new_student') }}</a>
                        </li>
                    @endcan
                    @can('school-students-index')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.student.index') }}">
                            {{ __('sidebar.all_student') }}</a>
                    </li>
                    @endcan

                    @can('school-tests-index')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.tests.index') }}">
                            {{ __('test.tests') }}</a>
                    </li>
                    @endcan

                    @can('school-exams-index')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.exams.index') }}">
                            {{ __('exam.exams') }}</a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcanany

        @can('school-announcement-index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('school.announcement.index') }}">
                    <span class="menu-title">  {{ __('sidebar.announcement') }}</span>
                    <i class="fa fa-bell menu-icon"></i> </a>
            </li>
        @endcan



        @if (getSchool()->type=="private")
        @canany(['school-fees-class-index','school-fees-paid-index'])
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#fees-menu" aria-expanded="false"
                aria-controls="exam-menu">
                <span class="menu-title">{{ __('genirale.fees') }}</span>
                <i class="fa fa-dollar menu-icon"></i>
            </a>
            <div class="collapse" id="fees-menu">
                <ul class="nav flex-column sub-menu">
                    @can('school-fees-class-index')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.fees.class.index') }}">{{ __('sidebar.assign') }}
                            {{ __('classes.class') }}
                        </a>
                    </li>
                    @endcan
                    @can('school-fees-paid-index')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.fees.paid.index') }}"> {{ __('genirale.fees') }}
                            {{ __('paid') }}
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcanany
        @endif




    {{-- view attendance --}}





        @canany(['school-promotion-create','school-promotion-index'])
        <li class="nav-item" >
            <a class="nav-link" data-toggle="collapse" href="#promotion-menu" aria-expanded="false"
                aria-controls="settings-menu"> <span class="menu-title">{{__('promotion.promotions')}}</span>
                 <i  class="fa fa-cog menu-icon"></i> </a>
            <div class="collapse" id="promotion-menu">
                <ul class="nav flex-column sub-menu">
                    @can('school-promotion-create')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.student.promotions.create') }}">
                                {{ __('promotion.add_promotion') }}</a>
                        </li>
                    @endcan

                    @can('school-promotion-index')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('school.student.promotions.index') }}">
                            {{ __('promotion.list_promotion') }}</a>
                    </li>
                    @endcan


                </ul>
            </div>
        </li>
        @endcanany
        @canany(['school-settings-create','school-general_settings-update'
           ,'school-role-index','school-user-index'])
            <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#settings-menu" aria-expanded="false"
                        aria-controls="settings-menu"> <span class="menu-title">{{ __('sidebar.system_settings') }}</span> <i
                            class="fa fa-cog menu-icon"></i> </a>
                    <div class="collapse" id="settings-menu">
                        <ul class="nav flex-column sub-menu">


                        @can('school-settings-create')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('school.setting-index') }}">
                                    {{ __('sidebar.general_settings') }}</a>
                            </li>
                        @endcan


                        @can('school-user-index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('school.user.index') }}">
                                    {{ __('sidebar.users') }}
                                </a>
                            </li>
                        @endcan
                        @can('school-role-index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('school.role.index') }}">
                                    {{ __('genirale.role') }}</a>
                            </li>
                        @endcan

                        </ul>
                    </div>
            </li>
        @endcanany


        </ul>
    </nav>



