@extends('layouts.masters.master')

@section('title') {{__('Announcement')}} @endsection


@section('content')

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      Annoucement
    </h3>
  </div>
  <div class="row grid-margin">

    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <form id="formdata" class="setting-form" action="" method="POST" novalidate="novalidate">
            <div class="form-group col-sm-12 col-md-12 show_class_section_id">
                <label>&nbsp;</label>
                <select name="type" id="type" class="type form-control" style="width:100%;" tabindex="-1" aria-hidden="true">
                    <option value="">{{ __('genirale.select') }}</option>
                    {{-- <option value="Students">{{__('sidebar.students') }}</option> --}}
                    {{-- <option value="Teachers">{{  __('teacher.teacher') }}</option> --}}
                    <option value="Schools">{{  __('sidebar.schools') }}</option>
                    {{-- <option value="Acadimy">Willaya</option> --}}

                </select>
            </div>
            <div class="form-group col-sm-12 col-md-6">
                <label>{{ __('title') }}</label>
                {!! Form::textarea('title', null, ['rows' => '2', 'placeholder' => __('title'), 'class' => 'form-control']) !!}
            </div>
            @csrf
            <div class="row">

              <div class="form-group col-md-12 col-sm-12">
                <textarea id="tinymce_message" name="data" required placeholder="{{__('data')}}"></textarea>

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
