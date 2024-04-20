@extends('layouts.masters.school-master')

@section('title')
    {{ __('teacher_timetable') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('list') . ' ' . __('teacher_timetable') }}
            </h3>
        </div>
        <div class="row">

            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            @can('timetable-create')
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('teacher') }} <span class="text-danger">*</span></label>
                                    <select required name="class_section_id" id="teacher_timetable_teacher_id" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach ($teacher as $teacher)
                                            <option value="{{ $teacher->id }}">
                                                {{ $teacher->first_name . ' ' . $teacher->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endcan
                        </h4>

                        <h4 class="card-title">
                            @cannot('timetable-create')
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('class') }} {{ __('section') }} <span class="text-danger">*</span></label>
                                    <select required name="class_section_id" id="teacher_timetable_class_section" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{__('select')}}</option>
                                        <option value="0">{{__('all')}} {{__('class')}}</option>
                                        @foreach($class_sections as $section)
                                            <option value="{{$section->id}}" data-class="{{$section->id}}" data-section="{{$section->id}}">{{$section->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endcannot
                        </h4>
                        <div class="alert alert-warning text-center w-75 m-auto warning_no_data" role="alert" style="display: none">
                            <strong>{{__('no_data_found')}}</strong>
                        </div>

                        <div class="row set_timetable"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
