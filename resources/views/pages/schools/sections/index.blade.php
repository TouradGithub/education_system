@extends('layouts.masters.school-master')
@php

    $classes=App\Models\Classes::where('grade_id',getSchool()->grade_id)->get();

@endphp
@section('title')
{{ trans('section.sections') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ trans('section.sections') }}
            </h3>
        </div>

        <div class="row">
            @if (Auth::user()->can('school-sections-create'))
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ trans('section.add_section') }}
                        </h4>
                        <form class="create-form pt-3"  action="{{ route('school.sections.store')}}" method="POST" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ trans('grade.name_ar') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('name', null, ['required', 'placeholder' => trans('grade.name_ar'), 'class' => ' form-control']) !!}
                                    <span class="input-group-addon input-group-append">
                                    </span>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ trans('grade.name_en') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('name_en', null, ['required', 'placeholder' => trans('grade.name_en'), 'class' => 'form-control']) !!}

                                </div>
                            </div>

                        <div class="row">

                            {{-- <div class="form-group col-sm-12 col-md-6">
                                <label>{{ trans('sidebar.grades') }}</label>
                                <select name="grade_id" id="class_grade" class="form-control select2">
                                    <option value="">{{ __('genirale.select') . ' '. __('section.grade') }}
                                    </option>
                                    @foreach ($classes as $grade)
                                        <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}


                            <div class=" form-group col-sm-12 col-md-12">
                                    <label> {{ __('classes.class') }} <span class="text-danger">*</span></label>
                                    <select name="class_id" class="form-control" id="class_id">
                                        @foreach ($classes as $grade)
                                            <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                            </div>


                        </div>
                        <div class="row">

                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ trans('genirale.note')}}</label>
                                {!! Form::textarea('notes', null, ['rows' => '2', 'placeholder' => trans('genirale.note'), 'class' => 'form-control']) !!}

                            </div>
                        </div>
                            <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @can('school-sections-index')
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('genirale.list') . ' ' . __('section.sections') }}
                            </h4>
                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                        data-url="{{ url('school/getClassRoom-list') }}" data-click-to-select="true"
                                        data-side-pagination="server" data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]"  data-search="true"
                                        data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                        data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1"
                                        data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                        data-sort-order="desc" data-maintain-selected="true"
                                        data-export-types='["txt","excel"]'

                                        data-query-params="queryParams">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                    {{ __('id') }}</th>

                                                <th scope="col" data-field="name_ar" data-sortable="false">
                                                    {{trans('grade.name_ar')}}
                                                </th>
                                                <th scope="col" data-field="name" data-sortable="false">
                                                    {{trans('grade.name_en')}}
                                                </th>
                                                <th scope="col" data-field="grade" data-sortable="false"> {{trans('section.grade')}}
                                                </th>
                                                <th scope="col" data-field="class" data-sortable="false"> {{trans('classes.class')}}
                                                </th>
                                                </th>
                                                <th scope="col" data-field="notes" data-sortable="false">
                                                    {{  trans('genirale.note')}}
                                                </th>

                                                {{-- @if (Auth::user()->can('holiday-edit') || Auth::user()->can('holiday-delete')) --}}
                                                    <th   data-events="actionEvents" data-width="150" scope="col" data-field="operate"
                                                        data-sortable="false">{{ __('genirale.action') }}</th>
                                                {{-- @endif --}}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
        </div>
    </div>


    @can('school-sections-edit')
    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('genirale.edit') . ' ' . __('section.section') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class="editform" action="{{url('school/update-section-list')}}" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="id">
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{trans('grade.name_ar')}} <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['required', 'placeholder' =>trans('grade.name_ar'), 'class' => ' form-control', 'id' => 'name']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{trans('grade.name_en')}} <span class="text-danger">*</span></label>
                                {!! Form::text('name_en', null, ['required', 'placeholder' =>trans('grade.name_en'), 'class' => 'form-control', 'id' => 'name_en']) !!}
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class=" form-group col-sm-12 col-md-6">
                                <label>{{ trans('section.grade') }}</label>
                                <select name="grade_id" id="class_grade" class="form-control select2" >
                                    </option>
                                    @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class=" form-group col-sm-12 col-md-12">
                                <label> {{ __('classes.class') }} <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control" id="class_id_edit">
                                    @foreach ($classes as $grade)
                                    <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                @endforeach
                                </select>
                        </div>

                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{  trans('genirale.note')}}</label>
                                {!! Form::text('notes', null, ['placeholder' =>  trans('genirale.note'), 'class' => 'form-control', 'id' => 'notes']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('genirale.cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

@endsection

@section('script')
    <script>
        window.actionEvents = {
            'click .editdata': function(e, value, row, index) {
                console.log("OK=============");
                $('#id').val(row.id);
                $('#name').val(row.name_ar);
                $('#name_en').val(row.name);
                $('#class_grade option').filter(function() {
                    if($(this).text().trim() === row.grade.trim()){
                        var gradeId = this.value;
                        getSectionsByGradeEdit(gradeId);
                    }
                    return $(this).text().trim() === row.grade.trim();
                }).prop('selected', true).trigger('change');

                $('#class_id_edit option').filter(function() {

                    return $(this).text().trim() === row.class.trim();
                }).prop('selected', true).trigger('change');
                $('#notes').val(row.notes);

            }
        };

        function queryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }


document.getElementById('class_grade').addEventListener('change', function() {
    var gradeId = this.value;
    getSectionsByGrade(gradeId);
});
function getSectionsByGrade(gradeId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/getClasses-list/' + gradeId, true);
    xhr.onload = function() {
        if (this.status === 200) {
            var sections = JSON.parse(this.responseText);
            var sectionSelect = document.getElementById('class_id');
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
function getSectionsByGradeEdit(gradeId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/getClasses-list/' + gradeId, true);
    xhr.onload = function() {
        if (this.status === 200) {
            var sections = JSON.parse(this.responseText);
            var sectionSelect = document.getElementById('class_id_edit');
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
