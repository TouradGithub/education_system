<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            * { font-family: DejaVu Sans, sans-serif; }
        </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fees Receipt || {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <div class="text-center">
                    <i><img style="height: 5rem;width: 5rem;"  src="" alt="logo"></i>
                    <br>
                    <span class="text-default-d3" style="font-size:1.5rem"><strong>{{getSchool()->setting->school_name}}

                    </strong></span>
                    <br>
                    <span class="text-default-d3" style="font-size:1rem">

                        {{getSchool()->setting->school_address}}
                    </span>
                    <hr height="2px" width="100%" style="background-color: black">
                    <h4>
                        Fee Receipt
                    </h4>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-between">
            <div class="col-md-6 col-sm-12 col-12">
                <div class="text-grey-m2">
                    <p><strong><u>Invoice</u></strong><br>
                        <strong>Payment Date :- {{ now()->format('d-m-Y') }}</strong>
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-12 justify-content-end d-flex">
                <div class="text-black">
                    <p><strong><u>Student Details :- </u></strong><br>
                    <strong>Name</strong> :- {{$student->first_name.' '.$student->first_name}} <br>
                    <strong>Year Session</strong> :{{getYearNow()->name}}<br>
                    <strong>Class</strong> :- {{$className}}<br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <table class="table" style="text-align: center;border: 1px">
                    <thead>
                        <tr>
                        <th scope="col" class="text-left">Months </th>
                        <th scope="col" colspan="2" class="text-left">Date </th>
                        <th scope="col" class="text-right">Amount</th>
                        </tr>
                    </thead>
                    @php
                        $no = 1;
                        $amount = 0;
                    @endphp
                    <tbody>

                                @foreach ($fees as $data)
                                @php
                                    $amount += $data->amount;
                                @endphp

                                    <tr>
                                        <th scope="row" class="text-left">{{getMonth($data->month)}}</th>
                                        <td colspan="2" class="text-left"><br><small>PAID ON :-{{$data->date}} </small></td>
                                        <td class="text-right">{{$data->amount}} DZ</td>
                                    </tr>
                                @endforeach
                        <tr>
                            <th scope="row"></th>
                            <td colspan="2" class="text-left"><strong>Total Amount:-</strong></td>
                            <td class="text-right">{{ $amount}} Dz</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
