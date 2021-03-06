@extends('layouts.admin')

@section('content')
<h1>{{__('book.create.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\BooksController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('name', __('book.name.label')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail',  __('book.thumbnail.label')) }}
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
    </div>
    <div class="form-group">
        {{ Form::label('category_id',  __('book.category.label')) }} <span style="color: red">*</span>
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('author',  __('book.author.label')) }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('description',  __('book.description.label')) }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('link',  __('book.link.label')) }}
        {{ Form::text('link', request('link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('pdf_file', __('book.pdf_file.label')) }}
        {{ Form::file('pdf_file', ['accept' => "application/pdf"]) }}
    </div>

    <div class="form-group">
        {{ Form::label('page_number',  __('book.page_number.label')) }}
        {{ Form::text('page_number', request('page_number', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('status',  __('book.status.label')) }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot',  __('book.is_hot.label')) }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', false)) }}
    </div>
    {{ Form::submit(__('common.create.button'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
