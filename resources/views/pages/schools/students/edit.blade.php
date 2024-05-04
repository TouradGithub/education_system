@extends('layouts.masters.school-master')
@php
   $grades= App\Models\Grade::find(getSchool()->id);
   $classeEtud= App\Models\Classes::find( $student->class_id);
   $classes=$grades->classes;
   $sections=$classeEtud->sections;
@endphp
@section('title')
    {{ __('students') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.edit') . ' ' . __('sidebar.students') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('genirale.edit') . ' ' . __('sidebar.students') }}
                            {{$student->id}}
                        </h4>
                         @can('school-students-edit')
                         <form class="pt-3 student-registration-form" enctype="multipart/form-data" action="{{ route('school.studentts.update',$student->id) }}" method="POST" novalidate="novalidate">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('genirale.first_name') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('first_name', $student->first_name, ['placeholder' => __('genirale.first_name'), 'class' => 'form-control']) !!}

                                </div>
                                {!! Form::hidden('student_id', $student->id) !!}
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('genirale.last_name') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('last_name',  $student->last_name, ['placeholder' => __('genirale.last_name'), 'class' => 'form-control']) !!}

                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('genirale.last_name') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('last_name',  $student->last_name, ['placeholder' => __('genirale.last_name'), 'class' => 'form-control']) !!}

                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('genirale.gender') }} <span class="text-danger">*</span></label><br>
                                    <div class="d-flex">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                {!! Form::radio('gender', 'male', $student->gender == 'male') !!}
                                                {{ __('genirale.male') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                {!! Form::radio('gender', 'female', $student->gender == 'female') !!}
                                                {{ __('genirale.female') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{ __('genirale.image') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="file-upload-default"/>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('genirale.image') }}"/>
                                        <span class="input-group-append">
                                          <button class="file-upload-browse btn btn-theme" type="button">{{ __('upload') }}</button>
                                        </span>
                                        <div class="col-md-12">
                                            <img height="50px" src='{{ isset($setting->logo) ?url(Storage::url($setting->logo)) : '' }}'>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('teacher.dob') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('dob', $student->date_birth, ['placeholder' => __('teacher.dob'), 'class' => 'datepicker-popup-no-future form-control']) !!}
                                    <span class="input-group-addon input-group-append">
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('classes.class')  }} <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_section" class="form-control select2">
                                        <option value="">{{ __('select') . ' ' . __('section.grade')  }}</option>
                                        @foreach ($classes as $item)
                                            <option {{ $student->class_id == $item->id ? 'selected' : '' }} value="{{$item->id}}" >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label> {{ __('section.section') }} <span class="text-danger">*</span></label>
                                    <select name="section_id" class="form-control" id="section_id">
                                        <option value="">{{ __('genirale.select') . ' '. __('section.section') }}</option>
                                        @foreach ($sections as $item)
                                            <option {{ $student->section_id == $item->id ? 'selected' : '' }} value="{{$item->id}}" >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ __('student.blood_group') }} <span class="text-danger">*</span></label>
                                    <select name="blood_group" class="form-control">
                                        <option value="">{{ __('genirale.select') . ' ' . __('student.blood_group') }}</option>
                                        <option {{ $student->blood_group == 'A+' ? 'selected' : '' }} value="A+">A+</option>
                                        <option {{ $student->blood_group == 'A-' ? 'selected' : '' }} value="A-">A-</option>
                                        <option {{ $student->blood_group == 'B+' ? 'selected' : '' }} value="B+">B+</option>
                                        <option {{ $student->blood_group == 'B-' ? 'selected' : '' }} value="B-">B-</option>
                                        <option {{ $student->blood_group == 'O+' ? 'selected' : '' }} value="O+">O+</option>
                                        <option {{ $student->blood_group == 'O-' ? 'selected' : '' }} value="O-">O-</option>
                                        <option  {{ $student->blood_group == 'AB+' ? 'selected' : '' }}value="AB+">AB+</option>
                                        <option  {{ $student->blood_group == 'AB-' ? 'selected' : '' }}value="AB-">AB-</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{ __('teacher.current_address') }} <span class="text-danger">*</span></label>
                                    {!! Form::textarea('current_address', $student->current_address, ['placeholder' => __('teacher.current_address'), 'class' => 'form-control', 'id' => 'current_address','rows'=>2]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{ __('teacher.permanent_address') }} <span class="text-danger">*</span></label>
                                    {!! Form::textarea('permanent_address', $student->permanent_address, ['placeholder' => __('teacher.permanent_address'), 'class' => 'form-control', 'id' => 'permanent_address','rows'=>2]) !!}
                                </div>
                            </div>
                            <hr>



                            <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                         @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script >

document.getElementById('class_section').addEventListener('change', function() {
    var gradeId = this.value;
    getSectionsByGrade(gradeId);
});
function getSectionsByGrade(gradeId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/getSection-list/' + gradeId, true);
    xhr.onload = function() {
        if (this.status === 200) {
            var sections = JSON.parse(this.responseText);
            var sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '';
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section.id;
                option.text = section.name;
                sectionSelect.appendChild(option);
            });
        }
    };
    xhr.send();
}

</script>
@endsection
