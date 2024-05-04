@extends('layouts.masters.school-master')
@php
    $classes=App\Models\Classes::where('grade_id',getSchool()->grade_id)->get();
    $trimesters=App\Models\Trimester::select('id','name')->get();
@endphp
@section('title')
    {{ __('test.tests') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.manage') . ' ' . __('test.tests') }}
            </h3>
        </div>
        @can('school-tests-create')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{  __('test.add_test') }}
                        </h4>
                        <form action="{{ route('school.tests.store') }}" class="create-form" id="formdata">
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
                                    {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                    <select required name="trimester_id" id="trimester_id"
                                            class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('genirale.select') . ' ' . __('trimester.trimester') }}</option>
                                        @foreach ($trimesters as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                    <select required name="subject_id" id="timetable_class_section"
                                            class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('genirale.select')  }}</option>

                                    </select>
                                </div>
                            </div>

                            <div class="show_student_list">
                                <table aria-describedby="mydesc" class='table student_table' id='table_list'
                                       data-toggle="table" data-url="{{ url('school/test-student-list') }}" data-click-to-select="true"
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

                                        <th scope="col" data-field="student_id" data-visible="false">
                                            {{ __('student.student_id') }}</th>


                                        <th scope="col" data-field="roll_number" data-sortable="true">{{ __('student.roll_number') }}
                                        </th>
                                        <th scope="col" data-field="name" data-sortable="false">{{ __('genirale.name') }}
                                        </th>
                                        <th scope="col" data-field="grade" data-sortable="false">{{ __('test.grade') }}
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
                'subject_id': $('#timetable_class_section').val(),
                'trimester_id': $('#trimester_id').val(),
            };
        }

    document.getElementById('class_id').addEventListener('change', function() {
            var gradeId = this.value;
            if(gradeId){
                getSectionsByClass(gradeId);
            }
    });

    document.getElementById('class_section_id_attendance').addEventListener('change', function() {
            var gradeId = this.value;
            if(gradeId){
                getSubjectsBySection(gradeId);
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
    function getSubjectsBySection(sectionId) {

            $.ajax({
                url: "{{ url('school/get-subject-by-class-section') }}",
                type: "GET",
                data: {
                    class_id: sectionId,
                },
                success: function (response) {
                    console.log(response);
                    var selectElement = $("#timetable_class_section");

                    selectElement.empty();

                    selectElement.append('<option value="">{{ __('genirale.select') }}</option>');
                    $.each(response, function(index, data) {
                        // console.log(subject);
                        selectElement.append('<option value="' + data.subject.id + '">' + data.subject.name + '</option>');
                    });

                }
            });
    }





    </script>

    <script>


        $('.btn_attendance').hide();
        function set_data(){
            $(document).ready(function()
            {
                student_section=$('#class_section_id_attendance').val();
                trimester=$('#trimester_id').val();


                if(student_section!='' && trimester!='' )
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

        function validateGrade(input) {
        // Parse the input value as a number
            var inputValue = parseFloat(input.value);

            // Check if the value is NaN or outside the range [0, 20]
            if (isNaN(inputValue) || inputValue < 0) {
                input.value=0;
                alert('Please enter a value between 0 and 20.');

                // Set to the minimum value if less than 0
            } else if (inputValue > 20) {
                input.value=20;
                alert('Please enter a value between 0 and 20.');

                 // Set to the maximum value if greater than 20
            }
        }
    </script>



@endsection
