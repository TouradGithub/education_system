
<link rel="stylesheet" href="{{ asset('/assets/css/vendor.bundle.base.css') }}" async>

<link rel="stylesheet" href="{{ asset('/assets/fonts/font-awesome.min.css') }}" async/>
<link rel="stylesheet" href="{{ asset('/assets/select2/select2.min.css') }}" async>
<link rel="stylesheet" href="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/color-picker/color.min.css') }}" async>



        @if (App::getLocale() == 'fr')
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">

        @else
        <link rel="stylesheet" href="{{ asset('/assets/css/rtl.css') }}">
        @endif


<link rel="stylesheet" href="{{ asset('/assets/css/datepicker.min.css') }}" async>
<link rel="stylesheet" href="{{ asset('/assets/css/ekko-lightbox.css') }}">

<link rel="stylesheet" href="{{ asset('/assets/bootstrap-table/bootstrap-table.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/bootstrap-table/fixed-columns.min.css') }}">


 <link rel="shortcut icon" href="" />
<link rel="shortcut icon" href=""/>


<style>

</style>
{{-- <script>
    var baseUrl = "{{ URL::to('/') }}";
    const onErrorImage = (e) => {
        e.target.src = "{{ asset('/storage/no_image_available.jpg') }}";
    };
</script> --}}
