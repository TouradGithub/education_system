@extends('layouts.layout_pdf')
@section('page-content')

<div class="header-section">
    <h1>Results Report</h1>
    <p>Academic Year: 2024</p>
    <p>Section: Class A</p>
</div>
<div>
    {{-- @foreach ($student_promotions as $promotion) --}}
        <h4>Student: {{ $promotion->student->first_name.'  '. $promotion->student->last_name ?? 'N/A' }}</h4>
        <table class="pdf-table">
            <tr>
                <th>Subject</th>
                <th>{{ $trimester1->name }}</th>
                <th>{{ $trimester2->name }}</th>
                <th>{{ $trimester3->name }}</th>
            </tr>
            <tbody>
                @php
                    $exams_student = $exams->where('student_id', $promotion->student->id);
                    $subjects = $exams_student->pluck('subject')->unique();
                    $totalGrades = [];
                @endphp

                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->name ?? 'N/A' }} ({{ $subject->code ?? 'N/A' }})</td>
                        @php
                            $grade1 = $exams_student->where('subject_id', $subject->id)->where('trimester_id', $trimester1->id)->first()->grade ?? null;
                            $grade2 = $exams_student->where('subject_id', $subject->id)->where('trimester_id', $trimester2->id)->first()->grade ?? null;
                            $grade3 = $exams_student->where('subject_id', $subject->id)->where('trimester_id', $trimester3->id)->first()->grade ?? null;
                            $grades = array_filter([$grade1, $grade2, $grade3], fn($grade) => !is_null($grade));
                            $average = $grades ? array_sum($grades) / count($grades) : null;
                            $totalGrades = array_merge($totalGrades, $grades);
                        @endphp
                        <td>{{ $grade1 ?? 'N/A' }}</td>
                        <td>{{ $grade2 ?? 'N/A' }}</td>
                        <td>{{ $grade3 ?? 'N/A' }}</td>
                    </tr>
                @endforeach

                @php
                
                    $overallAverage = $totalGrades ? array_sum($totalGrades) / count($totalGrades) : null;
                @endphp

                <tr>
                    <td>Moyenne :</td>
                    <td colspan="3">{{ $overallAverage ? number_format($overallAverage, 2) : 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <br><br>

        <div>Decision : @if ($overallAverage>=10)
            Admin
            @else
            Ajourner
            @endif

        </div>
        <hr style="page-break-after: always;">
    {{-- @endforeach --}}
</div>

@endsection
