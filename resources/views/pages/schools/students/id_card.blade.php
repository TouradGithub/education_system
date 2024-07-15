@extends('layouts.masters.school-master')

@section('title')

@endsection
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">



<style>

    body{
       font-family:'arial';
       }

    .lavkush img {
      border-radius: 8px;
      border: 2px solid blue;
    }
    span{

        font-family: 'Orbitron', sans-serif;
        font-size:16px;
    }
    hr.new2 {
      border-top: 1px dashed black;
      width:350px;
      text-align:left;
      align-items:left;
    }
     /* second id card  */
     p{
         font-size: 13px;
         margin-top: -5px;
     }

     .container0 {
        width: 80vh;
        height: 45vh;
        margin: auto;
        /* background-color: white; */
        /* background-image: url({{url(Storage::url('idcardsetting/'.settingIdCard()->background_image))}}); */
        /* box-shadow: 0 1px 10px rgb(146 161 176 / 50%);
        overflow: hidden;
        border-radius: 10px; */
    }

    .header {
        /* border: 2px solid black; */
        width: 73vh;
        height: 15vh;
        margin: 20px auto;
        background-color: {{isset(settingIdCard()->header_color)?settingIdCard()->header_color:'black'}};
        /* box-shadow: 0 1px 10px rgb(146 161 176 / 50%); */
        /* border-radius: 10px; */
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
    }

    .header h1 {
        color: rgb(90 139 249);
        text-align: right;
        margin-right: 20px;
        margin-top: 15px;
    }

    .header p {
        /* color: rgb(157, 51, 0); */
        text-align: right;
        margin-right: 22px;
        margin-top: -10px;
    }

    .container-2 {
        /* border: 2px solid red; */
        width: 73vh;
        height: 10vh;
        margin: 0px auto;
        margin-top: -20px;
        display: flex;
    }

    .box-1 {
        border: 4px solid #fff;
        width: 90px;
        height: 95px;
        margin: -40px 25px;
        border-radius: 3px;
    }

    .box-1 img {
        width: 82px;
        height: 87px;
    }

    .box-2 {
        /* border: 2px solid purple; */
        width: 33vh;
        height: 8vh;
        margin: 7px 0px;
        padding: 5px 7px 0px 0px;
        text-align: left;
        font-family: 'Poppins', sans-serif;
    }

    .box-2 h2 {
        font-size: 1.3rem;
        margin-top: -5px;
        color: rgb(90 139 249);
        ;
    }

    .box-2 p {
        font-size: 0.7rem;
        margin-top: -5px;
        color: rgb(179, 116, 0);
    }

    .box-3 {
        /* border: 2px solid rgb(21, 255, 0); */
        width: 8vh;
        height: 8vh;
        margin: 8px 0px 8px 30px;
    }
     /*!
    * Author Name: MH RONY.
    * GigHub Link: https://github.com/dev-mhrony
    * Facebook Link:https://www.facebook.com/dev.mhrony
    * Youtube Link: https://www.youtube.com/channel/UChYhUxkwDNialcxj-OFRcDw
    for any PHP, Laravel, Python, Dart, Flutter work contact me at developer.mhrony@gmail.com
    * Visit My Website : developerrony.com
    */
    .box-3 img {
        width: 8vh;
    }

    .container-3 {
        /* border: 2px solid rgb(111, 2, 161); */
        width: 73vh;
        height: 12vh;
        margin: 0px auto;
        margin-top: 10px;
        display: flex;
        font-family: 'Shippori Antique B1', sans-serif;
        font-size: 0.7rem;
    }

    .info-1 {
        /* border: 1px solid rgb(255, 38, 0); */
        width: 17vh;
        height: 12vh;
    }

    .id {
        /* border: 1px solid rgb(2, 92, 17); */
        width: 17vh;
        height: 5vh;
    }

    .id h4 {
        color: rgb(90 139 249);
        font-size:15px;
    }

    .dob {
        /* border: 1px solid rgb(0, 46, 105); */
        width: 17vh;
        height: 5vh;
        margin: 8px 0px 0px 0px;
    }

    .dob h4 {
        color: rgb(90 139 249);
        font-size:15px;
    }

    .info-2 {
        /* border: 1px solid rgb(4, 0, 59); */
        width: 17vh;
        height: 12vh;
    }

    .join-date {
        /* border: 1px solid rgb(2, 92, 17); */
        width: 17vh;
        height: 5vh;
    }

    .join-date h4 {
        color: rgb(90 139 249);
        font-size:15px;
    }

    .expire-date {
        /* border: 1px solid rgb(0, 46, 105); */
        width: 17vh;
        height: 5vh;
        margin: 8px 0px 0px 0px;
    }

    .expire-date h4 {
        color: rgb(90 139 249);
        font-size:15px;
    }

    .info-3 {
        /* border: 1px solid rgb(255, 38, 0); */
        width: 17vh;
        height: 12vh;
    }





    .info-4 {
        /* border: 2px solid rgb(255, 38, 0); */
        width: 22vh;
        height: 12vh;
        margin: 0px 0px 0px 0px;
        font-size:15px;
    }

    .phone h4 {
        color: rgb(90 139 249);
        font-size:15px;
    }

    .sign {
        /* border: 1px solid rgb(0, 46, 105); */
        width: 17vh;
        height: 5vh;
        margin: 41px 0px 0px 20px;
        text-align: center;
    }
        </style>
@endsection

@section('content')

<div class='container0' id="printsection" style="text-align:center; border:2px dotted black;
 background-size: cover; background-position: center;pading:3px">
     <div class='header'>
        <h2>{{settingIdCard()->country_text}}</h2>

        <h4>{{getSchool()->setting->school_name}}</h4>
    </div>

    @php
        // Get the old value or the current settings
        $fields = old('student_id_card_fields', json_decode(settingIdCard()->student_id_card_fields ?? '[]', true));
    @endphp

    <div class='container-2'>
        <div class='box-1'>
        <img src='{{url(Storage::url($student->image))}}' alt="NO image"/>
        </div>
        <div class='box-2'>
            <h2>Student Cart</h2>
        </div>
        <div class='box-3'>
            @php
                use Milon\Barcode\DNS2D;
                $d = new DNS2D();
                $code_bar = $d->getBarcodePNG($student->qr_code, "QRCODE");
            @endphp

            <img style="padding: 2px;margin:15px;background: white;" src="data:image/png;base64,{{ $code_bar }}" alt="QR Code">
        </div>

    </div>

    <div class='container-3'>
        <div class='info-1'>
            @if (in_array('gr_no', $fields))
            <div class='id'>
                <h4>ID No</h4>
                <p>{{$student->qr_code}}</p>
            </div>
            @endif


            @if (in_array('student_name',  $fields))
            <div class='dob'>
                <h4>Full Name</h4>
                <p>{{$student->first_name}} {{$student->last_name}}</p>
            </div>
            @endif



        </div>
        <div class='info-2'>
            @if (in_array('dob', $fields))
            <div class='join-date'>
                <h4> Date Of Birth</h4>
                <p>{{$student->date_birth}}</p>
            </div>
            @endif

            @if (in_array('class_section', $fields))
            <div class='expire-date'>
                <h4>Class Name</h4>
                <p>{{$student->section->name}}-{{$student->section->classe->name}}</p>
            </div>
            @endif


        </div>
        <div class='info-3'>
            @if (in_array('session_year', $fields))
            <div class='email'>
                <h4>Year</h4>
                <p>{{getYearNow()->name}}</p>
            </div>
            @endif


        </div>
        <div class='info-4'>
            <div class='sign'>
                <br>
                <p style='font-size:12px;    margin-bottom: 8px;'>Your Signature</p>
              <p style='font-family: Dancing Script'>Code Camp BD</p>

            </div>
        </div>


    </div>

</div>
<div class="container0">


<br> <br> <hr>
<button id="demo" onclick="printSection()" class="downloadtable btn btn-primary" > Print Id Card</button>
</div>
@endsection
@section('js')
<script >

   function printSection() {
    var node = document.getElementById('printsection');

    domtoimage.toPng(node)
        .then(function (dataUrl) {
            var img = new Image();
            img.src = dataUrl;

            var myWindow = window.open('', '', 'width=800,height=600');
            myWindow.document.write('<html><head><title>Print</title></head><body>');
            myWindow.document.write('<img src="' + dataUrl + '"/>');
            myWindow.document.write('</body></html>');
            myWindow.document.close();
            myWindow.focus();
            myWindow.print();
            myWindow.close();
        })
        .catch(function (error) {
            console.error('oops, something went wrong', error);
        });
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

@endsection





