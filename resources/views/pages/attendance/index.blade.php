@extends('layouts.masters.school-master')
@php
    $classes=App\Models\Classes::where('grade_id',getSchool()->grade_id)->get();
@endphp
@section('title')
    {{ __('sidebar.attendance') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.manage') . ' ' . __('sidebar.attendance') }}
            </h3>
        </div>
        @can('school-attendance-create')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('genirale.create') . ' ' . __('sidebar.attendance') }}
                        </h4>
                        <form action="{{ route('school.attendance.store') }}" class="create-form" id="formdata">
                            @csrf
                            <div class="row" id="toolbar">
                                <div class="form-group col-sm-12 col-md-4">
                                    {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                    <select required name="class_id" id="class_id"
                                            class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('genirale.select') . ' ' . __('classes.class') }}</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" data-class="{{ $class->id }}">
                                                {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                    <select required name="section_id" id="class_section_id_attendance"
                                            class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('genirale.select') . ' ' . __('section.section') }}</option>

                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    {{-- <label>{{ __('date') }} <span class="text-danger">*</span></label> --}}
                                    {!! Form::text('date',  null, ['required', 'placeholder' => __('genirale.date'), 'class' => 'datepicker-popup form-control', 'id' => 'date','data-date-end-date'=>"0d"]) !!}
                                    <span class="input-group-addon input-group-append"></span>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                    <select required name="timetable_day" id="timetable_class_section"
                                            class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('genirale.select')  }}</option>

                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <input readonly type="button" id="timetable_teacher_section" value=""  class="form-control select2">

                                </div>
                            </div>

                            <div class="show_student_list">
                                <table aria-describedby="mydesc" class='table student_table' id='table_list'
                                       data-toggle="table" data-url="{{ url('school/student-list') }}" data-click-to-select="true"
                                       data-side-pagination="server" data-pagination="false"
                                       data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                       data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                       data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1"
                                       data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                       data-sort-order="desc" data-maintain-selected="true" data-export-types='["txt","excel"]'
                                       data-export-options='{ "fileName": "student-list-<?= date('d-m-y') ?>" ,"ignoreColumn": ["operate"]}'
                                       data-query-params="queryParams">
                                    <thead>
                                    <tr>

                                        <th scope="col" data-field="student_id" data-sortable="true">
                                            {{ __('student.student_id') }}</th>


                                        <th scope="col" data-field="roll_number" data-sortable="true">{{ __('student.roll_number') }}
                                        </th>
                                        <th scope="col" data-field="name" data-sortable="false">{{ __('genirale.name') }}
                                        </th>
                                        <th scope="col" data-field="type" data-sortable="false">{{ __('sidebar.attendance') }}
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <input class="btn btn-theme btn_attendance mt-4" id="create-btn" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endcan

    </div>
@endsection

@section('script')
    <script>
        function queryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search,
                'section_id': $('#class_section_id_attendance').val(),
                'timetable_id': $('#timetable_class_section').val(),
                'date':$('#date').val(),
            };
        }
        $('#timetable_teacher_section').val('');
        $('#timetable_teacher_section').hide();

    document.getElementById('class_id').addEventListener('change', function() {
            var gradeId = this.value;
            if(gradeId){
                getSectionsByClass(gradeId);
            }
    });
    function getSectionsByClass(gradeId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/getSection-list/' + gradeId, true);
        xhr.onload = function() {
            if (this.status === 200) {
                var sections = JSON.parse(this.responseText);
                var sectionSelect = document.getElementsByName("section_id")[0];
                sectionSelect.innerHTML = '';
                var option = document.createElement('option');
                        option.text ='{{__('genirale.select')}}';
                        sectionSelect.appendChild(option);
                sections.forEach(function(section) {
                    var option = document.createElement('option');
                    option.value = section.id;
                    option.text = section.name;
                    sectionSelect.appendChild(option);
                });
            }
        };
        xhr.send();

    }
    function getDateForDate(date){
        // var formattedDate = new Date(date); // Convert the input to a Date object
        // var dayNum = formattedDate.getDay(); // Get the day number (0 for Sunday, 1 for Monday, etc.)
        // console.log("Formatted Date:", formattedDate);
        // console.log("Day Number:", dayNum);
        // return dayNum;

        var formattedDate = new Date(date); // Convert the input to a Date object

        // Get the day number (0 for Sunday, 1 for Monday, etc.)
        var dayNum = formattedDate.getDay();

        // Adjust dayNum to match Monday = 1, Sunday = 7
        var adjustedDayNum = (dayNum === 0) ? 7 : dayNum;

        // Get the day name
        var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var dayName = daysOfWeek[dayNum];

        console.log("Formatted Date:", formattedDate);
        console.log("Day Number (Monday=1, Sunday=7):", adjustedDayNum);
        console.log("Day Name:", dayName);

        return adjustedDayNum;
    }

    function getTimeTable() {
        section_id = $('#class_section_id_attendance').val();
        date = $('#date').val();

        if(section_id != '' && date != ''){
            $.ajax({
                url: "{{ url('school/getTimetable-list') }}",
                type: "GET",
                data: {
                    date: date,
                    section_id: section_id
                },
                success: function (response) {



                    var sections = this.response;
                    console.log(response);
                    var sectionSelect = document.getElementById("timetable_class_section");
                    sectionSelect.innerHTML = '';

                    var option = document.createElement('option');
                        option.text = '{{__('genirale.select')}}';
                        sectionSelect.appendChild(option);
                    for (let i = 0; i < response.length; i++) {

                        var startTime = response[i]['start_time'].slice(0, 5);
                        var endTime = response[i]['end_time'].slice(0, 5);

                        var option = document.createElement('option');
                        option.value =response[i]['id'];
                        option.text = startTime+' --- '+endTime;
                        option.setAttribute('data-teacher', response[i]['subject_teacher']['teacher']['first_name'] + ' ' + response[i]['subject_teacher']['teacher']['last_name']);
                        option.setAttribute('data-subject', response[i]['subject_teacher']['subject']['name'] );
                        sectionSelect.appendChild(option);


                    }
                }
            });
        }


        }

    </script>

    <script>
        $('#date').on('input change', function () {
            console.log("changed");
            $('#timetable_teacher_section').val('');
            $('#timetable_teacher_section').hide();
            getTimeTable();

        });

        $('.btn_attendance').hide();
        function set_data(){
            $(document).ready(function()
            {
                student_section=$('#class_section_id_attendance').val();


                if(student_section!='' && date!='' )
                {
                    $('.btn_attendance').show();
                }
                else{
                    $('.btn_attendance').hide();
                }
            });
        }
        $('#timetable_class_section').on('change', function() {

            var selectedOption = $(this).find(':selected');


            var dataTeacher = selectedOption.data('teacher');
            var dataSubject = selectedOption.data('subject');


            $('#timetable_teacher_section').show();
            $('#timetable_teacher_section').val('');
            $('#timetable_teacher_section').val(dataTeacher+' - '+dataSubject);


            set_data();
        });
    </script>



@endsection
