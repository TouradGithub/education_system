<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Subscription of School || {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (App::getLocale() == 'ar')
    <html lang="en" dir="rtl">
    @else
        <html lang="en">
    @endif
    @include('layouts.include')
    @yield('css')

</head>
<body class="sidebar-fixed">
<div class="container-scroller">
@php
    $grades= App\Models\Grade::all();
    $acadimy =App\Models\Acadimy::all();
 @endphp


    <div class="container-fluid page-body-wrapper">


                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            Subscribe OF School
                        </h3>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mx-auto order-0">
                    <div class="alert alert-fill-danger my-2" role="alert">
                        <i class="fa fa-exclamation"></i>  You Have to pay {{getYearNow()->price}} MRU for this Year  {{getYearNow()->name}}  to Subscribe in Our System<a href="" class="alert-link"></a>.
                    </div>
                </div>


                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Subscribe OF School
                                    </h4>
                                    <form class="pt-3"  action="{{ route('web.chargilypay.redirect')}}" method="POST" novalidate="novalidate">
                                        @csrf
                                        <input type="hidden" value="{{getYearNow()->price}}" name="price">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>{{ __('genirale.name') }}:</strong></label>
                                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>{{ __('genirale.email') }}:</strong></label>
                                                        {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>{{ __('genirale.password') }}:</strong></label>
                                                        {!! Form::text('password', null, ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>{{ __('genirale.mobile') }}:</strong></label>
                                                        {!! Form::text('phone', null, ['placeholder' => 'phone', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    {{-- <div class="form-group">
                                                        <strong>Role:</strong>
                                                        {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                                    </div> --}}
                                                </div>
                                                <div class="form-group col-sm-12 col-md-6">
                                                    <label>Grades <span class="text-danger">*</span></label>
                                                    <select name="grade_id" id="class_section" class="form-control select2">
                                                        <option value="">{{ __('genirale.select') }}
                                                        </option>
                                                        @foreach ($grades as $grade)
                                                        <option value="{{ $grade->id }}"> {{ $grade->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-group col-sm-12 col-md-6">
                                                    <label>{{ __('Type') . ' ' . __('School') }} <span class="text-danger">*</span></label>
                                                    <select name="type" id="class_section" class="form-control select2">
                                                        <option value="">{{ __('genirale.select') . ' ' . __('subjects.type')  }}
                                                        </option>
                                                        <option value="public">Public</option>
                                                        <option value="private">Private</option>

                                                    </select>

                                                </div>
                                                <div class="form-group col-sm-12 col-md-12">
                                                    <label>  Acadimy  <span class="text-danger">*</span></label>
                                                    <select name="academy_id" id="class_section" class="form-control select2">
                                                        <option value="">{{ __('genirale.select') . ' '. __('sidebar.acadimic') }}
                                                        </option>
                                                        @foreach ($acadimy as $item)
                                                        <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="row"></div>

                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label>Logo <span class="text-danger">*</span></label>
                                                    <input type="file" name="logo1" class="file-upload-default"/>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" class="form-control file-upload-info" name="image" disabled="" placeholder="{{ __('logo1') }}"/>
                                                        <span class="input-group-append">
                                                          <button class="file-upload-browse btn btn-theme" type="button">{{ __('genirale.upload') }}</button>
                                                        </span>
                                                        <div class="col-md-12">
                                                            <img height="50px" src='{{ isset($settings['logo1']) ? url(Storage::url($settings['logo1'])) : '' }}'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label><strong>Description</strong></label>
                                                        {!! Form::text('description', null, ['placeholder' => 'Description', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label><strong>{{ __('teacher.current_address') }}:</strong></label>
                                                        {!! Form::text('adress', null, ['placeholder' => 'adress', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <button type="submit" class="btn btn-primary">{{ __('genirale.submit') }}</button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
>


    </div>

</div>
<script src="{{ asset('/assets/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('/assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
<script src="{{ asset('/assets/select2/select2.min.js') }}"></script>

<script src="{{ asset('/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('/assets/js/misc.js') }}"></script>
<script src="{{ asset('/assets/js/settings.js') }}"></script>
<script src="{{ asset('/assets/js/todolist.js') }}"></script>
<script src="{{ asset('/assets/js/ekko-lightbox.min.js') }}"></script>


<script src="{{ asset('/assets/bootstrap-table/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-table/bootstrap-table-mobile.js') }}"></script>
 <script src="{{ asset('/assets/bootstrap-table/bootstrap-table-export.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-table/fixed-columns.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-table/tableExport.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-table/jspdf.min.js') }}"></script>
 <script src="{{ asset('/assets/bootstrap-table/jspdf.plugin.autotable.js') }}"></script>


 <script src="{{ asset('/assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('/assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/assets/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.repeater.js') }}"></script>
<script src="{{ asset('/assets/tinymce/tinymce.min.js') }}"></script>

<script src="{{ asset('/assets/color-picker/jquery-asColor.min.js') }}"></script>
<script src="{{ asset('/assets/color-picker/color.min.js') }}"></script>

<script src="{{ asset('/assets/js/custom/validate.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-additional-methods.min.js') }}"></script>
<script src="{{ asset('/assets/js/custom/function.js') }}"></script>
<script src="{{ asset('/assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('/assets/js/custom/custom-bootstrap-table.js') }}"></script>

<script src="{{ asset('/assets/ckeditor-4/ckeditor.js') }}"></script>
<script src="{{ asset('/assets/ckeditor-4/adapters/jquery.js') }}" async></script>






{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
{{-- @if ($errors->any())
    @foreach ($errors->all() as $error)
        <script type='text/javascript'>
            $.toast({
                text: '{{ $error }}',
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            });
        </script>
    @endforeach
@endif

@if (Session::has('success'))
    <script>
        $.toast({
            text: '{{ Session::get('success') }}',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f96868',
            position: 'top-right'
        });
    </script>
@endif
 --}}
<script>
     $(document).on('click', '.deletedata', function() {
         Swal.fire({
             title: "{{ __('genirale.delete_title') }}",
             text: "{{ __('genirale.confirm_message') }}",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: "{{ __('genirale.yes_delete') }}"
         }).then((result) => {
             if (result.isConfirmed) {
                 $.ajax({
                     url: $(this).attr('data-url'),
                     type: "DELETE",
                     success: function(response){
                         if (response['error'] == false) {
                             showSuccessToast(response['message']);
                             $('#table_list').bootstrapTable('refresh');
                         } else {
                             showErrorToast(response['message']);
                         }
                     }
                 });
             }
         })

     });
</script>
{{-- <script>
    const lang_no = "{{ __('no') }}"
    const lang_yes = "{{ __('yes') }}"
    const lang_cannot_delete_beacuse_data_is_associated_with_other_data = "{{ __('cannot_delete_beacuse_data_is_associated_with_other_data') }}"
    const lang_delete_title = "{{ __('delete_title') }}"
    const lang_delete_warning = "{{ __('delete_warning') }}"
    const lang_yes_delete = "{{ __('yes_delete') }}"
    const lang_cancel = "{{ __('cancel') }}"
    const lang_no_data_found = "{{ __('no_data_found') }}"
    const lang_cash = "{{ __('cash') }}"
    const lang_cheque = "{{ __('cheque') }}"
    const lang_online = "{{ __('online') }}"
    const lang_success = "{{ __('success') }}"
    const lang_failed = "{{ __('failed') }}"
    const lang_pending = "{{ __('pending') }}"
    const lang_select_subject = "{{ __('select_subject') }}"
    const lang_option = "{{ __('option') }}"
    const lang_simple_question = "{{ __('simple_question') }}"
    const lang_equation_based = "{{ __('equation_based') }}"
    const lang_select_option = "{{ __('select') . ' ' . __('option') }}"
    const lang_enter_option = "{{ __('enter') . ' ' . __('option') }}"
    const lang_add_new_question = "{{ __('add_new_question') }}";
    const lang_yes_change_it = "{{ __('yes_change_it') }}"
    const lang_yes_uncheck = "{{ __('yes_unckeck') }}";
    const lang_partial_paid = "{{ __('partial_paid') }}";
    const lang_due_date_on = "{{ __('due_date_on') }}";
    const lang_charges = "{{ __('charges') }}";
    const lang_total_amount = "{{ __('total')}} {{__('amount')}}";
    const lang_paid_on = "{{ __('paid_on')}}";
    const lang_due_charges = "{{ __('due_charges')}}";
    const lang_date = "{{ __('date')}}";
    const lang_pay_in_installment = "{{__('pay_in_installment')}}";
    const lang_active = "{{ __('active') }}";
    const lang_inactive = "{{ __('inactive') }}";
</script> --}}
<script>
    window.actionEvents = {
        'click .editdata': function(e, value, row, index) {

            $('#id').val(row.id);
            $('#name').val(row.name);
            $('#code').val(row.code);
            $('#type').val(row.type);
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
<script>
    // setInterval(function() {
    //     $("#notifications_count").load(window.location.href + " #notifications_count");
    //     // $("#unreadNotifications").load(window.location.href + " #unreadNotifications");
    // }, 5000);

</script>

</body>

</html>
