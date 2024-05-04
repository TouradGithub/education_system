<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'Arial', sans-serif; } /* Change the font family to one that supports Arabic */
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fees Receipt || {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    body {
            /* font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh; */
            position: relative;
    }
    .datefooter {
        margin-left: auto;
    }
    .footer{
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 50px; /* Set the height of your fixed element */
        text-align: center; Align content horizontally
        /* line-height: 50px; */
        align-items: center;
        display: flex;
            justify-content: space-between;
    }
</style>
</head>
@php
    $logo =Storage::url(getSchool()->setting->school_logo);
@endphp
<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <div class="text-center">
                    <i><img style="height: 5rem;width: 5rem;"  src="{{$logo}}" alt="logo"></i>
                    <br>
                    <span class="text-default-d3" style="font-size:1.5rem">
                        <strong>
                           {{getSchool()->setting->school_name}}
                        </strong>
                    </span>
                    <br>
                    <span class="text-default-d3" style="font-size:1rem">

                      {{getSchool()->setting->school_address}}
                    </span>
                    <hr height="2px" width="100%" style="background-color: black">
                    <h4>
                        Inscription
                    </h4>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-between">
            {{-- <div class="col-md-6 col-sm-12 col-12">
                <div class="text-grey-m2">
                    <p><strong><u>Invoice</u></strong><br>
                        <strong>Fee Receipt</strong> :- 78678687<br>
                        <strong>Payment Date :- </strong> 12-12-2900: '-'}}
                    </p>
                </div>
            </div> --}}

            <div class="col-md-6 col-sm-12 col-12 justify-content-end d-flex">
                <div class="text-black"><br><br><br>
                    <p><strong><u>Student Details :- </u></strong><br><br>
                    <strong>First Name</strong> : {{$student->first_name}} <br><br>
                    <strong>Last Name</strong>  :{{$student->last_name}}<br><br>
                    <strong>Class Room</strong> : {{$student->section->name.' -'.$student->section->classe->name}}<br><br>
                    <strong>Date Of Birht</strong> : {{$student->date_birth}}<br><br>
                    <strong>Year inscription</strong> : {{$student->sessionyear->name}}<br><br>
                </div>
            </div>
        </div>

    </div>
    @php
        use Illuminate\Support\Carbon;
    @endphp
    <div class="footer">
        <hr height="2px" width="100%" style="background-color: black">
                    <h6 class="datefooter">
                        {{$currentDateTime = Carbon::now()}}
                    </h6>
    </div>
</body>

</html>
