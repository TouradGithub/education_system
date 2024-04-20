@extends('layouts.masters.teacher-master')

@section('title')
    {{ __('sidebar.students') }}
@endsection

@section('content')

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ __('genirale.manage') . ' ' . __('section.section') }}
                    </h4>
                    <div class="row">
                        <div class="col-12">


            <table aria-describedby="mydesc" class='table' id='table_list'
            data-toggle="table" data-url="{{ url('teacher/teacher-section-list') }}"
            data-click-to-select="true" data-side-pagination="server"
            data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
            data-search="true" data-toolbar="#toolbar" data-show-columns="true"
            data-show-refresh="true" data-fixed-columns="true" data-fixed-number="2"
            data-fixed-right-number="1" data-trim-on-search="false" data-mobile-responsive="true"
            data-sort-name="id" data-sort-order="desc" data-maintain-selected="true" data-export-types='["txt","excel"]'
            data-export-options='{ "fileName": "session-year-list-<?= date(' d-m-y') ?>
                ","ignoreColumn": ["operate"]}'
                data-query-params="studentQueryParams">
                <thead>
                    <tr>


                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                            {{ __('id') }}</th>

                        <th scope="col" data-field="name" data-sortable="true" >
                                {{ __('genirale.name') }}</th>
                    
                            <th    scope="col" data-field="operate"
                            data-sortable="false">{{ __('genirale.action') }}</th>


                    </tr>
                </thead>
            </table>
        </div>

    </div>
@endsection

@section('script')
    <script>

    </script>

    <script type="text/javascript">
        function studentQueryParams(p) {
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
