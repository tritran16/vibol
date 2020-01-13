@extends('layouts.admin')

@section('content')
    <h1>News</h1>

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
    {{ Form::model($news, array('route' => array('news.update', $news->id), 'method' => 'PUT')) }}
    <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', request('title', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', 'Thumbnail Image') }}

        <img src="/images/thumb/{{$news->thumbnail}}" width="150px">
    </div>
    <div class="form-group">
        {{ Form::label('image', 'Image') }}

        <img src="/images/{{$news->image}}" width="200px">
    </div>
    <div class="form-group">
        {{ Form::label('category_id', 'Category') }}
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('short_desc', 'Short Description') }}
        {{ Form::text('short_desc', request('short_desc', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content', request('content', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('published_date', 'Publish Date') }}
        {{ Form::text('published_date', request('published_date', null), array('class' => 'form-control', 'disabled ' => true)) }}

    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'New', 1 => 'Publish'], request('status', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('news.edit', $news->id) }}">
        <i class="fa fa-pencil"></i> Edit News
    </a>
    <a class="btn btn-default" href="{{route('news.index')}}"> Back</a>
    {{ Form::close() }}

@endsection
