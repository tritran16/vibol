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
                            <h2>Edit Role</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-sm btn-default btn-flat" href="{{ route('permissions.index') }}">
                                <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>

                @include('acl.flash_message')
                @include('acl.flash_error')
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}

                <div class="form-group">
                    {{ Form::label('name', 'Permission Name') }}
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    @if(!$roles->isEmpty())
                        {{ Form::label('name', 'Assign Permission to Roles') }}<br>
                        @foreach($roles as $value)
                            <label>{{ Form::checkbox('roles[]', $value->id, array_key_exists($value->id, $permissionRoles) ? true : false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                            <br/>
                        @endforeach
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success btn-flat">
                    <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                </button>

                {{ Form::close() }}
            </div>
        </div>
    </section>

@endsection
