@extends('layouts.masters.school-master')


@section('content')
<div class="content-wrapper">
    {{-- <div class="page-header">
        <h3 class="page-title">
            {{ __('genirale.list').' '.__('sidebar.users') }}
        </h3>
    </div> --}}
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users Management</h2>
            </div>
            <div class="pull-right">
                @can('school-user-create')

                <a class="btn btn-success" href="{{ route('school.user.create') }}"> Create New User</a>
                @endcan
            </div>
        </div>
    </div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
@php
    $i=0;
@endphp
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                {{ __('genirale.list').' '.__('sidebar.users') }}
            </h4>
            @can('school-user-index')

<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($schoolUsers as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->roles))
        @foreach($user->roles as $v)
           <label class="badge badge-success">{{ $v->name }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-primary" href="{{route('school.user.edit',$user)}}">Edit</a>
        {{-- {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!} --}}
    </td>
  </tr>
 @endforeach
</table>


{!! $schoolUsers->render() !!}
@endcan


@endsection
