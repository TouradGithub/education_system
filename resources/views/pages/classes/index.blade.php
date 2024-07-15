@extends('layouts.masters.master')
@php
    $grades=App\Models\Grade::all();
@endphp
@section('title')
{{ trans('classes.classes') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ trans('classes.classes') }}
            </h3>
        </div>

        <div class="row">
            @can('classes-create')


            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ trans('classes.add_class') }}
                        </h4>
                        <form class="create-form pt-3" id="formdata" action="{{ route('web.classes.store')}}" method="POST" novalidate="novalidate">
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
                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="0">
                                        تحضيري
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="1">
                                        1
                                        </label>
                                    </div>
                                </div>

                            </div><br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="2">
                                        2
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="3">
                                        3
                                        </label>
                                    </div>
                                </div>

                            </div><br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="4">
                                        4
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="5">
                                        5
                                        </label>
                                    </div>
                                </div>

                            </div><br>

                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-inline col-md-4">
                                        <label class="form-check-label">
                                            <input type="radio" name="arrangement" class="fees_installment_toggle" value="6">
                                        6
                                        </label>
                                    </div>
                                </div>

                            </div><br>

                        <div class="row">

                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ trans('Grades') }}</label>
                                <select name="grade_id" id="class_section" class="form-control select2">
                                    <option value="">{{ __('genirale.select') . ' '. __('sidebar.grades') }}
                                    </option>
                                    @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>



                        <div class="row">

                            <div class="form-group col-sm-12 col-md-12">
                                <label>{{ trans('genirale.note') }}</label>
                                {!! Form::textarea('notes', null, ['rows' => '2', 'placeholder' => trans('genirale.note'), 'class' => 'form-control']) !!}

                            </div>
                        </div>
                            <input class="btn btn-theme" type="submit" value={{ __('genirale.submit') }}>
                        </form>
                    </div>
                    <div class="row">

                    </div>
                </div>
            </div>
            @endcan
            @can('classes-list')
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ __('genirale.list') . ' ' . __('classes.classes') }}
                            </h4>
                            <div class="row">
                                <div class="col-12">
                                    <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                        data-url="{{ url('classes-list') }}" data-click-to-select="true"
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
                                                <th scope="col" data-field="grade_id" data-sortable="true" data-visible="false">
                                                        {{ __('id') }}</th>

                                                <th scope="col" data-field="no" data-sortable="false">{{ __('genirale.no.') }}
                                                </th>
                                                <th scope="col" data-field="name" data-sortable="false"> {{trans('genirale.name')}}
                                                </th>

                                                <th scope="col" data-field="arrangement" data-sortable="false"  data-visible="false"> {{trans('arrangement')}}
                                                </th>

                                                <th scope="col" data-field="name_en" data-sortable="false"> {{trans('grade.name_en')}}
                                                </th>
                                                <th scope="col" data-field="grade" data-sortable="false"> {{trans('section.grade')}}
                                                </th>
                                                </th>
                                                <th scope="col" data-field="notes" data-sortable="false">
                                                    {{  trans('genirale.note')}}
                                                </th>

                                                @if (Auth::user()->can('classes-edit') || Auth::user()->can('classes-delete'))
                                                    <th   data-events="actionEvents" data-width="150" scope="col" data-field="operate"
                                                        data-sortable="false">{{ __('genirale.action') }}</th>
                                                @endif
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

    @can('classes-edit')
        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('genirale.edit') . ' ' . __('classes.class') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form id="formdata" class=" editformclasses" action="{{url('classes')}}" novalidate="novalidate">
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


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="0">
                                    تحضيري
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="1">
                                    1
                                    </label>
                                </div>
                            </div>

                        </div><br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="2">
                                    2
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="3">
                                    3
                                    </label>
                                </div>
                            </div>

                        </div><br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="4">
                                    4
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="5">
                                    5
                                    </label>
                                </div>
                            </div>

                        </div><br>

                        <div class="row">


                            <div class="col-md-6">
                                <div class="form-inline col-md-4">
                                    <label class="form-check-label">
                                        <input type="radio" name="arrangement" class="fees_installment_toggle" value="6">
                                    6
                                    </label>
                                </div>
                            </div>

                        </div><br>


                        <div class="row form-group col-sm-12 col-md-12">
                            <label>{{ trans('section.grade') }}</label>
                            <select name="grade_id" id="grade_id" class="form-control select2">
                                <option value="">{{ __('genirale.select') . ' '. __('section.grade') }}
                                </option>
                                @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12">
                                <label>{{  trans('genirale.note')}}</label>
                                {!! Form::text('notes', null, ['placeholder' =>  trans('genirale.note'), 'class' => 'form-control', 'id' => 'notes']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-theme class_submit_button" type="submit" value={{ __('submit') }}>
                        <button type="button" class="btn btn-light " data-dismiss="modal">{{ __('cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    @endcan

@endsection

@section('script')
    <script>
        window.actionEvents = {
            'click .editdata': function(e, value, row, index) {
                $('#id').val(row.id);
                $('#name').val(row.name);
                $('#name_en').val(row.name_en);
                $('#notes').val(row.notes);
                $('input[name="arrangement"][value="' + row.arrangement + '"]').prop('checked', true);

                setTimeout(function () {
                    $('#grade_id').val(row.grade_id).trigger('change');
                }, 1000);

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
