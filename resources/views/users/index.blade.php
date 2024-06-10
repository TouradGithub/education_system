@extends('layouts.masters.master')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{__('genirale.create_new_user')}}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('web.users.create') }}">{{__('genirale.create_new_user')}}</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>{{__('genirale.no.')}}</th>
   <th>{{__('genirale.name')}}</th>
   <th>{{__('genirale.email')}}</th>
   <th>{{__('genirale.role')}}</th>
   <th width="280px">{{__('genirale.action')}}</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('web.users.show',$user->id) }}">{{__('genirale.show')}}</a>
       <a class="btn btn-primary" href="{{ route('web.users.edit',$user->id) }}">{{__('genirale.edit')}}</a>
        {!! Form::open(['method' => 'DELETE','route' => ['web.users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit(__('genirale.delete'), ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}


<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection
