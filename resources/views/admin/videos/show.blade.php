@extends('layouts.admin')

@section('content')
    <h1>Video</h1>
    {{ Form::model($video, array('route' => array('videos.update', $video->id), 'method' => 'PUT')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('title', 'Title') }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('category_id', 'Category') }} <span style="color: red">*</span>
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('source', 'Source') }}
        {{ Form::text('source', request('source', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('link', 'Link') }}
        {{ Form::text('link', request('link', null), array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'New', 1 => 'Public'], request('status', null), array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('videos.edit', $video->id) }}">
        <i class="fa fa-pencil"></i> Edit Video
    </a>
    <button class="btn btn-secondary" onclick="history.back()">Cancel</button>
    {{ Form::close() }}

@endsection
