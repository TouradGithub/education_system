@extends('layouts.masters.master')

@section('title') {{__('role_management')}} @endsection

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
             {{__('role_management')}}
        </h3>
        <a class="btn btn-primary" href="{{ route('web.roles.create') }}"> {{ __('create_new_role') }}</a>
    </div>
    <div class="row grid-margin">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                       <th>{{__('no')}}</th>
                       <th>{{__('name')}}</th>
                       <th width="280px">{{__('action')}}</th>
                    </tr>
                      @foreach ($roles as $key => $role)
                      <tr>
                          <td>{{ ++$i }}</td>
                          <td>{{ $role->name }}</td>
                          <td>
                              <a class="btn btn-xs btn-gradient-info btn-rounded btn-icon" href="{{ route('web.roles.show',$role->id) }}"><i class="fa fa-eye"></i></a>
                              @can('role-edit')
                                  <a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon" href="{{ route('web.roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a>
                              @endcan
                          </td>
                      </tr>
                      @endforeach
                  </table>


                  {!! $roles->render() !!}
              </div>
            </div>
          </div>
      </div>
</div>

@endsection
