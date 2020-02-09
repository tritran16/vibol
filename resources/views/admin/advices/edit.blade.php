@extends('layouts.admin')

@section('content')
<h1>Edit an Advice</h1>

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
{{ Form::model($advice, array('route' => array('daily_advices.update', $advice->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}

    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', $advice->author), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('advice', 'Advice') }}
        {{ Form::textarea('advice', request('advice', $advice->advice), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('image', 'Image') }}
        {{ Form::file('image', ['accept' => "image/png, image/jpeg;"]) }}
        <span class="error">(Only file type : image/png or image/jpeg;)</span>
        <img src="{{asset($advice->image)}}" class="img-bordered" style="width: 100px">
    </div>
    <div class="form-group">
        {{ Form::label('text_position', 'Text Position') }}
        {{ Form::select('text_position', [1 => 'Top', 2 => 'Middle', 3 => 'Bottom'], request('text_position', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', config('constants.daily_advices'), request('status', $advice->status), array('class' => 'form-control')) }}
    </div>
    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
<button class="btn btn-secondary" onclick="history.back()">Cancel</button>
{{ Form::close() }}

@endsection
