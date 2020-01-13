@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{__('Role detail')}}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="pull-left">
                            @can('edit role')
                                <a class="btn btn-sm btn-primary btn-flat" href="{{ route('roles.edit',$role->id) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endcan
                            @can('view role')
                                <a class="btn btn-sm btn-default btn-flat" href="{{ route('roles.index') }}">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="box box-primary" style="margin-top: 15px">
                    <!-- Messages -->
                    <div class="tab-content" style="margin-top: 15px">
                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <strong>@lang('Role')</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{ $role->name }}" readonly>
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
                                        @foreach($permissions as $value)
                                            <div class="col-md-3 col-xs-12">
                                                <label>
                                                    <input type="checkbox" disabled {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                    {{ $value->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
