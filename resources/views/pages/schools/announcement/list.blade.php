@extends('layouts.masters.school-master')

@section('title')
{{ __('sidebar.announcement') }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            {{  __('sidebar.announcement') }}
        </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    {!! $data !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
