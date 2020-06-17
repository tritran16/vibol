@extends('layouts.admin')

@section('content')
<h1>{{__('poetry.update.header')}}</h1>

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
{{ Form::model($poetry, array('route' => array('poetrys.update', $poetry->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
<input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('title', __('poetry.title')) }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', __('poetry.thumbnail')) }}
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
        <br>
        <img src="{{asset( $poetry->thumbnail)}}" width="100px">
    </div>
  
    <div class="form-group">
        {{ Form::label('author', __('poetry.author')) }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('content', __('poetry.content')) }}
        {{ Form::textarea('content', request('content', null), array('class' => 'form-control', 'id' => 'content')) }}
    </div>

    <div class="form-group">
        {{ Form::label('video_link', __('poetry.video_link')) }}
        {{ Form::text('video_link', request('video_link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', __('poetry.status')) }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot', __('poetry.is_hot')) }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', $poetry->is_hot)) }}
    </div>
    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <button type="button" class="btn btn-secondary" onclick="history.back()">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection

@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
    </script>
@endpush
