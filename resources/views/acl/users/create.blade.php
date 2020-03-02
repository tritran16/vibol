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
                            <h2>{{ __('Create user') }}</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-sm btn-default btn-flat"
                               href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> {{__('Back')}}</a>
                        </div>
                    </div>
                </div>

                @include('acl.flash_error')
                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}

                <div class="form-group">
                    {{ Form::label('name', __('User name')) }}
                    {{ Form::text('name', old('name'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email', __('User email')) }}
                    {{ Form::text('email', old('email'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password', __('Password')) }}
                    {{ Form::password('password', array('class' => 'form-control')) }}
                </div>
{{--                @if(!$roles->isEmpty())--}}
{{--                    {{ Form::label('name', 'Assign User to Roles') }}<br>--}}
{{--                    @foreach ($roles as $role)--}}
{{--                        {{ Form::checkbox('roles[]',  $role->id ) }}--}}
{{--                        {{ Form::label($role->name, ucfirst($role->name)) }}<br>--}}

{{--                    @endforeach--}}
{{--                @endif--}}
                <br>
                <button type="submit" class="btn btn-sm btn-success btn-flat">
                    <i class="fa fa-floppy-o"></i> @lang('Submit')
                </button>

                {{ Form::close() }}
            </div>
        </div>
    </section>

@endsection
