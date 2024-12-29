@extends('layouts.layout_pdf')
@section('page-content')

<div class="header-section">
    <h1> INSCRIPTION</h1>
</div>
<br><br><br>
<div>
    <h4>Student: {{ $promotion->student?->first_name . ' ' . $promotion->student?->last_name ?? 'N/A' }}</h4>

    <table class="pdf-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Father</th>
                <th>Class</th>
                <th>Gender</th>
                <th>Mobile</th>
                <th>Date of Birth</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $promotion->student?->first_name . ' ' . $promotion->student?->last_name ?? 'N/A' }}</td>
                <td>{{ $promotion->student?->parent?->father_first_name . ' ' . $promotion->student?->parent?->father_last_name ?? 'N/A' }}</td>
                <td>{{ $promotion->student?->section?->name ?? 'N/A' }}</td>
                <td>{{ $promotion->student?->gender ?? 'N/A' }}</td>
                <td>{{ $promotion->student?->parent?->father_mobile ?? 'N/A' }}</td>
                <td>{{ $promotion->student?->date_birth ?? 'N/A' }}</td>
                <td>{{ $promotion->fromSessionyear->name ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br><br>
</div>

@endsection
