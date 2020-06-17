@extends('layouts.admin')

@section('content')
    <h1>{{__('book.view')}}</h1>

    {{ Form::model($book, array('route' => array('books.update', $book->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('name', __('book.name')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail',  __('book.thumbnail')) }}
        <img class="img-rounded" src="{{asset($book->thumbnail)}}" width="100px"/>
    </div>
    <div class="form-group">
        {{ Form::label('category_id',  __('book.category')) }} <span style="color: red">*</span>
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('author',  __('book.author')) }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('description',  __('book.description')) }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    @if ($book->video_link)
    <div class="form-group">
        {{ Form::label('video_link',  __('book.video_link')) }}
        {{ Form::text('video_link', request('video_link', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    @endif
    @if ($book->file_link)
    <div class="form-group">
        {{ Form::label('file_link',  __('book.file_link')) }}
        {{ Form::text('file_link', request('file_link', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    @endif
    <div class="form-group">
        {{ Form::label('page_number',  __('book.page_number')) }}
        {{ Form::text('page_number', request('page_number', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('status',  __('book.status')) }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control', 'disabled' =>true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot',  __('book.is_hot')) }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', false), ['class' => 'form-control', 'disabled' =>true]) }}
    </div>
    <a class="btn btn-primary" href="{{url('/admin/books/'. $book->id . '/edit')}}"> Edit</a>
    <a class="btn btn-default" href="{{route('books.index')}}"> Cancel</a>
    {{ Form::close() }}

@endsection
