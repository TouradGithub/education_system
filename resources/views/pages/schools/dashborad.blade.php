@extends('layouts.masters.school-master')
@section('title')
    {{__('sidebar.dashboard')}}
@endsection
@section('content')
@php
    use App\Models\Student;
    $student = Student::where('school_id',getSchool()->id,)->count();
    $teachers =  App\Models\Teacher::where('school_id',getSchool()->id,)->get();
    $boys_count = Student::where(['school_id'=>getSchool()->id,'gender'=>"male"])->count();

    $girls_count = App\Models\Student::where(['school_id'=>getSchool()->id,'gender'=>"female"])->count();
    $boys = round((($boys_count * 100) / $student), 2);
    $girls = round((($girls_count * 100) / $student), 2);
@endphp
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-theme text-white mr-2">
                <i class="fa fa-home"></i>

            </span>
            {{__('sidebar.dashboard')}}
            </h3>
        </div>
        <div class="row">
            {{-- @if($teacher) --}}
                <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                            <h4 class="font-weight-normal mb-3">{{__('genirale.total_teachers')}}<i class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5"
                            >
                            {{-- {{$teacher}} --}}
                            {{App\Models\Teacher::where('school_id',getSchool()->id)->count()}}
                        </h2>
                            {{-- <h6 class="card-text">Increased by 60%</h6> --}}
                        </div>
                    </div>
                </div>
            {{-- @endif --}}

            {{-- @if($student) --}}
                <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-info card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                            <h4 class="font-weight-normal mb-3">{{__('genirale.total_students')}}<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">
                            {{App\Models\Student::where('school_id',getSchool()->id)->count()}}
                            </h2>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
            {{-- @if($parent) --}}
                <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                            <h4 class="font-weight-normal mb-3">{{__('genirale.total_parents')}}<i class="mdi mdi-diamond mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">
                                {{-- {{$parent}} --}}

                            {{App\Models\MyParent::where('school_id',getSchool()->id)->count()}}
                                {{-- {{getSchool()}} --}}
                            </h2>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
        </div>
        <div class="row">
            @if(isset($teachers) && !empty($teachers))
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body v-scroll">
                            <h4 class="card-title">{{__('teacher.teacher')}}</h4>
                            @foreach($teachers as $row)
                            <div class="wrapper d-flex align-items-center py-2 border-bottom">
                                <img class="img-sm rounded-circle" src="{{Storage::url($row->image)}}" alt="profile" onerror="onErrorImage(event)">
                                <div class="wrapper ml-3">
                                    <h6 class="ml-1 mb-1">
                                        {{$row->first_name.' '.$row->last_name}}
                                    </h6>
                                    <small class="text-muted mb-0">
                                        <i class="mdi mdi-map-marker-outline mr-1"></i>
                                        {{$row->qualification}}
                                    </small>
                                </div>
                                @foreach ($row->sectionTeachers as $item)


                                <div class="wrapper ml-3">
                                    <h6 class="ml-1 mb-1">
                                        {{$item->section->name.' - '.$item->section->classe->name.' - '.$item->subject->name}}
                                    </h6>
                                </div>
                                @endforeach
                                <div class="badge badge-pill badge-success ml-auto px-1 py-1">
                                    <i class="mdi mdi-check"></i>
                                </div>
                            </div>
                         @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- @if($boys || $girls)--}}
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{__('gender')}}</h4>
                            <canvas id="gender-ratio-chart"></canvas>
                            <div id="gender-ratio-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
        </div>
        {{-- @canany(['class-teacher']) --}}

        {{-- @endcanany  --}}

        @if(Auth::user()->notifications)
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card search-container">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{__('noticeboard')}}</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th> {{__('genirale.no.')}}</th>
                                        <th> {{__('title')}}</th>
                                        <th> {{__('Type')}}</th>
                                        <th> {{__('genirale.date')}}</th>
                                        <th> {{__('Show')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=0;
                                        @endphp
                                      @forelse (Auth::user()->notifications as $notification)
                                      <tr>
                                          <td>{{ ++$i }}</td>
                                          <td>{{ $notification->data['title'] }}</td>
                                          <td>{!! $notification->data['type'] !!}</td>
                                          <td>{{ $notification->created_at }}</td>
                                          <td><a href="{{ route('school.get-notification', $notification->id) }}"><i class="fa fa-eye"></i></a></td>
                                      </tr>
                                  @empty
                                            <tr>
                                                <td>No data</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- @if ($class)

        @endif --}}
    </div>
@endsection
@section('script')
    {{-- @if($boys || $girls)--}}
        <script>
            (function ($) {
                'use strict';
                $(function () {
                    Chart.defaults.global.legend.labels.usePointStyle = true;
                    if ($("#gender-ratio-chart").length) {
                        let ctx = document.getElementById('gender-ratio-chart').getContext("2d")
                        let gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
                        gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
                        gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
                        let gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

                        let gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
                        gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
                        gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
                        let gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

                        let trafficChartData = {
                            datasets: [{

                                data: [{{$boys}}, {{$girls}}],
                                backgroundColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed
                                ],
                                hoverBackgroundColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed
                                ],
                                borderColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed
                                ],
                                legendColor: [
                                    gradientLegendBlue,
                                    gradientLegendRed
                                ]
                            }],

                            // These labels appear in the legend and in the tooltips when hovering different arcs
                            labels: [
                                '{{__('genirale.Boys')}}',
                                '{{__('genirale.Girls')}}',
                                "{{__('boys')}}",
                                "{{__('girls')}}"
                            ]
                        };
                        let trafficChartOptions = {
                            responsive: true,
                            animation: {
                                animateScale: true,
                                animateRotate: true
                            },
                            legend: false,
                            legendCallback: function (chart) {
                                let text = [];
                                text.push('<ul>');
                                for (let i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                                    text.push('<li><span class="legend-dots" style="background:' + trafficChartData.datasets[0].legendColor[i] + '"></span>');
                                    if (trafficChartData.labels[i]) {
                                        text.push(trafficChartData.labels[i]);
                                    }
                                    text.push('<span class="float-right">' + trafficChartData.datasets[0].data[i] + "%" + '</span>')
                                    text.push('</li>');
                                }
                                text.push('</ul>');
                                return text.join('');
                            }
                        };
                        let trafficChartCanvas = $("#gender-ratio-chart").get(0).getContext("2d");
                        let trafficChart = new Chart(trafficChartCanvas, {
                            type: 'doughnut',
                            data: trafficChartData,
                            options: trafficChartOptions
                        });
                        $("#gender-ratio-chart-legend").html(trafficChart.generateLegend());
                    }
                    if ($("#inline-datepicker").length) {
                        $('#inline-datepicker').datepicker({
                            enableOnReadonly: true,
                            todayHighlight: true,
                        });
                    }
                });
            })(jQuery);
        </script>
    {{-- @endif --}}

@endsection
