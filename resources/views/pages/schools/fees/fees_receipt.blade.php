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
                    <i><img style="height: 5rem;width: 5rem;"  src="{{Storage::url(getSchool()->setting->school_logo)}}" alt="logo"></i>
                    <br>
                    <span class="text-default-d3" style="font-size:1.5rem"><strong>School Name
                        {{-- {{$school_name}} --}}
                    </strong></span>
                    <br>
                    <span class="text-default-d3" style="font-size:1rem">

                       School Adresse
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
                        <strong>Fee Receipt</strong> :- 78678687<br>
                        <strong>Payment Date :- </strong> 12-12-2900: '-'}}
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-12 justify-content-end d-flex">
                <div class="text-black">
                    <p><strong><u>Student Details :- </u></strong><br>
                    <strong>Name</strong> :- Tourad Med lemin <br>
                    <strong>Session</strong> :- 2022<br>
                    <strong>Class</strong> :- First Classe A1<br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <table class="table" style="text-align: center;border: 1px">
                    <thead>
                        <tr>
                        <th scope="col" class="text-left">Sr no.</th>
                        <th scope="col" colspan="2" class="text-left">Fee Type</th>
                        <th scope="col" class="text-right">Amount</th>
                        </tr>
                    </thead>
                    {{-- @php
                        $no = 1;
                        $amount = 0;
                    @endphp --}}
                    <tbody>
                        {{-- @if($fees_paid->is_fully_paid)
                            @if(isset($paid_installment) && !empty($paid_installment->toArray()))
                                @foreach ($paid_installment as $data) --}}
                                    <tr>
                                        <th scope="row" class="text-left">1</th>
                                        <td colspan="2" class="text-left">Test<br><small>PAID ON :- 12-12-2000 </small></td>
                                        <td class="text-right">2000 DZ</td>
                                    </tr>
                                    {{-- @if($data->due_charges) --}}
                                        <tr>
                                            <th scope="row" class="text-left">1</th>
                                        <td colspan="2" class="text-left">Test<br><small>PAID ON :- 12-12-2000 </small></td>
                                        <td class="text-right">2000 DZ</td>
                                        </tr>
                                    {{-- @endif --}}
                                {{-- @endforeach --}}
                            {{-- @else
                                @if(isset($fees_class) && !empty($fees_class))
                                    @foreach ($fees_class as $data)
                                        <tr>
                                            <th scope="row" class="text-left">{{$no++}}</th>
                                            <td colspan="2" class="text-left">{{$data->fees_type->name}}
                                                @if($fees_paid->date)
                                                    <br><small>(PAID ON :- {{date('d-m-Y',strtotime($fees_paid->date))}}) </small></td>
                                                @endif
                                            <td class="text-right">{{$data->amount}} {{$currency_symbol}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif --}}
                        {{-- @else
                            @if(isset($paid_installment) && !empty($paid_installment->toArray()))
                                @foreach ($paid_installment as $data)
                                    <tr>
                                        <th scope="row" class="text-left">{{$no++}}</th>
                                        <td colspan="2" class="text-left">{{$data->installment_fee->name}}
                                            <br><small>(PAID ON :- {{date('d-m-Y',strtotime($data->date))}}) </small></td>
                                        <td class="text-right">{{$data->amount}} {{$currency_symbol}}</td>
                                    </tr>
                                    @if($data->due_charges)
                                        <tr>
                                            <th scope="row" class="text-left">{{$no++}}</th>
                                            <td colspan="2" class="text-left">Due Charges
                                                <br><small>{{$data->installment_fee->name}} :- </small></td>
                                            <td class="text-right">{{$data->due_charges}} {{$currency_symbol}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endif --}}
                        {{-- @foreach ($fees_choiceable as $data)
                            @if($data->is_due_charges == 0)
                                <tr>
                                    <th scope="row" class="text-left">{{$no++}}</th>
                                    <td colspan="2" class="text-left">{{$data->fees_type->name}}
                                        @if($data->date)
                                            <br><small>(PAID ON :- {{date('d-m-Y',strtotime($data->date))}}) </small></td>
                                        @endif
                                    <td class="text-right">{{$data->total_amount}} {{$currency_symbol}}</td>
                                </tr>
                            @else
                                <tr>
                                    <th scope="row" class="text-left">{{$no++}}</th>
                                    <td colspan="2" class="text-left">Due Charges ({{$session_year->fee_due_charges}} %)
                                        @if($data->date)
                                            <br><small>(PAID ON :- {{date('d-m-Y',strtotime($fees_paid->date))}}) </small></td>
                                        @endif
                                    <td class="text-right">{{$data->total_amount}} {{$currency_symbol}}</td>
                                </tr>
                            @endif
                        @endforeach --}}
                        <tr>
                            <th scope="row"></th>
                            <td colspan="2" class="text-left"><strong>Total Amount:-</strong></td>
                            <td class="text-right">798798789 Dz</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
