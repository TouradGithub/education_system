@extends('layouts.master')

@section('title') {{__('about_us')}} @endsection


@section('content')

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      {{__('about_us')}}
    </h3>
  </div>
  <div class="row grid-margin">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form id="formdata" class="setting-form" action="{{url('setting-update')}}" method="POST" novalidate="novalidate">
            @csrf
            <div class="row">
              <div class="form-group col-md-12 col-sm-12">
                {{-- <label>{{__('about_us')}}</label> --}}
                <input type="hidden" name="type" id="type" value="{{$type}}">
                
                <textarea id="tinymce_message" name="setting_message" required placeholder="{{__('about_us')}}">{{isset($settings->message) ? $settings->message : ''}}</textarea>
              </div>
            </div>
            <input class="btn btn-theme" type="submit" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
