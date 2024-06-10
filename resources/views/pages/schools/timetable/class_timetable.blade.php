@extends('layouts.masters.school-master')

@section('title')
    {{ __('sidebar.class_timetable') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.manage').' '.__('sidebar.class_timetable') }}
            </h3>
        </div>
        @can('school-class-timetable')
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card search-container">
                    <div class="card">
                        <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label>{{ __('classes.class') }} {{ __('section.section') }} <span class="text-danger">*</span></label>
                                            <select required name="class_section_id" id="class_timetable_class_section" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                                <option value="">{{__('genirale.select')}}</option>
                                                @foreach($class_sections as $section)
                                                    <option value="{{$section->id}}" data-class="{{$section->id}}" data-section="{{$section->id}}">{{$section->name}} {{$section->class->streams->name ?? ' '}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label>{{ __('classes.class') }} {{ __('section.section') }} <span class="text-danger">*</span></label>
                                            <select name="section_id" id="time_section_id" class="section_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning text-center w-75 m-auto warning_no_data" role="alert">
                                        <strong>{{__('genirale.no_data_found')}}</strong>
                                    </div>
                                    <div class="row set_timetable"></div>



                        </div>
                    </div>
                </div>

            </div>
        @endcan

    </div>
@endsection

@section('script')
    <script>
        document.getElementById('class_timetable_class_section').addEventListener('change', function() {
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
                    var sectionSelect = document.getElementById('time_section_id');
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

        $('#time_section_id').on('change', function (e) {
            $('.list_buttons').show(200);
            var class_section_id = $(this).val();
            var class_id = $(this).find(':selected').attr('data-class');
            // var section_id = $(this).find(':selected').attr('data-section');
            $('.set_timetable').html('');
            $.ajax({
                url: "{{ url('school/gettimetablebyclass') }}" ,
                type: "GET",
                data: {
                    class_section_id: class_section_id
                },
                success: function (response) {
                    var html = '';
                    if (response['days'].length) {
                        $('.warning_no_data').hide(300);
                        for (let i = 0; i < response['days'].length; i++) {
                            let day;
                            if (  response['days'][i]['day']==1) {
                                day = '{{__('genirale.Monday')}}';
                            } else if (  response['days'][i]['day']==2) {
                                day = '{{__('genirale.Tuesday')}}';
                            } else if (  response['days'][i]['day']==3) {
                                day = '{{__('genirale.Wednesday')}}';
                            } else if ( response['days'][i]['day'] ==4) {
                                day = '{{__('genirale.Thursday')}}';
                            } else if ( response['days'][i]['day']==5) {
                                day =  '{{__('genirale.Friday')}}';
                            } else if ( response['days'][i]['day'] ==6) {
                                day ='{{__('genirale.Saturday')}}';
                            } else if (  response['days'][i]['day']==7) {
                                day = '{{__('genirale.Sunday')}}';
                            }
                            console.log("iiii")
                            html += '<div class="col-lg-4 col-xl-4 col-xxl-2 col-md-4 col-sm-12 col-12 project-grid">';
                            html += '<div class="project-grid-inner">';
                            html += '<div class="wrapper bg-light">';
                            html += '<h5 class="card-header header-sm bg-secondary">' +day  + '</h5>';
                            for (let j = 0; j < response['timetable'].length; j++) {
                                if (response['days'][i]['day'] == response['timetable'][j]['day']) {
                                    html += '<p class="timetable-body p-3">'
                                        // + response['timetable'][j]['subject_teacher']['subject']['name'] + ' - ' + response['timetable'][j]['subject_id']
                                        + response['timetable'][j]['subject_teacher']['subject']['name'] + ' - ' + response['timetable'][j]['subject_teacher']['subject']['type']
                                        + '<br>' + response['timetable'][j]['subject_teacher']['teacher']['first_name'] + ' ' + response['timetable'][j]['subject_teacher']['teacher']['last_name']
                                        + '<br>{{__('timetable.start_time')}}: ' + response['timetable'][j]['start_time'].slice(0, 5) + '<br>{{__('timetable.end_time')}}: '
                                        + response['timetable'][j]['end_time'].slice(0, 5) + '</p><hr>';

                                }
                            }
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            $('.set_timetable').html(html);
                        }
                    } else {
                        $('.warning_no_data').show(300);
                        $('.table_content').hide();
                    }
                }
            })
        });


    </script>
@endsection
