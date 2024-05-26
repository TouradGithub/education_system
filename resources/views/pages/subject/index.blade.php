@extends('layouts.masters.school-master')
@php
    $classes=App\Models\Classes::where('grade_id',getSchool()->grade_id)->get();
@endphp
@section('title')
{{ trans('main_trans.Grades') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ trans('genirale.manage') . ' '. __('subjects.Subjects') }}
            </h3>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="row">
            @can('school-subject-create')
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ trans('sidebar.Subjects') }}
                        </h4>
                        <form class="create-form pt-3" id="formdata" action="{{ route('school.subjects.store')}}" method="POST" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ trans('classes.classes') }}</label>
                                    <select name="class_id" id="class_section" class="form-control select2">
                                        <option value="">{{ __('genirale.select') . ' '. __('classes.class') }}
                                        </option>
                                        @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"> {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ trans('genirale.name') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('name', null, ['required', 'placeholder' => trans('genirale.name'), 'class' => ' form-control']) !!}
                                    <span class="input-group-addon input-group-append">
                                    </span>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ trans('subjects.code') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('code', null, ['required', 'placeholder' => trans('subjects.code'), 'class' => 'form-control']) !!}

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('genirale.image') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="file-upload-default"/>
                                    <div class="input-group col-xs-12">
                                        <input type="text" required class="form-control file-upload-info" name="image" disabled="" placeholder="{{ __('logo1') }}"/>
                                        <span class="input-group-append">
                                          <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                        </span>
                                        <div class="col-md-12">
                                            <img height="50px" src='{{ isset($settings['logo1']) ? url(Storage::url($settings['logo1'])) : '' }}'>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('subjects.type') }}</label>
                                    <select name="type" required class="form-control">
                                        <option value="T">{{__('subjects.Theory')}} </option>
                                        <option value="P">{{__('subjects.Practical')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ trans('genirale.note') }}</label>
                                    {!! Form::textarea('notes', null, ['rows' => '2', 'placeholder' => trans('genirale.note'), 'class' => 'form-control']) !!}

                                </div>
                            </div>
                            <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                    </div>
                </div>
            </div>
            @endcan
            @can('school-subject-index')
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('genirale.list') . ' ' . __('sidebar.Subjects') }}
                            </h4>
                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                        data-url="{{ url('subjects-list') }}" data-click-to-select="true"
                                        data-side-pagination="server" data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]"  data-search="true"
                                        data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                        data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1"
                                        data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                        data-sort-order="desc" data-maintain-selected="true"
                                        data-export-types='["txt","excel"]'

                                        data-query-params="queryParams">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                    {{ __('id') }}</th>

                                                <th scope="col" data-field="no" data-sortable="false">{{ __('genirale.no.') }}
                                                </th>
                                                <th scope="col" data-field="name" data-sortable="false"> {{trans('genirale.name')}}
                                                </th>
                                                <th scope="col" data-field="code" data-sortable="false"> {{trans('subjects.code')}}
                                                </th>
                                                <th scope="col" data-field="class_id" data-sortable="false"> {{trans('classes.class')}}
                                                </th>
                                                </th>
                                                <th scope="col" data-field="notes" data-sortable="false">
                                                  {{  trans('genirale.note')}}
                                                </th>

                                                {{-- @if (Auth::user()->can('holiday-edit') || Auth::user()->can('holiday-delete')) --}}
                                                    <th   data-events="actionEvents" data-width="150" scope="col" data-field="operate"
                                                        data-sortable="false">{{ __('genirale.action') }}</th>
                                                {{-- @endif --}}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
    </div>


    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('genirale.edit') . ' ' . __('subjects.subject') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class="editform" action="{{url('school/subjects')}}" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{trans('genirale.name')}} <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['required', 'placeholder' =>trans('genirale.name'), 'class' => ' form-control', 'id' => 'name']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{trans('subjects.code')}} <span class="text-danger">*</span></label>
                                {!! Form::text('code', null, ['required', 'placeholder' =>trans('subjects.code'), 'class' => ' form-control', 'id' => 'code']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                            <label>{{ __('subjects.type') }}</label>
                            <select name="type" required class="form-control">
                                <option value="T">{{__('subjects.Theory')}} </option>
                                <option value="P"> {{__('subjects.Practical')}}</option>
                            </select>
                        </div>
                    </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                            <label>{{ __('genirale.image') }} <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="file-upload-default"/>
                            <div class="input-group col-xs-12">
                                <input type="text" required class="form-control file-upload-info" name="image" disabled="" placeholder="{{ __('logo1') }}"/>
                                <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                </span>
                                <div class="col-md-12">
                                    <img height="50px" src='{{ isset($settings['logo1']) ? url(Storage::url($settings['logo1'])) : '' }}'>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{  trans('genirale.note')}}</label>
                                {!! Form::text('notes', null, ['placeholder' =>  trans('genirale.note'), 'class' => 'form-control', 'id' => 'notes']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('genirale.cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.actionEvents = {
            'click .editdata': function(e, value, row, index) {

                $('#id').val(row.id);
                $('#name').val(row.name);
                $('#code').val(row.code);
                $('#type').val(row.type);
                $('#notes').val(row.notes);

            }
        };
    </script>

    <script type="text/javascript">
        function queryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }
    </script>
@endsection
