@extends('layouts.admin')

@section('content')
<h1>Create Video</h1>

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
{{ Form::open(array('action' => ['Admin\VideosController@store'], 'method' => 'POST')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('title', 'Title') }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_id', 'Category') }} <span style="color: red">*</span>
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('source', 'Source') }}
        {{ Form::text('source', request('source', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('link', 'Link') }}
        {{ Form::text('link', request('link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'New', 1 => 'Public'], request('status', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> Cancel</a>
{{ Form::close() }}

@endsection
