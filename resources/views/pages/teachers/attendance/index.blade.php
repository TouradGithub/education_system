@extends('layouts.masters.teacher-master')
@php
$teacher = auth('teacher')->user();

// Retrieve the sections associated with the teacher
$sections = $teacher->sectionTeachers;
    // $sections=App\Models\Classes::where('grade_id',getSchool()->grade_id)->get();
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
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('genirale.create') . ' ' . __('sidebar.attendance') }}
                        </h4>
                        <form action="{{ route('teacher.attendance.store') }}" class="create-form" id="formdata">
                            @csrf
                            <div class="row" id="toolbar">


                                <div class="form-group col-sm-12 col-md-4">
                                    {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                    <select required name="section_id" id="class_section_id_attendance"
                                            class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('genirale.select') . ' ' . __('section.section') }}</option>
                                        @foreach ($sections as $item)
                                        <option value="{{$item->section->id }}" data-section="{{ $item->section->id }}">{{ $item->section->name }}</option>
                                    @endforeach
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
        var formattedDate = new Date(date ); // Set the time to midnight

        var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var dayName = daysOfWeek[formattedDate.getDay()];
        return dayNum=getNumday(dayName);
    }

    function getTimeTable() {
        section_id = $('#class_section_id_attendance').val();
        date = $('#date').val();

        dayNum=getDateForDate(date);

        if(section_id != '' && dayNum != ''){
            $.ajax({
                url: "{{ url('school/getTimetable-list') }}",
                type: "GET",
                data: {
                    day: dayNum,
                    section_id: section_id
                },
                success: function (response) {



                    var sections = this.response;
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
                        sectionSelect.appendChild(option);

                    }
                }
            });
        }


        }

    </script>

    <script>
        $('#date').on('input change', function () {
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

            set_data();
        });
    </script>



@endsection
