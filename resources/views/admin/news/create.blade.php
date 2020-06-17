@extends('layouts.admin')

@section('content')
<h1>{{__('news.create.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\NewsController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active"><a class="nav-link active" href="#khmer" data-toggle="tab">Khmer</a></li>
                        <li class="nav-item"><a class="nav-link" href="#english" data-toggle="tab">English</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="khmer">
                            <div class="form-group">
                                {{ Form::label('title_kh',  __('news.title_khmer')) }}<span style="color: red">*</span>
                                {{ Form::text('title_kh', request('title_kh', null), array('class' => 'form-control', 'maxlength' => 190)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('short_desc_kh',  __('news.short_description_khmer')) }}<span style="color: red">*</span>
                                {{ Form::text('short_desc_kh', request('short_desc_kh', null), array('class' => 'form-control', 'maxlength' => 1000)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content_kh',  __('news.content_khmer')) }}<span style="color: red">*</span>
                                {{ Form::textarea('content_kh', request('content_kh', null), array('class' => 'form-control textarea', 'id' => 'content_kh', 'rows' => 10)) }}
                            </div>
                        </div>
                        <div class="tab-pane" id="english">
                            <div class="form-group">
                                <a class="btn btn-default pull-right" href="#" onclick="copy()" title="Copy all field From Khmer field">
                                    <i class="fa fa-clone"></i>
                                    {{__('Copy')}}
                                </a>
                            </div>

                            <div class="form-group">
                                {{ Form::label('title_en',  __('news.title_en')) }}<span style="color: red">*</span>
                                {{ Form::text('title_en', request('title_en', null), array('class' => 'form-control', 'maxlength' => 190)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('short_desc_en',  __('news.short_description_en')) }}<span style="color: red">*</span>
                                {{ Form::text('short_desc_en', request('short_desc_en', null), array('class' => 'form-control', 'maxlength' => 1000)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content_en',  __('news.content_en')) }}<span style="color: red">*</span>
                                {{ Form::textarea('content_en', request('content_en', null), array('class' => 'form-control textarea', 'id' => 'content_en', 'rows' => 10)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail',  __('news.thumbnail')) }}<span style="color: red">*</span>
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
    </div>

    <div class="form-group">
        {{ Form::label('image',  __('news.image')) }}
        {!! Form::file('image', ['accept' => "image/png, image/jpg, image/jpeg"]) !!}
    </div>
    <div class="form-group">
        {{ Form::label('category_id',  __('news.category.name')) }} <span style="color: red">*</span>
        {{ Form::select('category_id',$categories, request('category_id', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('video_link',  __('news.video_link')) }}
        {{ Form::text('video_link', request('video_link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('author',  __('news.author')) }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status',  __('news.status')) }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot', __('news.is_hot_news')) }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', false)) }}
    </div>
    {{ Form::submit( __('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
@push('scripts')
    <script type="text/javascript">
        $('.date').datepicker({
            dateFormat: 'yy/mm/dd',
            minDate: 0,
        });
        CKEDITOR.replace( 'content_kh' );
        CKEDITOR.replace( 'content_en' );

        function copy(){
            $("input[name=title_en]").val($("input[name=title_kh]").val())
            $("input[name=short_desc_en]").val($("input[name=short_desc_kh]").val())
            var content_kh = CKEDITOR.instances['content_kh'].getData();
            CKEDITOR.instances['content_en'].setData(content_kh);
        }
    </script>
@endpush
