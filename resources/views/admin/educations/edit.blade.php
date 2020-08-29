@extends('layouts.admin')

@section('content')
<h1>{{__('education.update.header')}}</h1>

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
{{ Form::model($education, array('route' => array('educations.update', $education->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{$education->id}}" />
    <div class="form-group">
        {{ Form::label('name', __('education.name')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('title', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('link', __('education.link')) }}<span style="color: red">*</span>
        {{ Form::text('link', request('link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('image',  __('education.image')) }}<span style="color: red">*</span>
        {!! Form::file('image', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
        @if ($education->image)
            <br><span> {{ __('education.image')}} : </span>
            <img src="{{asset($education->image)}}" style="width: 200px"/>
        @endif
    </div>

    <div class="form-group">
        {{ Form::label('description', __('education.description')) }}<span style="color: red">*</span>
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <button type="button" class="btn btn-secondary" onclick="javascript:window.location.href = '{{route('educations.index')}}">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection


@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'description' );
    </script>
@endpush