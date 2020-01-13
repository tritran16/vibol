@extends('layouts.admin')

@section('content')
<h1>Edit a Daily Advice</h1>

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
{{ Form::model($advice, array('route' => array('daily_advices.update', $advice->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', $advice->author), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('advice', 'Advice') }}
        {{ Form::textarea('advice', request('advice', $advice->advice), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', config('constants.daily_advices'), request('status', $advice->status), array('class' => 'form-control')) }}
    </div>
    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
<button class="btn btn-secondary" onclick="history.back()">Cancel</button>
{{ Form::close() }}

@endsection
