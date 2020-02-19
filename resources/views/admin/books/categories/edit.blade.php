@extends('layouts.admin')

@section('content')
<h1>{{__('book.category.update.header')}}</h1>

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
{{ Form::model($book_category, array('route' => array('book_categories.update', $book_category->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name',__('book.category.name')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', $book_category->author), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', __('book.category.description')) }}
        {{ Form::textarea('description', request('description', $book_category->description), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
<button class="btn btn-secondary" onclick="history.back()">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection
