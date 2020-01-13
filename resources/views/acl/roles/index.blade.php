@extends('layouts.admin')

@section('content')
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{ __('Role list') }}</h2>
                        </div>
                        <div class="pull-right">
                            @can('create role')
                                <a class="btn btn-sm btn-success btn-flat" href="{{ route('roles.create') }}">
                                    <i class="fa fa-plus"></i> {{ __('Create')}}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- Messages -->
                @include('acl.flash_message')
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered">
                        <tr>
                            <th>{{__('No')}}</th>
                            <th>{{__('Role')}}</th>
                            <th width="280px">{{__('Operation')}}</th>
                        </tr>

                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can('view role')
                                        <a class="btn btn-sm btn-info btn-flat" href="{{ route('roles.show',$role->id) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endcan
                                    @can('edit role')
                                        <a class="btn btn-sm btn-primary btn-flat" href="{{ route('roles.edit',$role->id) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete role')
                                        @if(!in_array($role->id, \App\Models\User::getRolesNotDelete()))
                                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Do you want remove this role?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            {!! Form::close() !!}
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @if($roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {!! $roles->render() !!}
                    @endif
                </div>
            <!-- /.row -->
            </div>
        </div>
        <!-- /.box -->
    </section>
@endsection
