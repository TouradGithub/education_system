@extends('layouts.masters.master')

@section('title')
    {{ __('general_settings') }}
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('general_settings') }}
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
                                    <label>{{ __('school_name') }}</label>
                                    <input name="school_name" value="{{ isset($settings['school_name']) ? $settings['school_name'] : '' }}" type="text" required placeholder="{{ __('school_name') }}" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('school_email') }}</label>
                                    <input name="school_email" value="{{ isset($settings['school_email']) ? $settings['school_email'] : '' }}" type="email" required placeholder="{{ __('school_email') }}" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('school_phone') }}</label>
                                    <input name="school_phone" value="{{ isset($settings['school_phone']) ? $settings['school_phone'] : '' }}" type="text" required placeholder="{{ __('school_phone') }}" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('school_tagline') }}</label>
                                    <textarea name="school_tagline" required placeholder="{{ __('school_tagline') }}" class="form-control">{{ isset($settings['school_tagline']) ? $settings['school_tagline'] : '' }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{ __('school_address') }}</label>
                                    <textarea name="school_address" required placeholder="{{ __('school_address') }}" class="form-control">{{ isset($settings['school_address']) ? $settings['school_address'] : '' }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('time_zone') }}</label>
                                    <select name="time_zone" required class="form-control" style="width:100%">
                                        @foreach ($getTimezoneList as $timezone)
                                            <option value="@php  echo $timezone[2]; @endphp"
                                                {{ isset($settings['time_zone']) ? ($settings['time_zone'] == $timezone[2] ? 'selected' : '') : '' }}>
                                                @php  echo $timezone[2] .' - GMT ' . $timezone[1] .' - '.$timezone[0] @endphp</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('date_formate') }}</label>
                                    <select name="date_formate" required class="form-control">
                                        @foreach ($getDateFormat as $key => $dateformate)
                                            <option value="{{ $key }}"{{ isset($settings['date_formate']) ? ($settings['date_formate'] == $key ? 'selected' : '') : '' }}>{{ $dateformate }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('time_formate') }}</label>
                                    <select name="time_formate" required class="form-control">
                                        @foreach ($getTimeFormat as $key => $timeformate)
                                            <option value="{{ $key }}"{{ isset($settings['time_formate']) ? ($settings['time_formate'] == $key ? 'selected' : '') : '' }}>{{ $timeformate }}</option>
                                        @endforeach
                                    </select>
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
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('color') }}</label>
                                    <input name="theme_color" value="{{ isset($settings['theme_color']) ? $settings['theme_color'] : '' }}" type="text" required placeholder="{{ __('color') }}" class="color-picker"/>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('session_years') }}</label>
                                    <select name="session_year" required class="form-control">
                                        @foreach ($session_year as $key => $year)
                                            <option value="{{ $year->id }}"{{ isset($settings['session_year']) ? ($settings['session_year'] == $year->id ? 'selected' : '') : '' }}>{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- online payment mode setting --}}
                                @if(isset($settings['online_payment']))
                                    @if($settings['online_payment'])
                                        <div class="form-inline col-md-4">
                                            <label>{{__('online_payment_mode') }}</label> <span class="ml-1 text-danger">*</span>
                                            <div class="ml-4 d-flex">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="online_payment" class="online_payment_toggle" value="1" checked>
                                                        {{ __('Activer') }}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="online_payment" class="online_payment_toggle" value="0">
                                                        {{ __('Desactiver') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-inline col-md-4">
                                            <label>{{__('online_payment_mode') }}</label> <span class="ml-1 text-danger">*</span>
                                            <div class="ml-4 d-flex">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="online_payment" class="online_payment_toggle" value="1">
                                                        {{ __('Activer') }}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="online_payment" class="online_payment_toggle" value="0" checked>
                                                        {{ __('Desactiver') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="form-inline col-md-4">
                                        <label>{{__('online_payment_mode') }}</label> <span class="ml-1 text-danger">*</span>
                                        <div class="ml-4 d-flex">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="online_payment" class="online_payment_toggle" value="1" checked>
                                                    {{ __('enable') }}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="online_payment" class="online_payment_toggle" value="0">
                                                    {{ __('disable') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- end of online payment mode setting --}}

                            </div>
                            <input class="btn btn-theme" type="submit" value="Submit">
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
