@extends('layouts.masters.master')
@section('title')
    {{__('sidebar.dashboard')}}
@endsection
@section('content')
@php
$schools=App\Models\Schools::limit(5)->get();
@endphp
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-theme text-white mr-2">
                <i class="fa fa-home"></i>
            </span> {{__('dashboard')}}
            </h3>
        </div>
        <div class="row">
            {{-- @if($teacher) --}}
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                            <h4 class="font-weight-normal mb-3">{{__('genirale.total_schools')}}<i class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">
                            {{App\Models\Schools::count()}}
                        </h2>
                        </div>
                    </div>
                </div>
            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                        <h4 class="font-weight-normal mb-3">{{__('genirale.total_acadimic')}}<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">
                            {{App\Models\Acadimy::count()}}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                        <h4 class="font-weight-normal mb-3">{{__('genirale.total_students')}}<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">
                            {{App\Models\Student::count()}}
                        </h2>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
            {{-- @if($parent) --}}
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image"/>
                            <h4 class="font-weight-normal mb-3">{{__('genirale.total_parents')}}<i class="mdi mdi-diamond mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">
                                {{App\Models\MyParent::count()}}
                            </h2>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
        </div>
        <div class="row">
            @if(isset($schools) && !empty($schools))
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body v-scroll">
                            <h4 class="card-title">{{__('teacher.teacher')}}</h4>
                            @foreach($schools as $row)
                            <div class="wrapper d-flex align-items-center py-2 border-bottom">
                                <img class="img-sm rounded-circle" src="{{$row->name}}" alt="profile" onerror="onErrorImage(event)">
                                <div class="wrapper ml-3">
                                    <h6 class="ml-1 mb-1">
                                        {{$row->name}}
                                    </h6>
                                    <small class="text-muted mb-0">
                                        <i class="mdi mdi-map-marker-outline mr-1"></i>
                                        {{$row->description}}
                                    </small>
                                </div>

                                <div class="wrapper ml-3">
                                    <h6 class="ml-1 mb-1">
                                        {{$row->academy->name}}
                                    </h6>

                                </div>
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
        {{-- @canany(['class-teacher'])
            <div class="row classes">
                @if($class_sections)
                <div class="col-md-12 grid-margin stretch-card search-container">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{__('Class Teachers')}}</h4>
                            <div class="d-flex flex-wrap">
                                @php
                                $colors = ['bg-gradient-danger', 'bg-gradient-success', 'bg-gradient-primary', 'bg-gradient-info', 'bg-gradient-secondary','bg-gradient-warning'];
                                $colorIndex = 0;
                                @endphp

                                @foreach($class_sections as $class_section)
                                    @php
                                        $currentColor = $colors[$colorIndex];
                                        $colorIndex = ($colorIndex + 1) % count($colors);
                                    @endphp

                                    <div class="col-md-2 stretch-card grid-margin">
                                        <div class="card {{$currentColor}} card-img-holder text-white">
                                            <div class="card-body">
                                                <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image" />
                                                <h6 class="mb-2">
                                                    <h4>{{$class_section->class->name}}-{{$class_section->section->name}} {{$class_section->class->medium->name}} {{$class_section->class->streams->name ?? ''}}</h4>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endcanany --}}

        {{-- {{-- @if($announcement) --}}
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
                                        <th> {{__('date')}}</th>
                                        <th> {{__('Show')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=0;
                                            $notif=DB::table('notifications')->get();
                                        @endphp
                                        @forelse ($notif  as $item)
                                            <tr>
                                                <td>{{ ++$i}}</td>
                                                <td>{{ json_decode($item->data)->title }}</td>
                                                <td>{{ json_decode($item->data)->type }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td><a href="{{route('web.announcement.show',$item->id)}}"><i class="fa fa-eye"></a></td>
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
        {{-- @endif --}}
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

                                data: [55, 45],
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
                                'Guarson',
                                'filles',
                                // "{{__('boys')}}",
                                // "{{__('girls')}}"
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
