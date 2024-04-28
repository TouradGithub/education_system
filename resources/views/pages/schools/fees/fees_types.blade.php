@extends('layouts.masters.school-master')

@section('title')
    {{ __('fees') }} {{ __('type') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage') }} {{ __('fees') }} {{ __('type') }}
            </h3>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('create') }} {{ __('fees') }} {{ __('type') }}
                        </h4>
                        <form id="create-form" class="pt-3 create-form" url="{{ url('fees-type') }}" method="POST"
                            novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-5">
                                    <label>{{ __('name') }} <span class="text-danger">*</span></label>
                                    {!! Form::text('name', null, ['required', 'placeholder' => __('name'), 'class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-6 col-md-7">
                                    <label>{{ __('description') }} </label>
                                    {!! Form::textarea('description', null, ['placeholder' => __('description'), 'class' => 'form-control']) !!}
                                </div>
                                {{-- <div class="form-group col-sm-6 col-md-3">
                                <label>{{ __('choiceable') }} <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        {!! Form::radio('choiceable', 1, true, ['class' => 'form-check-input']) !!}
                                        {{ __('yes') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        {!! Form::radio('choiceable', 0, false, ['class' => 'form-check-input']) !!}
                                        {{ __('no') }}
                                    </label>
                                </div>
                            </div> --}}
                            </div>
                            <input class="btn btn-theme" type="submit" value={{ __('submit') }}>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card search-container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('list') }} {{ __('fees') }}
                        </h4>
                        <div class="row">
                            <div class="col-12">
                                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                    data-url="{{ route('fees-type.show', 1) }}" data-click-to-select="true"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                    data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                                    data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                    data-mobile-responsive="true" data-sort-name="id" data-sort-order="desc"
                                    data-maintain-selected="true" data-export-types='["txt","excel"]'
                                    data-query-params="feesTypeQueryParams">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                                {{ __('id') }}</th>
                                            <th scope="col" data-field="no" data-sortable="false">{{ __('no.') }}
                                            </th>
                                            <th scope="col" data-field="name" data-sortable="true">{{ __('name') }}
                                            </th>
                                            <th scope="col" data-field="description" data-sortable="true">
                                                {{ __('description') }}</th>
                                            {{-- <th scope="col" data-field="choiceable" data-sortable="true"
                                                data-formatter="feesTypeChoiceable" data-align="center">
                                                {{ __('choiceable') }}</th> --}}
                                            <th scope="col" data-events="FeesTypeActionEvents" data-field="operate"
                                                data-sortable="false">{{ __('action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('edit_fees') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <form id="edit-form" class="pt-3 edit-form" action="{{ url('fees-type') }}">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">{{ __('name') }} <span class="text-danger">*</span></label>
                                {!! Form::text('edit_name', null, [
                                    'required',
                                    'class' => 'form-control edit_name',
                                    'id' => 'edit_name',
                                    'placeholder' => __('name'),
                                ]) !!}
                            </div>

                            <div class="form-group">
                                <label for="name">{{ __('description') }} </label>
                                {!! Form::textarea('edit_description', null, [
                                    'class' => 'form-control edit_description',
                                    'id' => 'edit_description',
                                    'placeholder' => __('description'),
                                ]) !!}
                            </div>
                            {{-- <div class="form-group">
                                <label>{{ __('choiceable') }}</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                         {!! Form::radio('edit_choiceable', 1, true, ['class' => 'form-check-input edit_choiceable']) !!}
                                        <input type="radio" name="edit_choiceable" value="1"
                                            id="edit_choiceable_true" class="form-check-input">
                                        {{ __('yes') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" name="edit_choiceable" value="0"
                                            id="edit_choiceable_false" class="form-check-input">
                                         {!! Form::radio('edit_choiceable', 0,['class' => 'form-check-input edit_choiceable_false']) !!}
                                        {{ __('no') }}
                                    </label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-secondary"data-dismiss="modal">{{ __('close') }}</button>
                            <input class="btn btn-theme" type="submit" value={{ __('submit') }} />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
