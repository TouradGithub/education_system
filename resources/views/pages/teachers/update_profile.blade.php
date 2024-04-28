@extends('layouts.masters.school-master')

@section('title')
    {{ __('genirale.update_profile') }}
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.update_profile') }}
            </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" id="admin-profile-update" enctype="multipart/form-data"
                            action="
                            {{ route('school.update-profile') }}
                            " method="POST" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                {!! Form::hidden('id', "$admin_data->id", ['class' => 'form-control']) !!}

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('genirale.first_name') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('name', "$admin_data->name", [
                                        'placeholder' => __('genirale.first_name'),
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('genirale.mobile') }}</label>
                                    {!! Form::text('phone', "$admin_data->phone", ['placeholder' => __('genirale.mobile'), 'class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('genirale.image') }} </label>
                                    <input type="file" name="image" class="file-upload-default" />
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            placeholder="{{ __('genirale.image') }}" required="required" />
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-theme"
                                                type="button">{{ __('genirale.upload') }}</button>
                                        </span>
                                    </div>

                                </div>
                                {{-- {{Auth::user()->image}} --}}
                                @if (Auth::user()->image != "http://127.0.0.1:8000/storage")
                                <div class="nav-profile-img">
                                    <img style="width: 80px;height: 80px;border-radius: 20%" src="{{url(Auth::user()->image)}}" alt="image" onerror="onErrorImage(event)">
                               </div>

                                @endif

                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('genirale.email') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('email', "$admin_data->email", ['placeholder' => __('genirale.email'), 'class' => 'form-control']) !!}
                                </div>
                            </div>



                            <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
