@extends('layouts.masters.school-master')

@section('title')
    {{ __('sidebar.timetable') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.create') . ' ' . __('sidebar.timetable') }}
            </h3>
        </div>
        @can('school-timetable-create')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-6">
                                <label>{{ __('classes.class') }} {{ __('section.section') }} <span class="text-danger">*</span></label>
                                <select required name="class_section_id" id="timetable_class_section" class="col-md-6 col-sm-12 form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{ __('genirale.select') }}</option>
                                    @foreach ($class_sections as $section)
                                        <option value="{{ $section->id }}" data-class="{{ $section->id }}">{{ $section->name }} </option>
                                    @endforeach
                                </select>
                                <div class="select_error text-danger d-none">This field is required.</div>
                                <input type="hidden" name="active_tab" id="active_tab">
                            </div>
                              <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('section.section') }} <span class="text-danger">*</span></label>
                                <select name="section_id" id="s_section_id" class="section_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">

                                </select>
                            </div>
                        </div>
                        <div id="timetable-div " class="istabActiveItwillremoved d-none">
                            <ul class="nav nav-tabs  timetable_nav " role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active " id="monday-tab" data-id="monday" data-toggle="tab" href="#monday" role="tab" aria-controls="monday" aria-selected="false">{{__('genirale.Monday')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tuesday-tab" data-id="tuesday" data-toggle="tab" href="#tuesday" role="tab" aria-controls="tuesday" aria-selected="false">{{__('genirale.Tuesday')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="wednesday-tab" data-id="wednesday" data-toggle="tab" href="#wednesday" role="tab" aria-controls="wednesday" aria-selected="false">{{__('genirale.Wednesday')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="thursday-tab" data-id="thursday" data-toggle="tab" href="#thursday" role="tab" aria-controls="thursday" aria-selected="false">{{__('genirale.Thursday')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="friday-tab" data-id="friday" data-toggle="tab" href="#friday" role="tab" aria-controls="friday" aria-selected="false">{{__('genirale.Friday')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="saturday-tab" data-id="saturday" data-toggle="tab" href="#saturday" role="tab" aria-controls="saturday" aria-selected="false">{{__('genirale.Saturday')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sunday-tab" data-id="sunday" data-toggle="tab" href="#sunday" role="tab" aria-controls="sunday" aria-selected="false">{{__('genirale.Sunday')}}</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="monday" role="tabpanel" aria-labelledby="monday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="monday_group" class="set_monday">
                                                <div data-repeater-item class="row mb-2 monday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tuesday" role="tabpanel" aria-labelledby="tuesday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="tuesday_group" class="set_tuesday">
                                                <div data-repeater-item class="row mb-2 tuesday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wednesday" role="tabpanel" aria-labelledby="wednesday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="wednesday_group" class="set_wednesday">
                                                <div data-repeater-item class="row mb-2 wednesday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="thursday" role="tabpanel" aria-labelledby="thursday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="thursday_group" class="set_thursday">
                                                <div data-repeater-item class="row mb-2 thursday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="friday" role="tabpanel" aria-labelledby="friday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="friday_group" class="set_friday">
                                                <div data-repeater-item class="row mb-2 friday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="saturday" role="tabpanel" aria-labelledby="saturday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="saturday_group" class="set_saturday">
                                                <div data-repeater-item class="row mb-2 saturday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sunday" role="tabpanel" aria-labelledby="sunday-tab">
                                    <div class="media">
                                        <div class="media-body">
                                            @include('pages.schools.timetable.tab_title')
                                            <div data-repeater-list="sunday_group" class="set_sunday">
                                                <div data-repeater-item class="row mb-2 sunday_count">
                                                    @include('pages.schools.timetable.addmore')
                                                </div>
                                            </div>
                                            @include('pages.schools.timetable.tab_footer')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
@endsection

@section('script')
    <script>


        function getSectionsByClass(gradeId) {
            console.log(gradeId);
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/getSection-list/' + gradeId, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    console.log( JSON.parse(this.responseText));
                    var sections = JSON.parse(this.responseText);
                    var sectionSelect = document.getElementById('s_section_id');
                    sectionSelect.innerHTML = '';
                    var option = document.createElement('option');
                        option.text = '{{__('genirale.select')}}';
                        sectionSelect.appendChild(option);
                    sections.forEach(function(section) {
                    console.log(section);
                        var option = document.createElement('option');
                        option.value = section.id;
                        option.text = section.name;
                        sectionSelect.appendChild(option);
                    });
                }
            };
            xhr.send();

        }
        $('#timetable_class_section').on('change', function (e) {
            var gradeId = this.value;
            if(gradeId){
                getSectionsByClass(gradeId);
            }

            $('.istabActiveItwillremoved').removeClass('d-none');

        });

        $('#s_section_id').on('change', function (e) {

            set_subject();
            checktimetable(tab);
            $('.istabActiveItwillremoved').removeClass('d-none');

        });

        function set_subject() {
            $('.select_error').addClass('d-none');
            if ($('#timetable_class_section').val() != '') {
                $('.addmore').removeClass('d-none');
            } else {
                $('.addmore').addClass('d-none');
            }

            tab = $('#active_tab').val()
            $('#' + tab + ' input[name="class_section_id"').val($('#timetable_class_section').val());
            var class_id =$('#s_section_id').val();
            $.ajax({
                url: "{{ url('school/get-subject-by-class-section') }}",
                type: "GET",
                data: {
                    class_id: class_id
                },
                success: function (response) {
                    var html = '';
                    if (response != '') {
                        html += '<option value="">Select Subject</option>';
                        for (let i = 0; i < response.length; i++) {
                            html += '<option value=' + response[i]['subject']['id'] + '>' + response[i]['subject']['name'] +' - '+response[i]['subject']['type']+'</option>';
                        }
                    } else {
                        html += '<option value="">No Data</option>';
                    }

                    $('.set_subject_id').html(html);
                    $('#' + tab + ' input[name="section_id"').val($('#s_section_id').val());
                }


            });
        }

        $(document).ready(function (e) {
            tab = $('.timetable_nav').find('li a.active').attr('data-id');
            total_row = $('.' + tab + '_count').length;
            $('#' + tab + ' input[name="day"').val(tab);
            $('#active_tab').val(tab);
            get_total();
            set_teacher_data();
        });

        // tab change data
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            tab = $(e.target).attr("data-id");
            total_row = $('.' + tab + '_count').length;
            $('#' + tab + ' input[name="day"').val(tab);
            $('#' + tab + ' input[name="class_section_id"').val($('#timetable_class_section').val());
            $('#' + tab + ' input[name="section_id"').val($('#s_section_id').val());
            $('#active_tab').val(tab);
            get_total();
            set_teacher_data();
            checktimetable(tab);
        });

        function get_total() {
            $('.addmore').on('click', function () {
                total_row = $('.' + tab + '_count').length;
                var html = '';
                html += '';
                data = (total_row - 1);
                $('select[name="' + tab + '_group[' + data + '][subject_id]"]').html($('select[name="' + tab +
                    '_group[0][subject_id]"]').html());
                set_teacher_data();

            });
            $('.row_remove').on('click', function () {
                total_row = $('.' + tab + '_count').length;
                set_teacher_data();
            });
        }

        function set_teacher_data() {
            for (let k = 0; k < total_row; k++) {
                $('select[name="' + tab + '_group[' + k + '][subject_id]"]').on('change', function (e) {
                    var subject_id = $(this).val();
                    var class_section_id = $('#s_section_id').val();

                    $.ajax({
                        url: "{{ url('school/getteacherbysubject') }}",
                        type: "GET",
                        data: {
                            subject_id: subject_id,
                            class_section_id: class_section_id
                        },
                        success: function (response) {
                            var html = '';
                            if (response != '') {

                                html += '<option value="">Select Teacher</option>';
                                for (let i = 0; i < response.length; i++) {
                                    html += '<option data-id=' + response[i]['id'] + ' value=' +
                                        response[i]['teacher_id'] + '>' + response[i]['teacher']
                                            ['first_name'] + ' ' + response[i]['teacher']['last_name'] + '</option>';
                                }

                            } else {
                                html += '<option value="">No Data</option>';
                            }
                            $('select[name="' + tab + '_group[' + k + '][teacher_id]"]').html(html);
                        }
                    });
                });
            }
        }

        function checktimetable(day_name) {
            var day = '';
            if (day_name == 'monday') {
                day = 1;
            } else if (day_name == 'tuesday') {
                day = 2;
            } else if (day_name == 'wednesday') {
                day = 3;
            } else if (day_name == 'thursday') {
                day = 4;
            } else if (day_name == 'friday') {
                day = 5;
            } else if (day_name == 'saturday') {
                day = 6;
            } else if (day_name == 'sunday') {
                day = 7;
            }
            var class_section_id = $('#timetable_class_section').val();
            var section_id = $('#s_section_id').val();
            $.ajax({
                url: "{{ url('school/checkTimetable') }}",
                type: "GET",
                data: {
                    class_section_id: class_section_id,
                    section_id: section_id,
                    day: day
                },
                success: function (response) {
                    var html = '';

                    if (response != '') {

                        set_subject();

                        for (let i = 0; i < response.length; i++) {

                            html += '<div data-repeater-item="" class="row mb-2 ' + day_name + '_count" id="' + day_name + '_count[' + i + ']">' +
                                '<input required hidden type="text" value="' + response[i]['id'] + '" name="' + day_name + '_group[' + i + '][id]" id="' + day_name + '_id[' + i + ']" class="form-control" placeholder="Id">' +
                                '<div class="input-group col-sm-12 col-md-2">' +
                                '<select required name="' + day_name + '_group[' + i + '][subject_id]" id="subject" class="form-control set_subject_id ' + day_name + '_group[' + i + '][subject_id]" style="width:100%;" tabindex="-1" aria-hidden="true"></select>' +
                                '</div>' +
                                '<div class="input-group col-sm-12 col-md-2">' +
                                '<select required name="' + day_name + '_group[' + i + '][teacher_id]" id="teacher" class="form-control set_teacher_id" style="width:100%;" tabindex="-1" aria-hidden="true"></select>' +
                                '</div>' +
                                '<div class="input-group col-sm-12 col-md-2">' +
                                '<input required type="time" value="' + response[i]['start_time'] + '" name="' + day_name + '_group[' + i + '][start_time]" class="timetable_start_time form-control" placeholder="Start time">' +
                                '</div>' +
                                '<div class="input-group col-sm-12 col-md-2">' +
                                '<input required type="time" value="' + response[i]['end_time'] + '" name="' + day_name + '_group[' + i + '][end_time]" class="timetable_end_time form-control" placeholder="End time">' +
                                '</div>' +
                                '<div class="input-group col-sm-12 col-md-2">' +
                                '<input type="text" value="' + response[i]['note'] + '" name="' + day_name + '_group[' + i + '][note]" class="form-control" placeholder="Note">' +
                                '</div>' +
                                '<button data-repeater-delete type="button" class="row_remove btn btn-gradient-danger btn-sm icon-btn ml-2"><i class="fa fa-trash"></i></button>' +
                                '</div>'
                        }
                        $('.set_' + day_name).html(html);
                        tab = day_name;
                        total_row = $('.' + tab + '_count').length;
                        set_teacher_data();

                        for (let j = 0; j < response.length; j++) {
                            setTimeout(function () {
                                $('select[name^="' + day_name + '_group[' + j + '][subject_id]"]').children('option[value="' + response[j]['subject_teacher']['subject']['id'] + '"]').attr("selected", true);
                                $('select[name^="' + day_name + '_group[' + j + '][subject_id]"]').trigger('change');
                                setTimeout(function () {
                                    $('select[name^="' + day_name + '_group[' + j + '][teacher_id]"]').children('option[value="' + response[j]['subject_teacher']['teacher']['id'] + '"]').attr("selected", true);
                                }, 1000)
                            }, 1000)
                        }
                    }
                }
            });
        }
    </script>
@endsection

