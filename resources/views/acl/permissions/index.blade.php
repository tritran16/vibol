@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Available Permissions</h2>
                        </div>
                        <div class="pull-right">
                            @can('create permission')
                                <a class="btn btn-success btn-flat" href="{{ route('permissions.create') }}">
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
                            <td>No</td>
                            <th>Permissions</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @can('edit permission')
                                        <a class="btn btn-sm btn-primary btn-flat"
                                           href="{{ route('permissions.edit', $permission->id) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete permission')
                                        {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
                                        <button class="btn btn-danger btn-flat btn-sm"
                                                onclick="return confirm('Do you want remove this permission?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($permissions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {!! $permissions->render() !!}
                    @endif
                </div>

            </div>
        </div>
    </section>
@endsection
