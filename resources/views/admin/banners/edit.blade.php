@extends('layouts.admin')

@section('content')
<h1>{{__('banner.update.header')}}</h1>

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
{{ Form::model($banner, array('route' => array('banners.update', $banner->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{$banner->id}}" />
    <div class="form-group">
        {{ Form::label('type', __('banner.type')) }}<span style="color: red">*</span>
        {{ Form::select('type',$types, request('type', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('image',  __('banner.image')) }}
        {!! Form::file('image', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
    </div>
    <div class="form-group">
        {{ Form::label('title', __('banner.title')) }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('content', __('banner.content')) }}
        {{ Form::textarea('content', request('content', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <button type="button" class="btn btn-secondary" onclick="javascript:window.location.href = '{{route('banners.index')}}">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection
