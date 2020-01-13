@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="pull-left">
                            <h2>{{__('Edit role')}}</h2>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <div class="pull-right">
                            <a class="btn btn-sm btn-default btn-flat" href="{{ route('roles.index') }}">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box box-primary">
                    <!-- Messages -->
                    @include('acl.flash_message')
                    @include('acl.flash_error')

                    <div style="margin: 20px">
                        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}

                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <strong>{{__('Role')}} <span class="text-danger">*</span></strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    {!! Form::text('name', null, array('placeholder' => __('Role name'), 'class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <strong>{{__('Permissions')}} <span class="text-danger">*</span></strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <div class="row">
                                        @foreach($permission as $value)
                                            <div class="col-md-3 col-xs-12">
                                                <label>
                                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                    {{ $value->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center" style="margin: 15px 0px;">
                                    <button type="submit" class="btn btn-sm btn-success btn-flat">
                                        <i class="fa fa-floppy-o"></i> {{__('Save')}}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
