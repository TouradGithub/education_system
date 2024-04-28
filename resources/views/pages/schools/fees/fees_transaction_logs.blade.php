@extends('layouts.masters.school-master')

@section('title')
{{__('online')}} {{__('fees')}} {{ __('transactions') }} {{__('logs')}}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{__('online')}} {{__('fees')}} {{ __('transactions') }} {{__('logs')}}
        </h3>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card search-container">
            <div class="card">
                <div class="card-body">
                    <div id="toolbar" class="row">
                        <div class="col col-md-4">
                            <label for="filter_class_id" style="font-size: 0.89rem">
                                {{ __('class') }}
                            </label>
                            <select name="filter_class_id" id="filter_class_id" class="form-control">
                                <option value="">{{ __('all') }}</option>
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }} {{$class->medium->name}} {{$class->streams->name ?? ' '}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col col-md-4">
                            <label for="filter_session_year_id" style="font-size: 0.89rem">
                                {{ __('session_years') }}
                            </label>
                            <select name="filter_session_year_id" id="filter_session_year_id" class="form-control">
                                <option value="">{{__('all')}}</option>
                                @foreach ($session_year_all as $session_year)
                                <option value="{{ $session_year->id}}">
                                    {{ $session_year->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col col-md-4">
                            <label for="filter_payment_status" style="font-size: 0.86rem;width: 110px">
                                {{ __('payment_status') }}
                            </label>
                            <select name="filter_payment_status" id="filter_payment_status" class="form-control">
                                <option value="">{{__('all')}}</option>
                                <option value="0">{{__('failed')}}</option>
                                <option value="1">{{__('success')}}</option>
                                <option value="2">{{__('pending')}}</option>
                            </select>
                        </div>
                    </div>
                    <table aria-describedby="mydesc" class='table table-striped' id='table_list' data-toggle="table" data-url="{{ route('fees.transactions.log.list', 1) }}" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true" data-fixed-columns="false" data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{ "fileName": "{{__('fees')}}-{{__('transactions')}}-<?= date(' d-m-y') ?>" ,"ignoreColumn":["operate"]}' data-show-export="true" data-query-params="feesPaymentTransactionQueryParams" >
                        <thead>
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">{{__('id')}}</th>
                                <th scope="col" data-field="student_id" data-sortable="true" data-visible="false">{{__('student_id')}}</th>
                                <th scope="col" data-field="no" data-sortable="false">{{ __('no.') }}</th>
                                <th scope="col" data-field="student_name" data-sortable="false">{{ __('students').' '.__('name') }}</th>
                                <th scope="col" data-field="total_fees" data-sortable="false" data-align="center">{{ __('total') }} {{__('fees')}}</th>
                                <th scope="col" data-field="mode" data-sortable="false" data-align="center"data-formatter="feesPaidModeFormatter">{{ __('mode') }}</th>
                                <th scope="col" data-field="cheque_no" data-sortable="false" data-align="center">{{ __('cheque_no') }}</th>
                                <th scope="col" data-field="payment_gateway" data-sortable="false" data-align="center" data-formatter="feesOnlineTransactionLogParentGateway">{{ __('payment_gateway') }}</th>
                                <th scope="col" data-field="payment_status" data-sortable="false" data-align="center" data-formatter="feesOnlineTransactionLogPaymentStatus">{{ __('payment_status') }}</th>
                                <th scope="col" data-field="order_id" data-sortable="false" data-align="center" data-visible="false">{{ __('order_id') }} / {{__('payment_intent_id')}}</th>
                                <th scope="col" data-field="payment_id" data-sortable="false" data-align="center" data-visible="false">{{ __('payment_id') }}</th>
                                <th scope="col" data-field="payment_signature" data-sortable="false" data-align="center" data-visible="false">{{ __('payment_signature') }}</th>
                                <th scope="col" data-field="session_year_name" data-sortable="false" data-align="center">{{ __('session_years') }}</th>
                                <th scope="col" data-field="created_at" data-sortable="true" data-visible="false">{{ __('created_at') }}</th>
                                <th scope="col" data-field="updated_at" data-sortable="true" data-visible="false">{{ __('updated_at') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
