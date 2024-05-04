@extends('layouts.masters.school-master')

@section('title')
    {{ __('teacher.teacher') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('teacher.manage_teacher') }}
            </h3>
        </div>

        <div class="row">
            @can('school-teachers-create')
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('teacher.create_teacher') }}
                            </h4>
                            <form class="create-form pt-3" id="formdata" action="{{ url('school/teachers') }}"
                                enctype="multipart/form-data" method="POST" novalidate="novalidate">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('genirale.first_name') }} <span class="text-danger">*</span></label>
                                        {!! Form::text('first_name', null, ['required', 'placeholder' => __('genirale.first_name'), 'class' => 'form-control']) !!}

                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('genirale.last_name') }} <span class="text-danger">*</span></label>
                                        {!! Form::text('last_name', null, ['required', 'placeholder' => __('genirale.last_name'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('genirale.gender') }} <span class="text-danger">*</span></label><br>
                                        <div class="d-flex">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    {!! Form::radio('gender', 'male') !!}
                                                    {{ __('genirale.male') }}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    {!! Form::radio('gender', 'female') !!}
                                                    {{ __('genirale.female') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('genirale.email') }} <span class="text-danger">*</span></label>
                                        {!! Form::text('email', null, ['required', 'placeholder' => __('genirale.email'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('genirale.mobile') }} <span class="text-danger">*</span></label>
                                        {!! Form::number('mobile', null, ['required', 'placeholder' => __('genirale.mobile'),'min' => 1 , 'class' => 'form-control']) !!}

                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">

                                        <label>{{ __('genirale.image') }}</label>
                                        <input type="file" name="image" class="file-upload-default" accept="image/png,image/jpeg,image/jpg" />
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled=""
                                                placeholder="{{ __('image') }}" />
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-theme"
                                                    type="button">{{ __('genirale.upload') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('teacher.dob') }} <span class="text-danger">*</span></label>
                                        {!! Form::text('dob', null, ['required', 'placeholder' => __('teacher.dob'), 'class' => 'datepicker-popup-no-future form-control']) !!}
                                        <span class="input-group-addon input-group-append">
                                        </span>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('teacher.qualification') }} <span class="text-danger">*</span></label>
                                        {!! Form::textarea('qualification', null, ['required', 'placeholder' => __('teacher.qualification'), 'class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('teacher.current_address') }} <span class="text-danger">*</span></label>
                                        {!! Form::textarea('current_address', null, ['required', 'placeholder' => __('teacher.current_address'), 'class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label>{{ __('teacher.permanent_address') }} <span class="text-danger">*</span></label>
                                        {!! Form::textarea('permanent_address', null, ['required', 'placeholder' => __('teacher.permanent_address'), 'class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>

                                <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
            @can('school-teachers-index')
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('teacher.list_teacher') }}
                        </h4>

                        <div class="row">
                            <div class="col-12">
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ url('school/teacher_list') }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                    data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                                    data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                    data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                    data-maintain-selected="true" data-export-types='["txt","excel"]'
                                    data-export-options='{ "fileName": "teacher-list-<?= date('d-m-y') ?>" ,"ignoreColumn":
                                    ["operate"]}'
                                    data-query-params="teacherQueryParams">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                {{ __('id') }}</th>
                                            <th scope="col" data-field="no" data-sortable="false">{{ __('genirale.no.') }}
                                            </th>

                                            <th scope="col" data-field="first_name" data-sortable="false">
                                                {{ __('genirale.first_name') }}</th>
                                            <th scope="col" data-field="last_name" data-sortable="false">
                                                {{ __('genirale.last_name') }}</th>
                                            <th scope="col" data-field="gender" data-sortable="false">
                                                {{ __('genirale.gender') }}</th>
                                            <th scope="col" data-field="email" data-sortable="false">
                                                {{ __('genirale.email') }}</th>
                                            <th scope="col" data-field="dob" data-sortable="false">
                                                {{ __('teacher.dob') }}</th>
                                            <th scope="col" data-field="image"
                                                data-sortable="false"data-formatter="imageFormatter">{{ __('genirale.image') }}
                                            </th>
                                            <th scope="col" data-field="qualification" data-sortable="false">
                                                {{ __('teacher.qualification') }}</th>
                                            <th scope="col" data-field="current_address" data-sortable="false">
                                                {{ __('teacher.current_address') }}</th>
                                            <th scope="col" data-field="permanent_address" data-sortable="false">
                                                {{ __('teacher.permanent_address') }}</th>
                                            <th data-events="teacherActionEvents" scope="col" data-field="operate"
                                                data-sortable="false">{{ __('genirale.action') }}</th>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('teacher.edit_teacher') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="editdata" class="editform " action="{{ url('school/teachers') }}" novalidate="novalidate"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="id" id="id">
                        <div class="row form-group">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.first_name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('first_name', null, ['required', 'placeholder' => __('genirale.first_name'), 'class' => 'form-control', 'id' => 'first_name']) !!}

                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.last_name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('last_name', null, ['required', 'placeholder' => __('genirale.last_name'), 'class' => 'form-control', 'id' => 'last_name']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.gender') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            {!! Form::radio('gender', 'male', null, ['class' => 'form-check-input edit', 'id' => 'gender']) !!}
                                            {{ __('genirale.male') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            {!! Form::radio('gender', 'female', null, ['class' => 'form-check-input edit', 'id' => 'gender']) !!}
                                            {{ __('genirale.female') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.email') }} <span class="text-danger">*</span></label>
                                {!! Form::text('email', null, ['required', 'placeholder' => __('genirale.email'), 'class' => 'form-control', 'id' => 'email' ,'readonly' => true]) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.mobile') }} <span class="text-danger">*</span></label>
                                {!! Form::number('mobile', null, ['required', 'min' => 1 , 'placeholder' => __('genirale.mobile'), 'class' => 'form-control', 'id' => 'mobile']) !!}

                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.image') }}</label><br>
                                {{-- <input type="file" name="image" id="edit_image" class="form-control" placeholder="{{__('image')}}"> --}}
                                <input type="file" name="image" class="file-upload-default" accept="image/png,image/jpeg,image/jpg" />
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="{{ __('genirale.image') }}" />
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme"
                                            type="button">{{ __('genirale.upload') }}</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('teacher.dob') }} <span class="text-danger">*</span></label>
                                {!! Form::text('dob', null, ['required', 'placeholder' => __('teacher.dob'), 'class' => 'datepicker-popup-no-future form-control', 'id' => 'dob']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('teacher.qualification') }} <span class="text-danger">*</span></label>
                                {!! Form::textarea('qualification', null, ['required', 'placeholder' => __('teacher.qualification'), 'class' => 'form-control', 'rows' => 3, 'id' => 'qualification']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('teacher.current_address') }} <span class="text-danger">*</span></label>
                                {!! Form::textarea('current_address', null, ['required', 'placeholder' => __('teacher.current_address'), 'class' => 'form-control', 'rows' => 3, 'id' => 'current_address']) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('teacher.permanent_address') }} <span class="text-danger">*</span></label>
                                {!! Form::textarea('permanent_address', null, ['required', 'placeholder' => __('teacher.permanent_address'), 'class' => 'form-control', 'rows' => 3, 'id' => 'permanent_address']) !!}
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
