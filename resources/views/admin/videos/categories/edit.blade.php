@extends('layouts.admin')

@section('content')
<h1>Edit Video Category</h1>

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
{{ Form::model($video_category, array('route' => array('video_categories.update', $video_category->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name') }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', $video_category->author), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', request('description', $video_category->description), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
<button class="btn btn-secondary" onclick="history.back()">Cancel</button>
{{ Form::close() }}

@endsection
