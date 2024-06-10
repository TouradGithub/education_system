@extends('layouts.masters.master')

@section('title')
{{ __('session_years') }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{ __('genirale.manage').' '.__('sidebar.session_years') }}
        </h3>
    </div>

    <div class="row">
        @can('session-year-create')
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ __('genirale.create').' '.__('sidebar.session_years') }}
                    </h4>
                    <form action="{{ url('session-years') }}" class="create-form-reload pt-3" id="formdata" method="POST" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ __('genirale.name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['required', 'placeholder' => __('genirale.name'), 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{__('genirale.price')}} <span class="text-danger">*</span></label>
                                {!! Form::text('price', null, ['required', 'placeholder' => __('genirale.price'), 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.start_date') }} <span class="text-danger">*</span></label>
                                {!! Form::text('start_date', null, ['required', 'placeholder' => __('genirale.start_date'), 'class' => 'datepicker-popup form-control']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>{{ __('genirale.end_date') }} <span class="text-danger">*</span></label>
                                {!! Form::text('end_date', null, ['required', 'placeholder' => __('genirale.end_date'), 'class' => 'datepicker-popup form-control']) !!}
                                <span class="input-group-addon input-group-append">
                                </span>
                            </div>


                        </div>
                        <hr>
                        <h4 class="card-title">
                            {{-- {{ __('fees').' '.__('installment') }} --}}
                        </h4>
                        <div class="row mb-4 mt-4">
                            <div class="form-inline col-md-4">
                                {{-- <label>{{__('include')}} {{__('fees')}} {{__('installment')}}</label> <span class="ml-1 text-danger">*</span> --}}
                                <div class="ml-4 d-flex">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="fees_installment" class="fees_installment_toggle" value="1">
                                            {{ __('enable') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="fees_installment" class="fees_installment_toggle" value="0" checked>
                                            {{ __('disable') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fees_installment_content" style="display: none">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{ __('installment') }} {{__('name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="installment_data[1][name]" id="installmentName_1" class="form-control" placeholder="{{ __('installment') }} {{__('name')}}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('due_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="installment_data[1][due_date]" id="installmentDueDate_1" class="datepicker-popup form-control" placeholder="{{ __('due_date') }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>{{ __('due_charges') }} <span class="text-danger">*</span><span class="text-info small">( {{__('in_percentage_%')}} )</span></label>
                                    <input type="number" name="installment_data[1][due_charges]" id="instllmentDueCharges_1" class="form-control" placeholder="{{ __('due_charges') }}" required>
                                </div>
                                <div class="form-group col-md-1 pl-0 mt-4">
                                    <button type="button" class="btn btn-inverse-success btn-icon add-fee-installment-content">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="extra-fee-installment-content"></div>

                        <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                    </form>
                </div>
            </div>
        </div>
        @endcan
        @can('session-year-create')
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ __('genirale.list').' '.__('sidebar.session_years') }}
                    </h4>
                    <div class="row">
                        <div class="col-12">
                            <table aria-describedby="mydesc" class='table' id='table_list'
                            data-toggle="table" data-url="{{ url('session_years_list') }}" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]"  data-search="true" data-toolbar="#toolbar"
                            data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                            data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                            data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                            data-export-options='{ "fileName": "session-year-list-<?= date('d-m-y') ?>","ignoreColumn": ["operate"]}'
                            data-query-params="sessionYearQueryParams">
                            <thead>
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{__('id')}}</th>
                                    <th scope="col" data-field="no" data-sortable="false">{{__('genirale.no.')}}</th>
                                    <th scope="col" data-field="name" data-sortable="false">{{__('genirale.name')}}</th>
                                    <th scope="col" data-field="price" data-sortable="false">{{__('genirale.price')}}</th>
                                    <th scope="col" data-field="start_date" data-sortable="true">{{__('genirale.start_date')}}</th>
                                    <th scope="col" data-field="end_date" data-sortable="true">{{__('genirale.end_date')}}</th>
                                    <th scope="col" data-field="default" data-sortable="true" data-visible="true" data-formatter="defaultYearFormatter">{{__('genirale.default')}}</th>
                                    <th data-events="sessionYearEvents" scope="col" data-field="operate" data-sortable="false">{{__('genirale.action')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
</div>


<div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ __('edit').' '.__('session_years') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form id="formdata" class="editform" action="{{ url('session-years') }}" novalidate="novalidate">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>{{ __('name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" placeholder="{{__('name')}}" class = "form-control" id="name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ __('start_date') }} <span class="text-danger">*</span></label>
                            <input type="text" name="start_date" id="start_date" placeholder="{{__('start_date')}}" class="datepicker-popup form-control" required>
                            <span class="input-group-addon input-group-append">
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ __('end_date') }} <span class="text-danger">*</span></label>
                            <input type="text" name="end_date" placeholder="{{__('end_date')}}" class="datepicker-popup form-control" id="end_date" required>
                            <span class="input-group-addon input-group-append">
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('fees') }} {{ __('due_date')}} <span class="text-danger">*</span></label>
                            <input type="text" name="fees_due_date" class="datepicker-popup form-control" id="fees_due_date" placeholder="{{ __('fees') }} {{ __('due_date')}}" required>
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('fees') }} {{ __('due_charges')}} <span class="text-danger">*</span> <span class="text-info small">( {{__('in_percentage_%')}} )</span></label>
                            <input type="number" name="fees_due_charges" class="form-control" id="fees_due_charges" placeholder="{{ __('fees') }} {{ __('due_charges')}}" required>
                            </span>
                        </div>
                    </div>

                    <input type="hidden" name="edit_include_fee_installments" class="from-control" id="edit_include_fee_installments">
                    <div class="row form-group installment-div" style="display:none">
                        <hr class="edit-installment-hr" style='width:100%;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);'>
                        <h5 class="card-title edit-installment-heading ml-3">{{ __('edit').' '.__('fees').' '.__('installment') }}</h5>
                        <div class="edit-installment-container col-md-12 mt-4"></div>
                        <div class="form-group col-md-12 mt-4">
                            <button type="button" class="btn btn-inverse-success add-extra-fee-installment-data">
                                <i class="fa fa-plus"></i> {{__('add_new_data')}} </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{__('cancel')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="edit-installment-content-template" style="display: none">
    <input type="hidden" name="installment_data[0][id]" id="editInstallmentId_0" class="form-control">
    <div class="row">
        <div class="form-group col-md-4">
            <label>{{ __('installment') }} {{__('name')}} <span class="text-danger">*</span></label>
            <input type="text" name="installment_data[0][name]" id="editInstallmentName_0" class="form-control" placeholder="{{ __('installment') }} {{__('name')}}" required>
        </div>
        <div class="form-group col-md-4">
            <label>{{ __('due_date') }} <span class="text-danger">*</span></label>
            <input type="text" name="installment_data[0][due_date]" id="editInstallmentDueDate_0" class="datepicker-popup form-control" placeholder="{{ __('due_date') }}" required>
        </div>
        <div class="form-group col-md-3">
            <label>{{ __('due_charges') }} <span class="text-danger">*</span><span class="text-info small">( {{__('in_percentage_%')}} )</span></label>
            <input type="number" name="installment_data[0][due_charges]" id="editInstllmentDueCharges_0" class="form-control" placeholder="{{ __('due_charges') }}" min="1" required>
        </div>
        <div class="form-group col-md-1 pl-0 mt-4">
            <button type="button" class="btn btn-inverse-success btn-icon add-edit-fee-installment-content">
                <i class="fa fa-plus"></i></button>
        </div>
    </div>
</div>
@endsection
