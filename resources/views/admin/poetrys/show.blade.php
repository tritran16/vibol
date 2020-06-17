@extends('layouts.admin')

@section('content')
    <h1>Poetry</h1>
    {{ Form::model($poetry, array('route' => array('poetrys.update', $poetry->id), 'method' => 'PUT')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('title', 'Title') }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content', request('content', null), array('class' => 'form-control', 'disabled ' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('video_link', 'Video Link') }}
        {{ Form::text('video_link', null, array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'New', 1 => 'Public'], request('status', null), array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('poetrys.edit', $poetry->id) }}">
        <i class="fa fa-pencil"></i> Edit Poetry
    </a>
    <button class="btn btn-secondary" onclick="location.href='{{route('poetrys.index')}}'">Back</button>
    {{ Form::close() }}

@endsection

@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
    </script>
@endpush
