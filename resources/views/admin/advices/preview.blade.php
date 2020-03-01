@extends('layouts.admin')

@section('content')
<h1>{{__('advice.create.header')}}</h1>

{{ Form::open(array('action' => ['Admin\DailyAdvicesController@save'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <input type="hidden" name="advice" value="{{$advice['advice']}}">
    <input type="hidden" name="text_position" value="{{$advice['text_position']}}">
    <input type="hidden" name="status" value="{{$advice['status']}}">
    <div class="form-group">
        {{ Form::label('author', __('advice.author')) }}
        {{ Form::text('author', $advice['author']?$advice['author']:'N/A', array('class' => 'form-control', 'disabled' => true)) }}
        <input type="hidden" value="{{$advice['author']}}">
    </div>
    <div class="form-group">
        {{ Form::label('image', __('advice.image')) }}
        <img class="img-bordered" style="width: 200px" src="{{asset($advice['image'])}}">
        <input type="hidden" name="image" value="{{$advice['image']}}">
    </div>
    <div class="form-group">
        {{ Form::label('status', __('advice.status')) }}
        {{ Form::select('status', [0 =>  __('advice.status.new'), 1 =>  __('advice.status.active')], $advice['status'], array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    {{ Form::submit(__('common.button.confirm'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="#" onclick="javascript:history.back();"> {{__('common.button.back')}}</a>

@endsection
