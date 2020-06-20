@extends('layouts.admin')

@section('content')
<h1>{{__('advice.create.confirm.header')}}</h1>

{{ Form::open(array('action' => ['Admin\DailyAdvicesController@save'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <input type="hidden" name="advice" value="{{$advice['advice']}}">
    <input type="hidden" name="text_position" value="{{$advice['text_position']}}">
    <input type="hidden" name="status" value="{{$advice['status']}}">


    <div class="form-group">
        {{ Form::label('type', __('advice.type')) }}
        {{ Form::select('type', [ 1 => 'Image & Text', 2 => 'Video'], request('type', null), array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('image', __('advice.image')) }}
        <img class="img-bordered" style="width: 200px" src="{{asset($advice['image'])}}">
        <input type="hidden" name="image" value="{{$advice['image']}}">
    </div>
<input type="hidden" name="type" value="{{$advice['type']}}">
    @if ($advice['type'] == 1)
        <div class="form-group">
            {{ Form::label('advice', __('advice.advice')) }}
            {{ Form::textarea('advice', request('advice', null), array('class' => 'form-control', 'id' => 'txtAdvice', 'disabled' => true)) }}
            <input type="hidden" name='advice' value="{{$advice['advice']}}">
        </div>

        <div class="form-group">
            {{ Form::label('text_position', __('advice.text_position')) }}
            {{ Form::select('text_position',
                [1 => 'Top Left', 2 => 'Top Center', 3 => 'Top Right',
                 4 => 'Middle Left', 5 => 'Middle Center', 6 => 'Middle Right',
                 7 => 'Bottom Left', 8 => 'Bottom Center', 9 => 'Bottom Right'
                ],
                 request('text_position', null), array('class' => 'form-control', 'disabled' => true)) }}

            <input type="hidden" name="text_position" value="{{$advice['text_position']}}">
        </div>

    @endif
    @if ($advice['type'] == 2)
        <video width="320" height="240" controls>
            <source src="{{url($advice['video'])}}" type="video/mp4">
        </video>
        <input type="hidden" name="video" value="{{url($advice['video'])}}">
    @endif

    <div class="form-group">
        {{ Form::label('status', __('advice.status')) }}
        {{ Form::select('status', [0 =>  __('advice.status.new'), 1 =>  __('advice.status.active')], $advice['status'], array('class' => 'form-control', 'disabled' => true)) }}
        <input type="hidden" name="status" value="{{$advice['status']}}">
    </div>
    {{ Form::submit(__('common.button.confirm'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="#" onclick="javascript:history.back();"> {{__('common.button.back')}}</a>

@endsection
