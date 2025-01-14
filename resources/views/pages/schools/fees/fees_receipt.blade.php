@extends('layouts.layout_pdf')
@section('page-content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <div class="text-center">
                    <i><img style="height: 5rem;width: 5rem;" src="" alt="logo"></i>
                    <br>
                    <span class="text-default-d3" style="font-size:1.5rem"><strong>{{getSchool()->setting->school_name}}</strong></span>
                    <br>
                    <span class="text-default-d3" style="font-size:1rem">
                        {{getSchool()->setting->school_address}}
                    </span>
                    <hr height="2px" width="100%" style="background-color: black">
                    <h4>
                        Reçu de Paiement
                    </h4>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-between">
            <div class="col-md-6 col-sm-12 col-12">
                <div class="text-grey-m2">
                        <strong>Date  : {{ now()->format('d-m-Y') }}</strong>
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-12 justify-content-end d-flex">
                <div class="text-black">
                    <p><strong><u>Détails de l'Étudiant :</u></strong><br>
                    <strong>Nom</strong> : {{$student->first_name.' '.$student->last_name}} <br>
                    <strong>Année Scolaire</strong> : {{getYearNow()->name}}<br>
                    <strong>Classe</strong> : {{$className}}<br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <table class="pdf-table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-left">Mois</th>
                            <th scope="col" colspan="2" class="text-left">Date</th>
                            <th scope="col" class="text-right">Montant</th>
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
                                <td colspan="2" class="text-left"><br><small>{{$data->date}}</small></td>
                                <td class="text-right">{{$data->amount}} {{env('CURENCY')}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th scope="row"></th>
                            <td colspan="2" class="text-left"><strong>Montant Total :</strong></td>
                            <td class="text-right">{{ $amount }} {{env('CURENCY')}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
