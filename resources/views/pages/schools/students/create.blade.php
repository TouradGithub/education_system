@extends('layouts.masters.school-master')
@php
   $classes= App\Models\Classes::where('grade_id',getSchool()->grade_id)->get();
   $parents= App\Models\MyParent::where('school_id',getSchool()->id)->get();
@endphp
@section('title')
    {{ __('sidebar.students') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.manage') . ' ' . __('sidebar.students') }}
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
                            {{ __('genirale.create') . ' ' . __('sidebar.students') }}
                        </h4>
                       @can('school-students-create')
                       <form class="pt-3 student-registration-form" enctype="multipart/form-data" action="{{ route('school.student.store') }}" method="POST" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.first_name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('first_name', null, ['placeholder' => __('genirale.first_name'), 'class' => 'form-control']) !!}

                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.last_name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('last_name', null, ['placeholder' => __('genirale.last_name'), 'class' => 'form-control']) !!}

                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.mobile') }}</label>
                                {!! Form::number('mobile', null, ['placeholder' => __('genirale.mobile'), 'class' => 'form-control' , 'min' => 0]) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.gender') }} <span class="text-danger">*</span></label><br>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            {!! Form::radio('gender', 'male') !!}
                                            {{ __('genirale.male') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            {!! Form::radio('gender', 'female') !!}
                                            {{ __('genirale.female') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.image') }} <span class="text-danger"></span></label>
                                <input type="file" name="image" class="file-upload-default"/>
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('image') }}" />
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme" type="button">{{ __('genirale.upload') }}</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('teacher.dob') }} <span class="text-danger">*</span></label>
                                {!! Form::text('dob', null, ['placeholder' => __('teacher.dob'), 'class' => 'datepicker-popup-no-future form-control']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-sm-12 col-md-6">
                                <label> {{ __('classes.class') }} <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control" id="class_id">
                                    <option value="">{{ __('genirale.select') . ' '. __('classes.class') }}</option>
                                    @foreach ($classes as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label> {{ __('section.section') }} <span class="text-danger">*</span></label>
                                <select name="section_id" class="form-control" id="section_id">
                                    <option value="">{{ __('genirale.select') . ' '. __('section.section') }}</option>

                                </select>
                            </div>

                        </div>


                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('student.blood_group') }} <span class="text-danger">*</span></label>
                                <select name="blood_group" class="form-control">
                                    <option value="">{{ __('genirale.select') . ' ' . __('student.blood_group') }}</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-6">
                                <label>{{ __('teacher.current_address') }} <span class="text-danger">*</span></label>
                                {!! Form::textarea('current_address', null, ['placeholder' => __('teacher.current_address'), 'class' => 'form-control', 'id' => 'current_address','rows'=>2]) !!}
                            </div>

                            <div class="form-group col-6">
                                <label>{{ __('teacher.permanent_address') }} <span class="text-danger">*</span></label>
                                {!! Form::textarea('permanent_address', null, ['placeholder' => __('teacher.permanent_address'), 'class' => 'form-control', 'id' => 'permanent_address','rows'=>2]) !!}
                            </div>
                        </div>
                        <hr>
                        <h4>{{ __('student.parent_guardian_details') }}</h4><br>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="exist_father" class="form-check-input" id="show-guardian-details">{{ __('student.parent_exist') }}
                                </label>
                            </div>
                        </div>
                        <div class="row " id="father_display_and_hidden">


                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{  __('genirale.first_name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('father_first_name', null, ['placeholder' => __('student.father') . ' ' . __('genirale.first_name'), 'class' => 'form-control', 'id' => 'father_first_name']) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.last_name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('father_last_name', null, ['placeholder' => __('student.father') . ' ' . __('genirale.last_name'), 'class' => 'form-control', 'id' => 'father_last_name']) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('genirale.mobile') }} <span class="text-danger">*</span></label>
                                {!! Form::number('father_mobile', null, ['placeholder' => __('student.father') . ' ' . __('genirale.mobile'), 'class' => 'form-control', 'id' => 'father_mobile', 'min' => 0]) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('student.father') . ' ' . __('teacher.dob') }} <span class="text-danger">*</span></label>
                                {!! Form::text('father_dob', null, ['placeholder' => __('student.father') . ' ' . __('teacher.dob'), 'class' => 'form-control datepicker-popup-no-future form-control', 'id' => 'father_dob']) !!}
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{ __('student.father') . ' ' . __('student.occupation') }} <span class="text-danger">*</span></label>
                                {!! Form::text('father_occupation', null, ['placeholder' => __('student.father') . ' ' . __('student.occupation'), 'class' => 'form-control', 'id' => 'father_occupation']) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label>{{__('genirale.image') }} <span class="text-danger"></span></label>
                                <input type="file" name="father_image" class="father_image file-upload-default"/>
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="{{ __('student.father') . ' ' . __('image') }}"/>
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-theme" type="button">{{ __('genirale.upload') }}</button>
                                    </span>
                                </div>
                                <div style="width: 100px;">
                                    <img src="" id="father-image-tag" class="img-fluid w-100"/>
                                </div>
                            </div>
                        </div>

                        <hr>


                        <div class="row" id="guardian_div" style="display:none;">
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('student.guardian_exist') }} <span class="text-danger">*</span></label>



                                <select id="yourSelectElement" name="father_gradian_id">
                                    @foreach ($parents as $item)
                                        <option value="{{$item->id}}">{{$item->father_first_name.' '.$item->father_last_name}}</option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

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


document.getElementById('class_id').addEventListener('change', function() {
    var gradeId = this.value;
    if(gradeId){
        getSectionsByClass(gradeId);
    }
});
function getSectionsByClass(gradeId) {
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


        $(document).ready(function() {
            $('#yourSelectElement').select2({
                placeholder: 'Select an option', // Optional placeholder text
                allowClear: true, // Optional: Allow clearing the selection
            });
        });

</script>
@endsection
