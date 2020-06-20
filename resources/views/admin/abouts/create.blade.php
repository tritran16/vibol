@extends('layouts.admin')

@section('content')
    <h1>{{__('about.create.header')}}</h1>

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
    {{ Form::open(array('action' => ['Admin\AboutController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}



    <div class="form-group">
        {{ Form::label('video_link', __('about.video_link')) }}<span style="color: red">*</span>
        {{ Form::text('video_link', request('video_link', null), array('class' => 'form-control')) }}
    </div>
    <input type="hidden" name="image" value="null">
    <div class="form-group">
        {{ Form::label('description', __('about.content')) }}<span style="color: red">*</span>
        {{ Form::textarea('content', request('content', null), array('class' => 'form-control textarea', 'id' => 'content', 'rows' => 10)) }}

    </div>
    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('abouts.index')}}"> {{__('common.button.cancel')}}</a>
    {{ Form::close() }}

@endsection
