@extends('layouts.masters.teacher-master')
@section('title')
    {{__('sidebar.dashboard')}}
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-theme text-white mr-2">
                <i class="fa fa-home"></i>
            </span> {{__('sidebar.dashboard')}}
            </h3>
        </div>
        <div class="row">
            {{-- @if($teacher) --}}
                <div class="col-md-6 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{asset('images/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                            <h4 class="font-weight-normal mb-3">{{__('genirale.numberofSections')}}<i class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5"
                            >
                            {{auth('teacher')->user()->sectionTeachers->count()}}
                        </h2>
                            <h6 class="card-text"></h6>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}

            {{-- <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                          {{__('teacher.teacher')}}
                        </h4>
                        <div class="row">
                            <div class="col-12">

                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table" data-url="{{ url('teacher/teacher-get-list') }}" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true" data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{ "fileName": "session-year-list-<?= date(' d-m-y') ?>
                        ","ignoreColumn": ["operate"]}'
                        data-query-params="studentQueryParams">
                        <thead>
                            <tr>


                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                    {{ __('id') }}</th>

                                <th scope="col" data-field="first_name" data-sortable="true" >
                                        {{ __('genirale.first_name') }}</th>

                                <th scope="col" data-field="last_name" data-sortable="true" >
                                            {{ __('genirale.last_name') }}</th>

                                <th scope="col" data-field="gender" data-sortable="false">{{ __('genirale.gender') }}
                                </th>

                                <th scope="col" data-field="operate" data-sortable="false">{{ __('genirale.action') }}
                                </th>


                            </tr>
                        </thead>

                    </table>
                    </div>
                        </div>
                    </div>

            </div> --}}

            </div>
        </div>
        <div class="row classes">
            {{-- @if($class_sections) --}}
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('Class Teachers')}}</h4>
                        <div class="d-flex flex-wrap">
                            @php
                            $colors = ['bg-gradient-danger', 'bg-gradient-success', 'bg-gradient-primary', 'bg-gradient-info', 'bg-gradient-secondary','bg-gradient-warning'];
                            $colorIndex = 0;
                            @endphp

                            @foreach(Auth::guard('teacher')->user()->sectionTeachers as $item)
                                @php
                                    $currentColor = $colors[$colorIndex];
                                    $colorIndex = ($colorIndex + 1) % count($colors);
                                @endphp

                                <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card {{$currentColor}} card-img-holder text-white">
                                        <div class="card-body">
                                            <img src="{{asset(config('global.CIRCLE_SVG')) }}" class="card-img-absolute" alt="circle-image" />
                                            <h6 class="mb-2">
                                                <h4>{{$item->section->classe->name.'-'.$item->section->name}}</h4>
                                            </h6>
                                            <h4 class="mb-5"
                                            >
                                            {{-- {{$teacher}} --}}
                                            {{$item->subject->name}}
                                        </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
        </div>
    </div>


@endsection
@section('script')
<script type="text/javascript">
    function studentQueryParams(p) {
        return {
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search,
        };
    }
</script>
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
