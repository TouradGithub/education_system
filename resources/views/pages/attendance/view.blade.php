@extends('layouts.master')

@section('title')
    {{ __('attendance') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage').' '.__('attendance') }}
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('view').' '.__('attendance') }}
                        </h4>
                        <div class="row" id="toolbar">
                            <div class="form-group col-sm-12 col-md-4">
                                {{-- <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label> --}}
                                <select required name="class_section_id" id="timetable_class_section" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{__('select')}}</option>
                                    @foreach($class_sections as $section)
                                        <option value="{{$section->id}}" data-class="{{$section->class->id}}">{{$section->class->name}} - {{$section->section->name}} {{$section->class->medium->name}} {{$section->class->streams->name ?? ''}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                {{-- <label>{{ __('date') }} <span class="text-danger">*</span></label> --}}
                                {!! Form::text('date', null, ['required', 'placeholder' => __('date'), 'class' => 'datepicker-popup form-control','id'=>'date','data-date-end-date'=>"0d"]) !!}
                                <span class="input-group-addon input-group-append">
                            </span>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <select required name="attendance_type" id="attendance_type" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{__('select')}}</option>
                                    <option value="1">{{__('present')}}</option>
                                    <option value="0">{{__('absent')}}</option>
                                    <option value="3">{{__('holiday')}}</option>

                                </select>
                            </div>
                        </div>

                        <div class="show_attendance_student_list">
                            <table aria-describedby="mydesc" class='table student_table' id='table_list'
                                   data-toggle="table" data-url="{{ url('student-attendance-list') }}" data-click-to-select="true"
                                   data-side-pagination="server" data-pagination="true"
                                   data-page-list="[5, 10, 20, 50, 100, 200,All]" data-search="true" data-toolbar="#toolbar"
                                   data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                                   data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                   data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                   data-maintain-selected="true" data-export-types='["txt","excel"]' data-show-export="true"
                                   data-export-options='{ "fileName": "view-attendance-list-<?= date('d-m-y') ?>" ,"ignoreColumn": ["operate"]}'
                                   data-query-params="queryParams">
                                <thead>
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{__('id')}}</th>
                                    <th scope="col" data-field="no" data-sortable="false">{{__('no.')}}</th>
                                    <th scope="col" data-field="user_id" data-sortable="true" data-visible="false">{{__('user_id')}}</th>
                                    <th scope="col" data-field="student_id" data-sortable="true" data-visible="false">{{__('student_id')}}</th>
                                    <th scope="col" data-field="admission_no" data-sortable="true">{{__('admission_no')}}</th>
                                    <th scope="col" data-field="roll_no" data-sortable="true">{{__('roll_no')}}</th>
                                    <th scope="col" data-field="name" data-sortable="false">{{__('name')}}</th>
                                    <th scope="col" data-field="type" data-sortable="false">{{__('type')}}</th>
                                    {{-- <th scope="col" data-field="note" data-sortable="false">{{__('note')}}</th> --}}
                                </tr>
                                </thead>
                            </table>
                        </div>
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
                'class_section_id': $('#timetable_class_section').val(),
                'date': $('#date').val(),
                'attendance_type': $('#attendance_type').val(),
            };
        }
    </script>

    <script>
        $('#date,#attendance_type').on('input change', function () {
            $('.student_table').bootstrapTable('refresh');
        });
    </script>
@endsection
