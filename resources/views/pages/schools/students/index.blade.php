

@extends('layouts.masters.school-master')
@php
    $grades=App\Models\Grade::all();
@endphp
@section('title')
List Students
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                List Students
            </h3>
        </div>

        <div class="row">
            @can('school-students-index')
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('genirale.list') . ' ' . __('section.sections') }}
                        </h4>
                        <div class="row">

                            <div class="col-12">
                                <div id="toolbar" class="row">
                                    <div class="col">
                                        <label for="s_section_id" style="font-size: 0.89rem">
                                            {{ __('classes.classes') }}
                                        </label>
                                        <select name="s_section_id" id="s_section_id" class="form-control">
                                            <option value="">{{ __('all') }}</option>
                                            @foreach (getSchool()->sections as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->classe->name  ?? ' '}}      {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ route('school.student.getList') }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]"  data-search="true"
                                    data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                    data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1"
                                    data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                    data-sort-order="desc" data-maintain-selected="true"
                                    data-export-types='["txt","excel"]'
                                    data-events="studentQueryParams"
                                    data-query-params="studentQueryParams"
                                    data-show-export="true"
                                    >
                                    <thead>
                                        <tr>

                    <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                        {{ __('id') }}</th>

                    <th scope="col" data-field="fullName" data-sortable="true" >
                            {{ __('genirale.first_name') }}</th>
                   <th scope="col" data-field="section_id" data-sortable="true" >
                                    {{ __('section.section') }}</th>
                    <th scope="col" data-field="gender" data-sortable="false">{{ __('genirale.gender') }}
                    </th>
                    <th scope="col" data-field="date_birth" data-sortable="false" >{{ __('teacher.dob') }}</th>
                    <th scope="col" data-field="roll_number" data-sortable="false">
                        {{ __('student.roll_number') }}</th>
                        <th scope="col" data-field="qr_code" data-sortable="false">
                            {{ __('student.roll_number') }}</th>

                    <th scope="col" data-field="blood_group" data-sortable="true" >{{ __('student.blood_group') }}</th>

                    <th scope="col" data-field="parent_id" data-sortable="false">
                        {{ __('student.Parent')  }}</th>
                        <th   data-events="actionEvents" data-width="150" scope="col" data-field="operate"
                        data-sortable="false">{{ __('genirale.action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            {{-- @endif --}}
        </div>
    </div>



@endsection



@section('script')
    <script>
        window.actionEvents = {
            'click .editdata': function(e, value, row, index) {

                $('#id').val(row.id);
                $('#name').val(row.name);
                $('#notes').val(row.notes);

            }
        };
    </script>

    <script type="text/javascript">
        function studentQueryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search,
                section_id: $('#s_section_id').val(),
            };
        }
    </script>
@endsection
