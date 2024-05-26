@extends('layouts.masters.master')

@section('title')
    {{ __('genirale.create_new_role') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('create_new_role') }}
            </h3>
            <a class="btn btn-primary" href="{{ route('web.roles.index') }}"> {{ __('back') }}</a>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {!! Form::open(['route' => 'web.roles.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{ __('name') }}:</strong></label>
                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{   trans('main_trans.guard_name') }} <span class="text-danger">*</span></label>
                                    <select name="guard_name" id="class_section" class="form-control select2">
                                        <option value="">{{ __('guard_name ') . ' '. __('main_trans.guard_name ') }}
                                        </option>

                                        <option value="web">    Admin</option>
                                        <option value="parent"> Parent</option>
                                        <option value="acadimy">Academy</option>
                                        <option value="school"> Schools</option>

                                    </select>

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <label><strong>Permission:</strong></label>
                                    <div class="row">
                                        @foreach ($permission as $value)
                                            <div class="form-group col-lg-3 col-sm-12 col-xs-12 col-md-3">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        {{ Form::checkbox('permission[]', $value->name, false, ['class' => 'name form-check-input']) }}
                                                        {{ $value->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ __('genirale.submit') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
