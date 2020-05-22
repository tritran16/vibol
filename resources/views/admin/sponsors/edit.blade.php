@extends('layouts.admin')

@section('content')
<h1>{{__('sponsor.update.header')}}</h1>

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
{{ Form::model($sponsor, array('route' => array('sponsors.update', $sponsor->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{$sponsor->id}}" />
    <div class="form-group">
        {{ Form::label('name', __('sponsor.name')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('image',  __('sponsor.image')) }}
        {!! Form::file('image', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}

            <img src="{{ asset($sponsor->image) }}" style="width: 400px" />

    </div>
    <div class="form-group">

    </div>
    <div class="form-group">
        {{ Form::label('description', __('sponsor.description')) }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <button  type="button" class="btn btn-secondary" onclick="javascript:window.location.href = '{{route('sponsors.index')}}';">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection
