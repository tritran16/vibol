@extends('layouts.admin')

@section('content')
<h1>{{__('education.create.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\EducationsController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />

    <div class="form-group">
        {{ Form::label('name', __('education.name')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('link', __('education.link')) }}<span style="color: red">*</span>
        {{ Form::text('link', request('link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('image',  __('education.image')) }}
        {!! Form::file('image', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
    </div>

    <div class="form-group">
        {{ Form::label('description', __('education.description')) }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('educations.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection


@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'description' );
    </script>
@endpush