@extends('layouts.masters.teacher-master')

@section('title')
    {{ __('sidebar.class_timetable') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.manage').' '.__('sidebar.timetable') }}
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                                <div class="row">


                                </div>

                                <div class="alert alert-warning text-center w-75 m-auto warning_no_data" role="alert">
                                    <strong>{{__('genirale.no_data_found')}}</strong>
                                </div>
                                <div class="row setDatateacherTimeTable"></div>



                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>



$(document).ready(function () {

            $('.setDatateacherTimeTable').html('');
            $.ajax({
                url: "{{ url('teacher/gettimetablebyclass') }}" ,
                type: "GET",
                data: {
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
                                        + '<br>' + response['timetable'][j]['section']['classe']['name'].fr+' - '+ response['timetable'][j]['section']['name'].fr
                                        + '<br> ' + response['timetable'][j]['start_time'].slice(0, 5) + '-- '+ response['timetable'][j]['end_time'].slice(0, 5) + '</p><hr>';

                                }
                            }
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            $('.setDatateacherTimeTable').html(html);
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
