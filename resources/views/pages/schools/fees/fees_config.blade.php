@extends('layouts.masters.school-master')

@section('title')
{{ __('fees') }} {{__('configration')}}
@endsection


@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{__('manage')}} {{ __('fees') }} {{__('configration')}}
        </h3>
    </div>
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
                <form id="create-fees-config-form" class="fees-config" action="{{ route('fees.config.udpate') }}" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h3 class="card-title">
                            {{__('payment_gateways')}}
                        </h3>

                        <hr>
                        <div class="bg-light p-3">
                            <div class="col-lg-12 mt-3">
                                <h5 class="card-title">
                                    <i class="fa fa-angle-double-right menu-icon"></i> {{__('razorpay')}}
                                </h5>
                            </div>
                            <div class="col-lg-12" style="margin-top: 2rem">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label>{{ __('status') }} <span class="text-danger">*</span></label>
                                        <select required name="razorpay_status" id="razorpay_status" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                            @if(isset($settings['razorpay_status']))
                                                @if( $settings['razorpay_status'])
                                                <option value="1" selected>{{__('enable')}}</option>
                                                <option value="0">{{__('disable')}}</option>
                                                @else
                                                <option value="1">{{__('enable')}}</option>
                                                <option value="0" selected>{{__('disable')}}</option>
                                                @endif
                                            @else
                                            <option value="1">{{__('enable')}}</option>
                                            <option value="0">{{__('disable')}}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{ __('secret_key') }}</label>
                                        <input name="razorpay_secret_key"  value="{{ !env('DEMO_MODE') ? (isset($settings['razorpay_secret_key']) ? $settings['razorpay_secret_key'] : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'}}" type="text" placeholder="{{ __('secret_key') }}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{ __('api_key') }}</label>
                                        <input name="razorpay_api_key" value="{{ !env('DEMO_MODE') ? (isset($settings['razorpay_api_key']) ? $settings['razorpay_api_key'] : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' }}" type="text" placeholder="{{ __('api_key') }}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{__('razoray_webhook_secret')}}</label>
                                        <input name="razorpay_webhook_secret"  value="{{ !env('DEMO_MODE') ? (isset($settings['razorpay_webhook_secret']) ? $settings['razorpay_webhook_secret'] : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'}}" type="text" placeholder="{{ __('razoray_webhook_secret') }}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{__('razorpay')}} {{ __('webhook_url') }}</label>
                                        <input name="razorpay_webhook_url"  value="{{ !env('DEMO_MODE') ? (isset($domain) ? $domain.'/webhook/razorpay' : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'}}" type="text" placeholder="{{ __('razorpay').' '.__('webhook_url') }}" class="form-control" readonly/>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="bg-light p-3 mt-4">
                            <div class="col-lg-12 mt-3">
                                <h5 class="card-title">
                                    <i class="fa fa-angle-double-right menu-icon"></i> {{__('stripe')}}
                                </h5>
                            </div>
                            <div class="col-lg-12" style="margin-top: 2rem">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label>{{ __('status') }} <span class="text-danger">*</span></label>
                                        <select required name="stripe_status" id="stripe_status"  class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                            @if(isset($settings['stripe_status']))
                                                @if($settings['stripe_status'])
                                                <option value="1" selected>{{__('enable')}}</option>
                                                <option value="0">{{__('disable')}}</option>
                                                @else
                                                <option value="1">{{__('enable')}}</option>
                                                <option value="0" selected>{{__('disable')}}</option>
                                                @endif
                                            @else
                                            <option value="1">{{__('enable')}}</option>
                                            <option value="0">{{__('disable')}}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{ __('stripe_publishable_key') }}</label>
                                        <input name="stripe_publishable_key" value="{{ !env('DEMO_MODE') ? (isset($settings['stripe_publishable_key']) ? $settings['stripe_publishable_key'] : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' }}" type="text" placeholder="{{ __('stripe_publishable_key') }}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{ __('stripe_secret_key') }}</label>
                                        <input name="stripe_secret_key" value="{{ !env('DEMO_MODE') ? (isset($settings['stripe_secret_key']) ? $settings['stripe_secret_key'] : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' }}" type="text" placeholder="{{ __('stripe_secret_key') }}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{ __('stripe_webhook_secret') }}</label>
                                        <input name="stripe_webhook_secret" value="{{ !env('DEMO_MODE') ? (isset($settings['stripe_webhook_secret']) ? $settings['stripe_webhook_secret'] : '') : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' }}" type="text" placeholder="{{ __('stripe_webhook_secret') }}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>{{__('stripe')}} {{ __('webhook_url') }}</label>
                                        <input name="stripe_webhook_url"  value="{{ !env('DEMO_MODE') ? (isset($domain) ? $domain.'/webhook/stripe' : '' ) : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'}}" type="text" placeholder="{{ __('stripe').' '.__('webhook_url')}}"  class="form-control" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title" style="margin-top: 3rem">
                            {{__('other_fees')}} {{__('configration')}}
                        </h3>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>{{ __('currency_code') }} <span class="text-danger">*</span></label>
                                <input name="currency_code" value="{{ isset($settings['currency_code']) ? $settings['currency_code'] : '' }}" type="text" placeholder="{{ __('currency_code') }}" class="form-control" />
                                <span style="color: rgb(0, 55, 107);font-size: 0.8rem" class="ml-2">{{__('eg_currency_code_inr')}}</span>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ __('currency_symbol') }} <span class="text-danger">*</span></label>
                                <input name="currency_symbol" value="{{ isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '' }}" type="text" placeholder="{{ __('currency_symbol') }}" class="form-control" />
                                <span style="color: rgb(0, 55, 107);font-size: 0.8rem" class="ml-2">{{__('eg_currency_symbol_₹')}}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <input class="btn btn-theme mt-5" type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
