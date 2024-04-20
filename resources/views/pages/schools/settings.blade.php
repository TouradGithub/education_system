@extends('layouts.masters.school-master')

@section('title')
    {{ __('sidebar.general_settings') }}
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('sidebar.general_settings') }}
            </h3>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form id="frmData" class="general-setting" method="POST" action="{{ url('settings') }}" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('genirale.name') }}</label>
                                    <input name="school_name" value="{{ isset($settings['school_name']) ? $settings['school_name'] : '' }}" type="text" required placeholder="{{ __('school_name') }}" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('genirale.email') }}</label>
                                    <input name="school_email" value="{{ isset($settings['school_email']) ? $settings['school_email'] : '' }}" type="email" required placeholder="{{ __('school_email') }}" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('genirale.mobile') }}</label>
                                    <input name="school_phone" value="{{ isset($settings['school_phone']) ? $settings['school_phone'] : '' }}" type="text" required placeholder="{{ __('school_phone') }}" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('school_tagline') }}</label>
                                    <textarea name="school_tagline" required placeholder="{{ __('school_tagline') }}" class="form-control">{{ isset($settings['school_tagline']) ? $settings['school_tagline'] : '' }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('teacher.current_address') }}</label>
                                    <textarea name="school_address" required placeholder="{{ __('school_address') }}" class="form-control">{{ isset($settings['school_address']) ? $settings['school_address'] : '' }}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('favicon') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="favicon" class="file-upload-default"/>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('favicon') }}"/>
                                        <span class="input-group-append">
                                          <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                        </span>
                                        <div class="col-md-12">
                                            <img height="50px" src='{{ isset($settings['favicon']) ?url(Storage::url($settings['favicon'])) : '' }}'>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('horizontal_logo') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="logo1" class="file-upload-default"/>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('logo1') }}"/>
                                        <span class="input-group-append">
                                          <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                        </span>
                                        <div class="col-md-12">
                                            <img height="50px" src='{{ isset($settings['logo1']) ? url(Storage::url($settings['logo1'])) : '' }}'>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('vertical_logo') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="logo2" class="file-upload-default"/>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('logo2') }}"/>
                                        <span class="input-group-append">
                                          <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                        </span>
                                        <div class="col-md-12">
                                            <img height="50px" src='{{ isset($settings['logo2']) ?  url(Storage::url($settings['logo2'])) : '' }}'>
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
