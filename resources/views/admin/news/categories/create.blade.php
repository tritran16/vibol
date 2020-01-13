@extends('layouts.admin')

@section('content')
<h1>Create News Category</h1>

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
{{ Form::open(array('action' => ['Admin\NewsCategoriesController@store'], 'method' => 'POST')) }}
    <div class="form-group">
        {{ Form::label('name', 'New Category Name') }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news_categories.index')}}"> Cancel</a>
{{ Form::close() }}

@endsection
