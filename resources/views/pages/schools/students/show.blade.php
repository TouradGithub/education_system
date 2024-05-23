@extends('layouts.masters.school-master')
@php
   $grades= App\Models\Grade::find(getSchool()->grade_id);
   $classeEtud= App\Models\Classes::find($student->class_id);
   $classes=$grades->classes;
   $sections=$classeEtud->sections;
@endphp
@section('title')
Student Profile
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/student/css/demo.css') }}">
<link rel="stylesheet" href="{{ asset('assets/student/css/style.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
               Student Profile
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="card">


{{--
                        <header class="ScriptHeader">
                            <div class="rt-container">
                                <div class="col-rt-12">
                                    <div class="rt-heading">
                                        <h1>Student Profile Page Design Example</h1>
                                        <p>A responsive student profile page design.</p>
                                    </div>
                                </div>
                            </div>
                        </header> --}}

                        <section>
                            <div class="rt-container">
                                  <div class="col-rt-12">
                                      <div class="Scriptcontent">

                        <!-- Student Profile -->
                        <div class="student-profile py-4">
                          <div class="container">
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="card shadow-sm">
                                  <div class="card-header bg-transparent text-center">
                                    <img class="profile_img" src="{{$student->image==null? asset('section/assets/images/team/01.jpg'): url(Storage::url($student->image))}}" alt="student dp">
                                    <h3>{{$student->first_name.' '.$student->last_name}}</h3>
                                  </div>
                                  <div class="card-body">
                                    <p class="mb-0"><strong class="pr-1">Roll No:</strong>{{$student->roll_number}}</p>
                                    <p class="mb-0"><strong class="pr-1">Class:</strong>{{$student->section->classe->name??''}}</p>
                                    <p class="mb-0"><strong class="pr-1">Section:</strong>{{$student->section->name??''}}</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <div class=" ">
                                  <div class="card-header bg-transparent border-0">
                                    <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Student Information</h3>
                                  </div>
                                  <div class="card-body pt-0">
                                    <table class="table table-bordered">
                                      <tr>
                                        <th width="30%">Roll No</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->roll_number}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Academic Year	</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->sessionyear->name}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Gender</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->gender}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Date Of Birth</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->date_birth}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Blood Group	</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->blood_group}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Parent	</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->parent->father_first_name??''}} {{$student->parent->father_last_name??''}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">First Inscription	</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->created_at??''}} </td>
                                      </tr>

                                    </table>
                                  </div>
                                </div>
                                  <div style="height: 26px"></div>
                                <div class="">
                                  <div class="card-header bg-transparent border-0">
                                    <div class="dropdown"><button class="btn btn-xs btn-gradient-success btn-rounded btn-icon dropdown-toggle" type="button" data-toggle="dropdown">Actions</button><div class="dropdown-menu">
                                    <a class="btn btn-xs btn-gradient-info" href="{{route('school.student.genratePassword',$student->id)}}">Generate gradian password </a>
                                    </div></div>&nbsp;&nbsp;
                                    <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Gradian Information</h3>
                                  </div>
                                  <div class="card-body pt-0">
                                    <table class="table table-bordered">
                                      <tr>
                                        <th width="30%">Full Name</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->parent->father_first_name??''}} {{$student->parent->father_last_name??''}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Phone</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->parent->father_mobile??''}}</td>
                                      </tr>
                                      <tr>
                                        <th width="30%">Date Of Birth</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->parent->father_dob}}</td>
                                      </tr>

                                      <tr>
                                        <th width="30%">First Inscription	</th>
                                        <td width="2%">:</td>
                                        <td>{{$student->parent->created_at??''}} </td>
                                      </tr>

                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- partial -->

                                    </div>
                                </div>
                            </div>
                        </section>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script >

document.getElementById('class_section').addEventListener('change', function() {
    var gradeId = this.value;
    getSectionsByGrade(gradeId);
});
function getSectionsByGrade(gradeId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/getSection-list/' + gradeId, true);
    xhr.onload = function() {
        if (this.status === 200) {
            var sections = JSON.parse(this.responseText);
            var sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '';
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section.id;
                option.text = section.name;
                sectionSelect.appendChild(option);
            });
        }
    };
    xhr.send();
}

</script>
@endsection
