@extends('layouts.masters.school-master')

@section('title')
    {{ __('manage').' '.__('role') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage').' '.__('role') }}
            </h3>
            <a class="btn btn-sm btn-theme" href="{{ route('roles.index') }}">{{ __('back') }}</a>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label><strong> {{ __('name') }}:</strong></label>
                                    {!! Form::text('name', null, ['placeholder' => __('name'), 'class' => 'form-control','readonly']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="form-group col-lg-3 col-sm-12 col-xs-12 col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name form-check-input']) }}
                                                    {{ $value->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-theme"> {{ __('submit') }}</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
