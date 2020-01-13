@extends('layouts.admin')

@section('content')
<h1>Edit News Category</h1>

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
{{ Form::model($news_category, array('route' => array('news_categories.update', $news_category->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name') }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', $news_category->author), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', request('description', $news_category->description), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
<button class="btn btn-secondary" onclick="history.back()">Cancel</button>
{{ Form::close() }}

@endsection
