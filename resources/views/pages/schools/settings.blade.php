@extends('layouts.masters.school-master')

@section('title')
    {{ __('sidebar.general_settings') }}
@endsection
@php
    $setting=getSchool()->setting;
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('sidebar.general_settings') }}
            </h3>
        </div>
      @can('school-general_settings-create')
      <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="frmData" class="general-setting" method="POST" action="{{ route('school.setting-update') }}" novalidate="novalidate" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('genirale.name') }}</label>
                                <input name="school_name" value="{{ $setting->school_name??'' }}" type="text"  placeholder="{{ __('school_name') }}" class="form-control"/>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('genirale.email') }}</label>
                                <input name="school_email" value="{{ $setting->school_email??'' }}" type="email"  placeholder="{{ __('school_email') }}" class="form-control"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('genirale.mobile') }}</label>
                                <input name="school_mobile" value="{{ $setting->school_mobile??'' }}" type="text"  placeholder="{{ __('school_phone') }}" class="form-control"/>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('teacher.current_address') }}</label>
                                <textarea name="school_address"  placeholder="{{ __('school_address') }}" class="form-control">{{ $setting->school_address??'' }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>{{ __('Description') }}</label>
                                <textarea name="school_description"  placeholder="{{ __('school_description') }}" class="form-control">{{ $setting->school_description??'' }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label>{{ __('Logo') }} <span class="text-danger">*</span></label>
                                <input type="file" name="logo" class="file-upload-default"/>
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('Logo') }}"/>
                                    <span class="input-group-append">
                                      <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                    </span>
                                    <div class="col-md-12">
                                        <img height="50px" src='{{ isset($setting->logo) ?url(Storage::url($setting->logo)) : '' }}'>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <input class="btn btn-theme" type="submit" value="{{__('genirale.submit')}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
      @endcan
    </div>
@endsection

@section('script')
    <script type='text/javascript'>
        if ($(".color-picker").length) {
            $('.color-picker').asColorPicker();
        }

        $("#frmData").validate({
            rules: {
                username: "required",
                password: "required",
            },
            errorPlacement: function (label, element) {
                label.addClass('mt-2 text-danger');
                label.insertAfter(element);
            },
            highlight: function (element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            }
        });
    </script>
@endsection
