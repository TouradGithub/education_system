@extends('layouts.masters.school-master')
@php
   $sections= App\Models\ClassRoom::where('school_id',getSchool()->id)->get();
   $session_years= App\Models\SessionYear::all();
@endphp
@section('title')
    {{ __('promotion.add_promotion')  }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('promotion.add_promotion') }}
            </h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">
                            {{__('promotion.add_promotion') }}
                        </h4>
                       {{-- @can('school-students-create') --}}
                       <form class="pt-3 " enctype="multipart/form-data" action="{{ route('school.student.promotions.store') }}" method="POST" novalidate="novalidate">
                        @csrf

                        <div class="row">

                            <div class="form-group col-sm-12 col-md-6">
                                <label> {{ __('promotion.from_section') }} <span class="text-danger">*</span></label>
                                <select name="from_section" class="form-control" id="from_section">
                                    <option value="">{{ __('genirale.select') . ' '. __('classes.class') }}</option>
                                    @foreach ($sections as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                                </select>
                            </div>


                            <div class="form-group col-sm-12 col-md-6">
                                <label> {{ __('promotion.to_section') }} <span class="text-danger">*</span></label>
                                <select name="to_section" class="form-control" id="to_section">
                                    <option value="">{{ __('genirale.select') . ' '. __('classes.class') }}</option>
                                    @foreach ($sections as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-sm-12 col-md-6">
                                <label> {{ __('promotion.academic_year') }} <span class="text-danger">*</span></label>
                                <select name="academic_year" class="form-control" id="academic_year">
                                    <option value="">{{ __('genirale.select') . ' '. __('promotion.academic_year') }}</option>
                                    @foreach ($session_years as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                                </select>
                            </div>


                            <div class="form-group col-sm-12 col-md-6">
                                <label> {{ __('promotion.academic_year_new') }} <span class="text-danger">*</span></label>
                                <select name="academic_year_new" class="form-control" id="academic_year_new">
                                    <option value="">{{ __('genirale.select') . ' '. __('promotion.academic_year_new') }}</option>
                                    @foreach ($session_years as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                                </select>
                            </div>
                        </div>





                        <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                    </form>
                       {{-- @endcan --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script >


document.getElementById('from_section').addEventListener('change', function() {
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
