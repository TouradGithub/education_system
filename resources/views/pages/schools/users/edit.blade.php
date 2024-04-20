@extends('layouts.masters.school-master')


@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{ trans('genirale.create_new_user') }}
        </h3>
    </div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<div class="row">
    {{-- @if (Auth::user()->can('holiday-create')) --}}
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ trans('grade.add_grade') }}
                </h4>
{!! Form::model($user, ['method' => 'POST','route' => ['school.user.update', $user->id]]) !!}

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>{{__('genirale.name')}}</strong>
            {!! Form::text('name', null, array('placeholder' => __('genirale.name'),'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>{{ __('genirale.email')}}</strong>
            {!! Form::text('email', null, array('placeholder' =>  __('genirale.email'),'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>{{ __('genirale.mobile')}}</strong>
            {!! Form::number('phone', null, array('placeholder' =>  __('genirale.mobile'),'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>{{__('genirale.role')}}</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>{{__('genirale.password')}}</strong>
            {!! Form::password('password', array('placeholder' => __('genirale.password'),'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong> {{__('genirale.confirm_password')}}</strong>
            {!! Form::password('confirm-password', array('placeholder' => __('genirale.confirm_password'),'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
    </div>
</div>
{!! Form::close() !!}
@endsection
