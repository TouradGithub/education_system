@extends('layouts.masters.master')

@section('title')
    {{ __('manage').' '.__('role') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage').' '.__('role') }}
            </h3>
            <a class="btn btn-sm btn-theme" href="{{ route('managements.index') }}">{{ __('back') }}</a>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($management, ['method' => 'PATCH', 'route' => ['managements.update', $management->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label><strong> {{ __('name') }}:</strong></label>
                                    {!! Form::text('name', null, ['placeholder' => __('name'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label><strong>{{ __('email') }}:</strong></label>
                                    {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label><strong>{{ __('password') }}:</strong></label>
                                    {!! Form::text('password', null, ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-sm-12">
                                <label><span class="text-danger"></span></label>
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
                                <div class="form-inline col-md-4">
                                    <label></label> <span class="ml-1 text-danger"></span>
                                    <div class="ml-4 d-flex">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="status" class="online_payment_toggle" value="1" checked>
                                                {{ __('enable') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="status" class="online_payment_toggle" value="0">
                                                {{ __('disable') }}
                                            </label>
                                        </div>
                                    </div>
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
