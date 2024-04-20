@extends('layouts.master')

@section('title')
{{ __('add_bulk_data') }}
@endsection

{{-- @section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{ __('manage') . ' ' . __('students') }}
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="pt-3" id="create-form-bulk-data" enctype="multipart/form-data" action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('class') . ' ' . __('section') }} <span class="text-danger">*</span></label>
                                <select name="class_section_id" id="class_section" class="form-control select2">
                                    <option value="">{{ __('select') . ' ' . __('class') . ' ' . __('section') }}
                                    </option>
                                    @foreach ($class_section as $section)
                                    <option value="{{ $section->id }}">{{ $section->class->name }} -
                                        {{ $section->section->name }} {{ $section->class->medium->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('file_upload') }} <span class="text-danger">*</span></label>
                                <input type="file" name="file" class="file-upload-default" />
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('file_upload') }}" required="required" />
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-xs-12">
                                <input class="btn btn-theme submit_bulk_file" type="submit" value="Submit" name="submit" id="submit_bulk_file">
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="form-group col-12 col-md-3 mt-5">
                        <a class="btn btn-theme form-control" href="{{Storage::url('public/dummy_file.xlsx')}}" download>
                            <strong>{{__('download_dummy_file')}}</strong>
                        </a>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <span style="font-size: 14px"> <b>{{__('Note')}} :- </b>{{__('first_download_dummy_file_and_convert_to_csv_file_then_upload_it')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('js')
@endsection
