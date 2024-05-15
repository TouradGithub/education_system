@extends('layouts.masters.school-master')

@section('title')
{{ __('subjects.subject') . ' ' . __('teacher.teacher') }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{ __('genirale.manage') . ' ' . __('subjects.subject') . ' ' . __('teacher.teacher') }}
        </h3>
    </div>

    <div class="row">
        @can('school-subject-teachers')
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ __('sidebar.assign') . ' ' . __('subjects.subject') . ' ' . __('teacher.teacher') }}
                    </h4>
                    <form class=" pt-3" action="{{ url('school/subject-teachers') }}" method="POST" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('classes.class') }}  <span class="text-danger">*</span></label>
                                <select name="class_section_id" id="class_section_id" class="class_section_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{ __('genirale.select').''. __('classes.class') }}</option>
                                    @foreach ($classes as $class)
                                    <option value="{{$class->id}}" data-class="{{ $class->id }}"> {{ $class->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('section.section') }} <span class="text-danger">*</span></label>
                                <select name="section_id" id="section_id" class="section_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('teacher.teacher') }} <span class="text-danger">*</span></label>
                                <select name="teacher_id" id="teacher_id" class="teacher_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{ __('genirale.select').''. __('teacher.teacher') }}</option>
                                    @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}" data-class="{{ $teacher->id }}"> {{ $teacher->first_name.'-'.$teacher->last_name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('subjects.subject') }} <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="subject_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{ __('genirale.select').''.__('subjects.subject') }}</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-theme" type="submit" value>{{ __('genirale.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @endcan

        {{-- @can('school-subject-teacher-create') --}}
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ __('genirale.list')  }}
                    </h4>
                    <div class="row">
                        <div class="col-12">
                            <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                data-url="{{ url('school/subject-teachers-list') }}" data-click-to-select="true"
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
                                        <th scope="col" data-field="no" data-sortable="false">{{ __('genirale.no.') }}
                                        </th>
                                        <th scope="col" data-field="class_section_id" data-sortable="false" data-visible="false">{{ __('class_section_id') }}</th>
                                        <th scope="col" data-field="class_section_name" data-sortable="false">
                                            {{ __('classes.class') . ' ' . __('section.section') . ' ' . __('genirale.name') }}</th>

                                        <th scope="col" data-field="subject_id" data-sortable="true" data-visible="false">{{ __('subject_id') }}</th>
                                        <th scope="col" data-field="subject_name" data-sortable="false">
                                            {{ __('subjects.subject') . ' ' . __('genirale.name') }}</th>
                                        <th scope="col" data-field="teacher_id" data-sortable="true" data-visible="false">{{ __('teacher_id') }}</th>
                                        <th scope="col" data-field="teacher_name" data-sortable="false">
                                            {{ __('teacher.teacher') . ' ' . __('genirale.name') }}</th>
                                        {{-- @canany(['subject-teacher-edit', 'subject-teacher-delete']) --}}
                                        <th data-events="actionEvents" scope="col" data-field="operate" data-sortable="false">{{ __('genirale.action') }}</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @endcan --}}
    </div>
</div>


<div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ __('genirale.edit') . ' ' . __('subjects.subject') . ' ' . __('teacher.teacher') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form id="formdata" class="editform" action="{{ url('subject-teachers') }}" novalidate="novalidate">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label>{{ __('classes.class') }} {{ __('section.section') }} <span class="text-danger">*</span></label>
                            <select name="class_section_id" id="edit_class_section_id" class="class_section_id form-control select2" style="width:100%;">
                                @foreach ($classes as $section)
                                <option value="{{ $section->id }}" data-class="{{ $section->id }}">
                                    {{ $section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label>{{ __('subjects.subject') }} <span class="text-danger">*</span></label>
                            <select name="subject_id" id="edit_subject_id" class="subject_id form-control select2" style="width:100%;">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label>{{ __('teacher.teacher') }} <span class="text-danger">*</span></label>
                            <select name="teacher_id" id="edit_teacher_id" class="form-control select2" style="width:100%;">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"data-dismiss="modal">{{ __('genirale.cancel') }}</button>
                    <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }} />
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    window.actionEvents = {
            'click .editdata': function (e, value, row, index) {
                $('#id').val(row.id);
                $('#edit_class_section_id').val(row.class_section_id).trigger('change',row.subject_id);
                setTimeout(() => {
                    $('#edit_subject_id').val(row.subject_id).trigger('change');
                    setTimeout(() => {
                        $('#edit_teacher_id').val(row.teacher_id).trigger('change');
                    }, 500);
                }, 1000);
            }
        };
        document.getElementById('class_section_id').addEventListener('change', function() {
        var gradeId = this.value;
        if(gradeId){
            getSectionsByClass(gradeId);
            getSubjectByClass(gradeId);
        }
    });
    function getSectionsByClass(gradeId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/school/getSection-list/' + gradeId, true);
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
    function getSubjectByClass(gradeId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get-subject-by-class/' + gradeId, true);
        xhr.onload = function() {
            if (this.status === 200) {
                var sections = JSON.parse(this.responseText);
                var sectionSelect = document.getElementById('subject_id');
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

    function AssignSubjectTeacherQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        // class_id: $('#filter_class_section_id').val(),
        // class_section_id: $('#filter_class_section_id').val(),
        // teacher_id: $('#filter_teacher_id').val(),
        // subject_id: $('#filter_subject_id').val(),
    };
}
</script>
@endsection
