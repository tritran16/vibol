@extends('layouts.admin')

@section('content')
<h1>Create Video</h1>

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
{{ Form::open(array('action' => ['Admin\VideosController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('title', 'Title') }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', 'Thumbnail Image') }}
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
    </div>
    <div class="form-group">
        {{ Form::label('category_id', 'Category') }} <span style="color: red">*</span>
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', request('description', null), array('class' => 'form-control', 'id' => 'desc')) }}
    </div>
    <div class="form-group">
        {{ Form::label('source', 'Source') }}
        {{ Form::select('source', ['youtube' => 'Youtube'], request('status', null), array('class' => 'form-control')) }}
        <p class="text-danger"><i class="fa fa-warning"></i> Only support youtube link!</p>
    </div>
    <div class="form-group">
        {{ Form::label('link', 'Link') }}
        {{ Form::text('link', request('link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('is_hot', 'Is Hot Video') }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', false)) }}
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> Cancel</a>
{{ Form::close() }}

@endsection

@push('scripts')
    <script type="text/javascript">
        //CKEDITOR.replace( 'desc' );
    </script>
@endpush
