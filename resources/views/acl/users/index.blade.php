@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('common.users')}}</h2>
                        </div>
                        <div class="pull-right">
                            @can('create user')
                                <a class="btn btn-success btn-flat" href="{{ route('users.create') }}">
                                    <i class="fa fa-plus"></i> Create
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                @include('acl.flash_message')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <td>#</td>
                            <th>{{__('common.username')}}</th>
                            <th>{{__('common.email')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}
                                    @if($user->id == auth()->user()->id)
                                        <label class="label label-primary" >It's me</label>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @can('edit user')
                                        <a class="btn btn-sm btn-primary btn-flat" href="{{ route('users.edit', $user->id) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete user')
                                        @if($user->id != auth()->user()->id)
                                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                                <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('{{__('common.confirm_delete_user')}}')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            {!! Form::close() !!}
                                        @else

                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $users->render() !!}
                </div>

            </div>
        </div>
    </section>
@endsection
