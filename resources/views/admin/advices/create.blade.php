@extends('layouts.admin')

@section('content')
<h1>Create Daily Advice</h1>

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
{{ Form::open(array('action' => ['Admin\DailyAdvicesController@store'], 'method' => 'POST')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('advice', 'Advice') }}
        {{ Form::textarea('advice', request('advice', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'New', 1 => 'Active'], request('status', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('daily_advices.index')}}"> Cancel</a>
{{ Form::close() }}

@endsection
