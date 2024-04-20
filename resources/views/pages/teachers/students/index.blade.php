@extends('layouts.masters.teacher-master')

@section('title')
    {{ __('sidebar.students') }}
@endsection

@section('content')

            <input type="hidden" name="section_id" value="{{$section->id}}" id="section_id">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ $section->name.' - '.$section->classe->name }}
                        </h4>
                        <div class="row">
                            <div class="col-12">

           <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table" data-url="{{ url('teacher/teacher-student-list') }}" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true" data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{ "fileName": "session-year-list-<?= date(' d-m-y') ?>
                ","ignoreColumn": ["operate"]}'
                data-query-params="studentQueryParams">
                <thead>
                    <tr>


                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                            {{ __('id') }}</th>

                        <th scope="col" data-field="first_name" data-sortable="true" >
                                {{ __('genirale.first_name') }}</th>
                        <th scope="col" data-field="last_name" data-sortable="true" >
                                    {{ __('genirale.last_name') }}</th>

                        <th scope="col" data-field="gender" data-sortable="false">{{ __('genirale.gender') }}
                        </th>
                        <th scope="col" data-field="roll_number" data-sortable="false">
                            {{ __('student.roll_number') }}</th>

                        <th scope="col" data-field="parent_id" data-sortable="false">
                            {{ __('student.Parent')  }}</th>



                    </tr>
                </thead>

            </table>
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
                section_id: $('#section_id').val(),
            };
        }
    </script>
@endsection
