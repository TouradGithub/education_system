@extends('layouts.masters.school-master')

@section('title')
Student Id Card settings
@endsection
@php
    $setting=getSchool()->setting;
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                Student Id Card settings
            </h3>
        </div>
      @can('school-general_settings-update')
      <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="pt-3 id-card-setting" id="id-card-setting" enctype="multipart/form-data" action="{{route('school.student-id-card-setting-update')}}" method="POST" novalidate="novalidate">
                        <div class="row">
                            @csrf

                            <div class="form-group col-md-6 col-sm-12">
                                <label>Country Text</label>
                                <textarea name="country_text"  placeholder="Country Text" class="form-control">{{isset(settingIdCard()->country_text)?settingIdCard()->country_text:''}}</textarea>
                            </div>


                            <div class="form-group col-sm-12 col-md-6">
                                <label for="header_color">Header Colour <span class="text-danger">*</span></label>
                                <input name="header_color"  value="{{isset(settingIdCard()->header_color)?settingIdCard()->header_color:''}}" id="header_color" value="#22577a" type="text" required placeholder="Color" class="color-picker"/>
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label for="header_footer_color">Header  Text Colour <span class="text-danger">*</span></label>
                                <input name="header_text_color" value="{{isset(settingIdCard()->header_text_color)?settingIdCard()->header_text_color:''}}" id="header_text_color" value="#ffffff" type="text" required placeholder="Color" class="color-picker"/>
                            </div>



                            <div class="form-group col-sm-12 col-md-6">
                                <label for="image">Background Image </label>
                                <input type="file" name="background_image" class="file-upload-default" accept="image/png,image/jpeg,image/jpg" />
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="{{ __('image') }}" />
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme"
                                            type="button">{{ __('genirale.upload') }}</button>
                                    </span>

                                </div>
                                @if (isset(settingIdCard()->background_image))
                                <div class="mt-3">
                                    <img src="{{ url(Storage::url('idcardsetting/'.settingIdCard()->background_image)) }}" alt="Country Image" class="img-fluid" style="max-height: 70px;">
                                </div>
                                @endif
                            </div>



                            <div class="form-group col-sm-12 col-md-6">
                                <label for="image">Signature </label>
                                <input type="file" name="signature" class="file-upload-default" accept="image/png,image/jpeg,image/jpg" />
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled=""
                                        placeholder="{{ __('image') }}" />
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme"
                                            type="button">{{ __('genirale.upload') }}</button>
                                    </span>

                                </div>
                                @if (isset(settingIdCard()->signature))
                                <div class="mt-3">
                                    <img src="{{ url(Storage::url('idcardsetting/'.settingIdCard()->signature)) }}" alt="Country Image" class="img-fluid" style="max-height: 70px;">
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="image">country_image </label>
                                <input type="file" name="country_image" class="file-upload-default" accept="image/png,image/jpeg,image/jpg" />
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled=""
                                                placeholder="{{ __('image') }}" />
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-theme"
                                                    type="button">{{ __('genirale.upload') }}</button>
                                            </span>
                                        </div>
                                        @if (isset(settingIdCard()->country_image))
                                        <div class="mt-3">
                                            <img src="{{ url(Storage::url('idcardsetting/'.settingIdCard()->country_image)) }}" alt="Country Image" class="img-fluid" style="max-height: 70px;">
                                        </div>
                                        @endif
                            </div>




                            <div class="form-group col-sm-12 col-md-3">
                                <label>Layout Type <span class="text-danger">*</span></label>
                                <div class="col-12 d-flex row">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" {{isset(settingIdCard()->layout_type)&& settingIdCard()->layout_type=="vertical" ?"checked":''}} class="form-check-input"    name="layout_type" id="layout_type" value="vertical" required>
                                            Vertical
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" {{isset(settingIdCard()->layout_type)&& settingIdCard()->layout_type=="horizontal" ?"checked":''}} class="form-check-input"  name="layout_type" id="layout_type" value="horizontal" required>
                                            Horizontal
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group col-sm-12 col-md-3">
                                <label>Profile Image Style <span class="text-danger">*</span></label>
                                <div class="col-12 d-flex row">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"  {{isset(settingIdCard()->profile_image_style)&& settingIdCard()->profile_image_style=="round" ?"checked":''}}    name="profile_image_style" id="profile_image_style" value="round" required>
                                            Round
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" {{isset(settingIdCard()->profile_image_style)&& settingIdCard()->profile_image_style=="squre" ?"checked":''}}  name="profile_image_style" id="profile_image_style" value="squre" required>
                                            Square
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group col-sm-12 col-md-3">
                                <label for="">Card Width (MM)<span class="text-danger">*</span></label>
                                <input name="card_width" value="{{isset(settingIdCard()->card_width) ?settingIdCard()->card_width:''}}"    id="card_width" value="110" type="number" required placeholder="Card Width" class="form-control"/>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label for="">Card Height (MM)<span class="text-danger">*</span></label>
                                <input name="card_height" value="{{isset(settingIdCard()->card_height) ?settingIdCard()->card_height:''}}" id="card_height" value="150" type="number" required placeholder="Card Height" class="form-control"/>
                            </div>



                            <div class="form-group col-sm-12 col-md-12">
                                <label for="">Select Fields <span class="text-danger">*</span></label>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="student_name" class="form-check form-check-inline"  checked  type="checkbox" name="student_id_card_fields[]" value="student_name"
                                        {{ in_array('student_name', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }} />

                                        Student Name
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="gr_no" class="form-check form-check-inline"  checked  type="checkbox" name="student_id_card_fields[]" value="gr_no"
                                        {{ in_array('gr_no', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }} />


                                        GR No.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="class_section" class="form-check form-check-inline"  checked  type="checkbox" name="student_id_card_fields[]" value="class_section"
                                        {{ in_array('class_section', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }} />

                                        Class Section
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="roll_number" class="form-check form-check-inline" type="checkbox"  checked  name="student_id_card_fields[]" value="roll_no"
                                        {{ in_array('roll_no', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }} />
                                      
                                        Roll Number
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="dob" class="form-check form-check-inline" type="checkbox" name="student_id_card_fields[]" value="dob"
                                        {{ in_array('dob', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }} />
                                        Date of Birth
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="gender" class="form-check form-check-inline" type="checkbox"  name="student_id_card_fields[]" value="gender"
                                        {{ in_array('gender', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }}
                                        />
                                        Gender
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="blood_group" class="form-check form-check-inline" type="checkbox"  name="student_id_card_fields[]" value="blood_group"
                                        {{ in_array('blood_group', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }}
                                        />
                                        Blood Group
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="session_year" class="form-check form-check-inline" type="checkbox"  checked  name="student_id_card_fields[]" value="session_year"
                                        {{ in_array('session_year', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }}
                                        />
                                    Session Year
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="guardian_name" class="form-check form-check-inline" type="checkbox"  checked  name="student_id_card_fields[]" value="guardian_name"
                                        {{ in_array('session_year', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }}
                                        />
                                        Father/Guardian Name
                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="address" class="form-check form-check-inline"  type="checkbox" name="student_id_card_fields[]" value="address"
                                        {{ in_array('address', old('student_id_card_fields', isset(settingIdCard()->student_id_card_fields) ? json_decode(settingIdCard()->student_id_card_fields) : [])) ? 'checked' : '' }}
                                        />
                                        Address
                                    </label>
                                </div>
                            </div>


                        </div>

                        <h3 class="page-title">
                            <small class="theme-color">Note: These signature image are also used in other documents such as Bonafide Certificates, Leaving Certificates, and Student Result Cards.</small>
                        </h3>
                        <br>
                        <br>
                        <input class="btn btn-theme" id="create-btn" type="submit" value=Submit>
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
