@extends('layouts.admin')

@section('content')
<h1>Edit a News</h1>

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
{{ Form::model($news, array('route' => array('news.update', $news->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <div class="form-group">
        {{ Form::label('title', 'Title') }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', 'Thumbnail Image') }}
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg;"]) !!}
        <img src="{{asset( $news->thumbnail)}}" width="50px">
    </div>
    <div class="form-group">
        {{ Form::label('image', 'Image') }}

        {!! Form::file('image', ['accept' => "image/png, image/jpeg;"]) !!}

        <img src="{{asset($news->image)}}" width="50px">
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
        {{ Form::label('short_desc', 'Short Description') }}<span style="color: red">*</span>
        {{ Form::text('short_desc', request('short_desc', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea('content', request('content', null), array('class' => 'form-control', 'id' => 'content')) }}
    </div>
{{--    <div class="form-group">--}}
{{--        {{ Form::label('published_date', 'Publish Date') }}<span style="color: red">*</span>--}}
{{--        {{ Form::text('published_date', request('published_date', null), array('class' => 'form-control date')) }}--}}

{{--    </div>--}}
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'New', 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control')) }}
    </div>
    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> Cancel</a>
{{ Form::close() }}

@endsection

@push('scripts')
    <script type="text/javascript">
        $('.date').datepicker({
            dateFormat: 'yy/mm/dd',
            minDate: 0,
        });
        CKEDITOR.replace( 'content' );
    </script>
@endpush
