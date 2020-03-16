@extends('layouts.admin')

@section('content')
<h1>{{__('common.system_page.create')}}</h1>

<!-- if there are creation errors, they will show here -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{ Form::open(array('action' => ['Admin\SystemPagesController@store'], 'method' => 'POST')) }}
    <div class="form-group">
        {{ Form::label('name', __('common.system_page.name')) }}<span style="color: red">*</span>
        {{ Form::select('name',  [ 'facebook' => 'Facebook'],
                request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('url', __('common.system_page.url')) }}
        {{ Form::text('url', request('account_link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status',  __('common.system_page.status')) }}
        {{ Form::select('status', [ 0 => 'Un-Active', 1 => 'Active'], request('status', null), array('class' => 'form-control')) }}
    </div>
    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('system_pages.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
