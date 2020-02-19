@extends('layouts.admin')

@section('content')
<h1>{{__('video.category.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\VideoCategoriesController@store'], 'method' => 'POST')) }}
    <div class="form-group">
        {{ Form::label('name',{{__('video.category.name')}}) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', __('video.category.description')) }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.create'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news_categories.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
