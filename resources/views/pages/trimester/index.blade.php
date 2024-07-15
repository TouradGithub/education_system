@extends('layouts.masters.master')
@php
    $trimesters=App\Models\Trimester::all();
@endphp
@section('title')
{{ trans('trimester.trimesters') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ trans('trimester.trimesters') }}
            </h3>
        </div>

        <div class="row">
            @if (Auth::user()->can('trimester-create'))
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ trans('trimester.add_trimester') }}
                        </h4>
                        <form class="create-form pt-3" id="formdata" action="{{ route('web.trimesters.store')}}" method="POST" novalidate="novalidate">
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
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ trans('genirale.arrangement') }} <span class="text-danger">*</span></label>

                                </div>

                            </div>


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-inline col-md-4">
                                <label class="form-check-label">
                                    <input type="radio" name="arrangement" class="fees_installment_toggle" value="1">
                                1
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-inline col-md-4">
                                <label class="form-check-label">
                                    <input type="radio" name="arrangement" class="fees_installment_toggle" value="2">
                                2
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-inline col-md-3">
                            <label class="form-check-label">
                                <input type="radio" name="arrangement" class="fees_installment_toggle" value="3">
                            3
                            </label>
                        </div>
                    </div>

                    </div><br>

                            <div class="row">

                                <div class="form-group col-sm-12 col-md-12">
                                    <label>{{ trans('genirale.note') }}</label>
                                    {!! Form::textarea('notes', null, ['rows' => '2', 'placeholder' => trans('genirale.note'), 'class' => 'form-control']) !!}

                                </div>
                            </div>
                            <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->can('trimester-list'))
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('genirale.list') . ' ' . __('trimester.trimesters') }}
                            </h4>
                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                        data-url="{{ url('trimesters-list') }}" data-click-to-select="true"
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
                                                <th scope="col" data-field="arrangement" data-sortable="true" data-visible="false">
                                                       </th>


                                                <th scope="col" data-field="name" data-sortable="false"> {{trans('grade.name_ar')}}
                                                </th>
                                                <th scope="col" data-field="name_en" data-sortable="false"> {{trans('grade.name_en')}}
                                                </th>
                                                </th>
                                                <th scope="col" data-field="notes" data-sortable="false">
                                                  {{  trans('genirale.note') }}
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
            @endif
        </div>
    </div>


    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('genirale.edit') . ' ' . __('trimester.edit_trimester') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class="editform" action="{{url('trimesters')}}" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
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
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{  trans('genirale.note')}}</label>
                                {!! Form::text('notes', null, ['placeholder' =>  trans('genirale.note'), 'class' => 'form-control', 'id' => 'notes']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-inline col-md-4">
                                <label class="form-check-label">
                                    <input type="radio" name="arrangement" class="fees_installment_toggle" value="1">
                                1
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-inline col-md-4">
                                <label class="form-check-label">
                                    <input type="radio" name="arrangement" class="fees_installment_toggle" value="2">
                                2
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-inline col-md-3">
                            <label class="form-check-label">
                                <input type="radio" name="arrangement" class="fees_installment_toggle" value="3">
                            3
                            </label>
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
@endsection

@section('script')
    <script>
        window.actionEvents = {
            'click .editdata': function(e, value, row, index) {

                $('#id').val(row.id);
                $('#name').val(row.name);

                $('#name_en').val(row.name_en);
                $('input[name="arrangement"][value="' + row.arrangement + '"]').prop('checked', true);

                $('#notes').val(row.notes);

            }
        };
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
