@extends('layouts.admin')

@section('content')
    <h1>Update Book</h1>

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
    {{ Form::model($book, array('route' => array('books.update', $book->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('name', 'Name') }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', 'Thumbnail Image') }}
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
        <span class="error">(Only file type : image/png or image/jpeg;)</span>
        <br>
        <img src="{{asset($book->thumbnail)}}" class="img-bordered" style="width: 100px">
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
        {{ Form::label('link', 'Link') }}
        {{ Form::text('link', request('link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('pdf_file', 'PDF File') }}
        {{ Form::file('pdf_file', ['accept' => "application/pdf"]) }}
    </div>
    <div class="form-group">
        {{ Form::label('page_number', 'Page Number') }}
        {{ Form::number('page_number', request('page_number'), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot', 'Is Hot Book') }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', $book->is_hot)) }}
    </div>
    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> Cancel</a>
    {{ Form::close() }}

@endsection
