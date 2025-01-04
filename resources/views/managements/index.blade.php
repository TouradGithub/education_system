@extends('layouts.masters.master')

@section('title') {{__('role_management')}} @endsection

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
             Willaya
        </h3>
        <a class="btn btn-primary" href="{{ route('web.managements.create') }}">Creer Willaya</a>
    </div>
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                       <th>{{__('no')}}</th>
                       <th>{{__('name')}}</th>
                       <th>{{__('genirale.description')}}</th>
                       <th width="280px">{{__('action')}}</th>
                    </tr>
                      @foreach ($managements as $key => $management)
                      <tr>
                          <td>{{ ++$i }}</td>
                          <td>{{ $management->name }}</td>
                          <td>{{ $management->description }}</td>
                          <td>
                              <a class="btn btn-xs btn-gradient-info btn-rounded btn-icon" href="{{ route('web.managements.show',$management->id) }}"><i class="fa fa-eye"></i></a>
                              {{-- @can('management-edit') --}}
                                  <a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon" href="{{ route('web.admin.managements.edit',$management->id) }}"><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-xs btn-danger btn-rounded btn-icon" href="{{ route('web.admin.managements.delete',$management->id) }}"><i class="fa fa-trash"></i></a>
                              {{-- @endcan --}}
                                {{-- {!! Form::open(['method' => 'DELETE','route' => ['web.managements.destroy', $management->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!} --}}
                          </td>
                      </tr>
                      @endforeach
                  </table>


                  {!! $managements->render() !!}
              </div>
            </div>
          </div>
      </div>
</div>

@endsection
