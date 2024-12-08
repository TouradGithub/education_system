

@extends('layouts.masters.school-master')
@php
    $grades=App\Models\Grade::all();
    $session_years= App\Models\SessionYear::all();
@endphp
@section('title')
List Students
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{__('genirale.list').' ' . __('promotion.promotions')}}
            </h3>
        </div>

        <div class="row">
            @can('school-students-index')
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('genirale.list').' ' . __('promotion.promotions') }}
                        </h4>
                        <div class="row">
                            <div class="col-12">
                                <div id="toolbar" class="row align-items-center">
                                    <div class="col">
                                        <label for="s_section_id" style="font-size: 0.89rem">
                                            {{ __('classes.classes') }}
                                        </label>
                                        <select name="s_section_id" id="s_section_id" class="form-control">
                                            <option value="">{{ __('all') }}</option>
                                            @foreach (getSchool()->sections as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->classe->name ?? ' ' }} {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="session_year" style="font-size: 0.89rem">
                                            {{ __('promotion.academic_year') }}
                                        </label>
                                        <select name="session_year" id="session_year" class="form-control">
                                            <option value="">{{ __('all') }}</option>
                                            @foreach ($session_years as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->classe->name ?? ' ' }} {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Export Result Button -->
                                        <button id="export-result-btn" class="btn btn-primary">
                                            {{ __('Export Result') }}
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Export Inscription Button -->
                                        <button id="export-inscription-btn" class="btn btn-secondary">
                                            {{ __('Export Inscription') }}
                                        </button>
                                    </div>
                                </div>
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ route('school.student.promotions.show') }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                    data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                    data-fixed-columns="true" data-fixed-number="2" data-fixed-right-number="1"
                                    data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                                    data-sort-order="desc" data-maintain-selected="true"
                                    data-export-types='["txt","excel"]'
                                    data-events="promotionQueryParams"
                                    data-query-params="promotionQueryParams"
                                    data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                {{ __('id') }}</th>
                                            <th scope="col" data-field="fullName" data-sortable="true">
                                                {{ __('genirale.first_name') }}</th>
                                            <th scope="col" data-field="from_section_id" data-sortable="true">
                                                {{ __('promotion.from_section') }}</th>
                                            <th scope="col" data-field="to_section_id" data-sortable="false">
                                                {{ __('promotion.to_section') }}</th>
                                            <th scope="col" data-field="academic_year" data-sortable="false">
                                                {{ __('promotion.academic_year') }}</th>
                                            <th scope="col" data-field="academic_year_new" data-sortable="true">
                                                {{ __('promotion.academic_year_new') }}</th>
                                            <th scope="col" data-field="is_admin" data-sortable="true" data-formatter="decisionPromotion">
                                                Decision</th>
                                            <th data-events="actionEvents" data-width="150" scope="col" data-field="operate"
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
        document.getElementById('export-inscription-btn').addEventListener('click', function () {
            const sectionId = document.getElementById('s_section_id').value;
            const sessionYear = document.getElementById('session_year').value;
            if (!sectionId || !sessionYear) {
                alert('{{ __("Please select both a section and an academic year.") }}');
                return;
            }
            let url = "{{ route('school.student.promotions.export.inscription.pdf') }}";
            url += `?s_section_id=${sectionId}&session_year=${sessionYear}`;
            window.location.href = url;
        });
        document.getElementById('export-result-btn').addEventListener('click', function () {
            const sectionId = document.getElementById('s_section_id').value;
            const sessionYear = document.getElementById('session_year').value;
            if (!sectionId || !sessionYear) {
                alert('Please select both a section and an academic year.');
                return;
            }
            let url = "{{ route('school.student.promotions.export.results.pdf') }}";
            url += `?s_section_id=${sectionId}&session_year=${sessionYear}`;

            window.location.href = url;
        });

    </script>

    <script type="text/javascript">
        function promotionQueryParams(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search,
                section_id: $('#s_section_id').val(),
                session_year: $('#session_year').val(),
            };
        }
    </script>
@endsection
