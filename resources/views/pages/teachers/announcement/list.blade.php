@extends('layouts.master')

@section('title')
{{ __('announcement') }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{ __('list') . ' ' . __('announcement') }}
        </h3>
    </div>
    
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @foreach ($announcement as $key=>$item)
                    <div class="accordion" id="accordion" role="tablist">
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-{{$key}}">
                                <h6 class="mb-0">
                                    <a data-toggle="collapse" href="#collapse-{{$key}}" aria-expanded="false"
                                    aria-controls="collapse-{{$key}}" class="collapsed">{{$item->title}}</a>
                                </h6>
                            </div>
                            <div id="collapse-{{$key}}" class="collapse" role="tabpanel" aria-labelledby="heading-{{$key}}"
                            data-parent="#accordion" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">{{$item->description}} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
