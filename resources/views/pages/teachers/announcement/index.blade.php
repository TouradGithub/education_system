@extends('layouts.masters.teacher-master')

@section('title')
    {{ __('sidebar.announcement') }}
@endsection
@php
        $teacher = auth('teacher')->user();
        $sections = $teacher->sectionTeachers;
    $trimesters=App\Models\Trimester::select('id','name')->get();
@endphp
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('genirale.manage') . ' ' . __('sidebar.announcement') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('create') . ' ' . __('announcement') }}
                        </h4>
                        <form class="create-form pt-3" action="{{ route('teacher.announcement.store') }}" id="formdata" method="POST" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('title') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('title', null, ['required', 'placeholder' => __('title'), 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('description') }}</label>
                                    {!! Form::textarea('description', null, ['rows' => '2', 'placeholder' => __('description'), 'class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label>{{ __('files') }} </label>
                                    <input type="file" name="file[]" class="form-control" multiple/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-3">
                                    <label>{{ __('assign_to') }}</label>
                                    <select name="set_data" id="set_data" class="form-control select2">
                                        <option value="">{{ __('select') . ' ' . __('assign_to') }}</option>
                                        {{-- @if(Auth::user()->hasRole('Teacher')) --}}
                                            <option value="class_section">{{ __('classes.class') . ' ' . __('section.section') }}</option>
                                        {{-- @else --}}
                                            {{--<option value="class">{{ __('class') }}</option>--}}
                                            <option value="general">{{ __('noticeboard') }}</option>
                                        {{-- @endif --}}
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-3 show_class_section_id">
                                    <label>&nbsp;</label>
                                    <select name="class_section_id" id="class_section_id" class="class_section_id form-control" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{ __('select') . ' ' . __('class_section') }}</option>
                                        @foreach ($sections as $item)
                                            <option value="{{ $item->section->id }}" data-class="{{ $item->section->id }}">{{ $item->section->classe->name . ' ' . $item->section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-3 show_class_section_id">
                                    <label>&nbsp;</label>
                                    <select name="subject_id" id="get_data" class="subject_id form-control" style="width:100%; display: none"></select>
                                </div>
                            </div>
                            <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('list') . ' ' . __('announcement') }}
                        </h4>
                        <div class="row">
                            <div class="col-12">
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                       data-url="{{ url('teacher/announcement-list') }}" data-click-to-select="true"
                                       data-side-pagination="server" data-pagination="true"
                                       data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                       data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                       data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1"
                                       data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                       data-sort-order="desc" data-maintain-selected="true"
                                       data-export-types='["txt","excel"]'
                                       data-export-options='{ "fileName": "announcement-list-<?= date('d-m-y') ?>" ,"ignoreColumn": ["operate"]}'
                                       data-query-params="queryParams">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{ __('id') }}</th>
                                        <th scope="col" data-field="no" data-sortable="false">{{ __('no.') }}</th>
                                        <th scope="col" data-field="title" data-sortable="false">{{ __('title') }}</th>
                                        <th scope="col" data-field="description" data-sortable="false">{{ __('description') }}</th>
                                        <th scope="col" data-field="assignto" data-sortable="false">{{ __('assign_to') }}</th>
                                        <th scope="col" data-field="file" data-sortable="false" data-formatter="fileFormatter">{{ __('files') }}</th>
                                        <th data-events="announcementEvents" data-width="150" scope="col" data-field="operate" data-sortable="false">{{ __('action') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('edit') . ' ' . __('announcement') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class="editform" action="{{ url('announcement') }}" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('title') }} <span class="text-danger">*</span></label>
                                {!! Form::text('title', null, ['required', 'placeholder' => __('title'), 'class' => 'form-control', 'id' => 'title']) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('description') }}</label>
                                {!! Form::textarea('description', null, ['rows' => 2, 'placeholder' => __('description'), 'class' => 'form-control', 'id' => 'description']) !!}
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('assign_to') }} <span class="text-danger">*</span></label>
                                <select name="set_data" id="edit_set_data" class="form-control">
                                    <option value="">{{ __('--Please') . ' ' .__('select') . ' ' . __('assign_to').'--' }}</option>
                                    {{-- @if(Auth::user()->hasRole('Super Admin'))
                                        <option value="general">{{ __('general') }}</option>
                                    @else --}}
                                        <option value="class_section">{{ __('classes.class') . ' ' . __('section.section') }}</option>
                                    {{-- @endif --}}
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 edit_show_class_section_id">
                                <label>{{__('class_section') }}</label>
                                <select name="class_section_id" id="edit_class_section_id" class="form-control" style="width:100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">{{ __('select') . ' ' . __('class_section') }}</option>
                                    {{-- @foreach ($class_section as $item)
                                        <option value="{{ $item->id }}" data-class="{{ $item->class->id }}">{{ $item->class->name . ' ' . $item->section->name. ' - ' .$item->class->medium->name }}</option>
                                    @endforeach --}}
                                </select>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label>{{ __('old_files') }} </label>
                                    <div id="old_files"></div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('upload_new_files') }} </label>
                                    <input type="file" name="file[]" class="form-control" multiple/>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 edit_show_class_section_id">
                                <label>{{ __('subject')}}</label>
                                <select name="get_data" id="edit_get_data" class="form-control" style="width:100%;" tabindex="-1" aria-hidden="true"></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.show_class_section_id').hide();

        $('#set_data').on('change', function () {
            data = $(this).val();
            if (data == 'class_section') {
                $('.show_class_section_id').show();
                $('#get_data').show();
            } else {
                $('.show_class_section_id').hide();
                $('#get_data').hide();
            }
            $.ajax({
                url: "{{ url('getAssignData') }}",
                type: "GET",
                data: {
                    data: data
                },
                success: function (response) {
                    html = '';
                    if (data == 'class') {
                        for (let i = 0; i < response.length; i++) {
                            html += '<option value=' + response[i]['id'] + '>' + response[i]['name'] +
                                '</option>';
                        }
                    }
                    $('#get_data').html(html);
                }
            });
        });


        $('#class_section_id').on('change', function () {

           data = $('#set_data').val();
           class_id = $('#class_section_id').find(':selected').attr('data-class');
        //    print(class_id);
           $.ajax({
               url: "{{ url('teacher/get-subject-list') }}",
               type: "GET",
               data: {
                   data: data,
                   class_id: class_id
               },
               success: function (response) {
                   html = '';
                   if (response != '') {
                       $('#get_data').removeAttr('multiple');
                       html += '<option value="">Select Subject</option>';
                       for (let i = 0; i < response.length; i++) {
                           html += '<option value=' + response[i]['subject']['id'] + '>' + response[i]['subject']['name'] + '</option>';
                       }
                   }
                   $('#get_data').html(html);
               }
           });
        });
    </script>

    <script>
        $('.edit_show_class_section_id').hide();
        // $('#edit_set_data').on('change', function (e, type_id) {
        //     data = $(this).val();
        //     if (data == 'class_section') {
        //         $('.edit_show_class_section_id').show();
        //     } else {
        //         $('.edit_show_class_section_id').hide();
        //     }
        //     $.ajax({
        //         url: "{{ url('getAssignData') }}",
        //         type: "GET",
        //         data: {
        //             data: data
        //         },
        //         success: function (response) {
        //             html = '';
        //             if (data == 'class') {
        //                 for (let i = 0; i < response.length; i++) {
        //                     var chk = (response[i]['id'] == type_id) ? 'selected' : '';
        //                     html += '<option value=' + response[i]['id'] + '' + chk + '>' + response[i][
        //                             'name'
        //                             ] +
        //                         '</option>';
        //                 }
        //             }
        //             $('#edit_get_data').html(html);
        //         }
        //     });
        // });


        // $('#edit_class_section_id').on('change', function (e, subjectid) {
        //     data = $('#edit_set_data').val();
        //     class_id = $('#edit_class_section_id').find(':selected').attr('data-class');

        //     $.ajax({
        //         url: "{{ url('getAssignData') }}",
        //         type: "GET",
        //         data: {
        //             data: data,
        //             class_id: class_id
        //         },
        //         success: function (response) {
        //             html = '';
        //             if (response != '') {
        //                 html += '<option value="">Select Subject</option>';
        //                 for (let i = 0; i < response.length; i++) {
        //                     var chk = (response[i]['subject']['id'] == subjectid) ? 'selected' : '';
        //                     html += '<option value=' + response[i]['subject']['id'] + ' ' + chk + '>' +
        //                         response[i]['subject']['name'] + '</option>';

        //                 }
        //             }
        //             $('#edit_get_data').html(html);
        //         }
        //     });
        // });
    </script>
    <script type="text/javascript">
        function queryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }
    </script>
@endsection
