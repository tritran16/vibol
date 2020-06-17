@extends('layouts.admin')

@section('content')
    <h1>{{__('about.update.header')}}</h1>

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
    {{ Form::open(array('action' => ['Admin\AboutController@update', $about->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}

    <div class="form-group">
        {{ Form::label('image',  __('about.image')) }}
        {!! Form::file('image', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
    </div>

    <div class="form-group">
        {{ Form::label('content', __('about.content')) }}<span style="color: red">*</span>
        {{ Form::textarea('content', request('content', $about->content), array('class' => 'form-control textarea', 'id' => 'content', 'rows' => 10)) }}

    </div>
    <div class="form-group">
        {{ Form::label('video_link', __('about.video_link')) }}
        {{ Form::text('video_link', request('video_link', $about->video_link), array('class' => 'form-control')) }}
    </div>
    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('abouts.index')}}"> {{__('common.button.cancel')}}</a>
    {{ Form::close() }}

@endsection
