@extends('layouts.masters.master')

@section('title')
Ajouter Willaya
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                Ajouter Willaya
            </h3>
            <a class="btn btn-primary" href="{{ route('web.schools.index') }}"> {{ __('back') }}</a>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                            {!! Form::open(['route' => 'web.managements.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label><strong>{{ __('name') }}:</strong></label>
                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                    </div>
                                </div>



                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label><strong>{{ __('description') }}:</strong></label>
                                        {!! Form::textarea('description', null, ['placeholder' => 'Description', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ __('submit') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
