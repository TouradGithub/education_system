@extends('layouts.masters.master')
@php
   $grades= App\Models\Grade::all();
@endphp
@section('title')
{{ trans('main_trans.schools') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ trans('sidebar.schools') }}
            </h3>
        </div>

        <div class="row">
            @if (Auth::user()->can('school-create'))
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ trans('genirale.add_schools') }}
                        </h4>
                        <form class="create-form pt-3" id="formdata" action="{{ route('web.schools.store')}}" method="POST" novalidate="novalidate">
                            @csrf

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{ __('genirale.name') }}:</strong></label>
                                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{ __('genirale.email') }}:</strong></label>
                                            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{ __('genirale.password') }}:</strong></label>
                                            {!! Form::text('password', null, ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><strong>{{ __('genirale.mobile') }}:</strong></label>
                                            {!! Form::text('phone', null, ['placeholder' => 'phone', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>{{__('genirale.role')}}:</strong>
                                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{   trans('section.grade') }} <span class="text-danger">*</span></label>
                                        <select name="grade_id" id="class_section" class="form-control select2">
                                            <option value="">{{ __('genirale.select') }}
                                            </option>
                                            @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('subjects.type') }} <span class="text-danger">*</span></label>
                                        <select name="type" id="class_section" class="form-control select2">
                                            <option value="">{{ __('genirale.select') . ' ' . __('subjects.type')  }}
                                            </option>
                                            <option value="public">Public</option>
                                            <option value="private">Private</option>

                                        </select>

                                    </div>
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label>{{   trans('sidebar.acadimic') }} <span class="text-danger">*</span></label>
                                        <select name="academy_id" id="class_section" class="form-control select2">
                                            <option value="">{{ __('genirale.select')  }}
                                            </option>
                                            @foreach ($acadimy as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="row"></div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label>{{ __('genirale.image') }} <span class="text-danger">*</span></label>
                                        <input type="file" name="logo1" class="file-upload-default"/>
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" name="image" disabled="" placeholder="{{ __('logo1') }}"/>
                                            <span class="input-group-append">
                                              <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                            </span>
                                            <div class="col-md-12">
                                                <img height="50px" src='{{ isset($settings['logo1']) ? url(Storage::url($settings['logo1'])) : '' }}'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{ __('genirale.description') }}:</strong></label>
                                            {!! Form::text('description', null, ['placeholder' => 'Description', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{ __('teacher.permanent_address') }}:</strong></label>
                                            {!! Form::text('adress', null, ['placeholder' => 'adress', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary">{{ __('genirale.submit') }}</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->can('school-list'))
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('list') . ' ' . __('holiday') }}
                            </h4>
                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                        data-url="{{ url('schools-list') }}" data-click-to-select="true"
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
            @endif
        </div>
    </div>


    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('edit') . ' ' . __('holiday') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class="editform" action="{{url('schools')}}" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{trans('schools_trans.stage_name_ar')}} <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['required', 'placeholder' =>trans('schools_trans.stage_name_ar'), 'class' => ' form-control', 'id' => 'name']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{trans('schools_trans.stage_name_en')}} <span class="text-danger">*</span></label>
                                {!! Form::text('name_en', null, ['required', 'placeholder' =>trans('schools_trans.stage_name_en'), 'class' => 'form-control', 'id' => 'name_en']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{  trans('schools_trans.Notes')}}</label>
                                {!! Form::text('notes', null, ['placeholder' =>  trans('schools_trans.Notes'), 'class' => 'form-control', 'id' => 'notes']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('cancel') }}</button>
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
                $('#name_en').val(row.name_en);
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
