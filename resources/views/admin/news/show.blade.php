@extends('layouts.admin')

@section('content')
    <h1>{{__('news.view')}}</h1>

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
                                {{ Form::label('title_kh', 'Title (KH)') }}<span style="color: red">*</span>
                                {{ Form::text('title_kh', request('title_kh', $news->translate('kh')->title), array('class' => 'form-control', 'disabled' => true )) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('short_desc_kh', 'Short Description(KH)') }}<span style="color: red">*</span>
                                {{ Form::text('short_desc_kh', request('short_desc_kh', $news->translate('kh')->short_desc), array('class' => 'form-control', 'disabled' => true)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content_kh', 'Content (KH)') }}
                                {{ Form::textarea('content_kh', request('content_kh', $news->translate('kh')->content), array('class' => 'form-control textarea', 'disabled' => true, 'id' => 'content_kh', 'rows' => 10)) }}
                            </div>
                        </div>
                        <div class="tab-pane" id="english">
                            <div class="form-group">
                                {{ Form::label('title_en', 'Title (EN)') }}<span style="color: red">*</span>
                                {{ Form::text('title_en', request('title_en', $news->translate('en')->title), array('class' => 'form-control', 'disabled' => true)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('short_desc_en', 'Short Description(En)') }}<span style="color: red">*</span>
                                {{ Form::text('short_desc_en', request('short_desc_en', $news->translate('en')->short_desc), array('class' => 'form-control', 'disabled' => true)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content_en', 'Content (EN)') }}
                                {{ Form::textarea('content_en', request('content_en', $news->translate('kh')->content), array('class' => 'form-control textarea', 'disabled' => true, 'id' => 'content_en', 'rows' => 10)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', 'Thumbnail Image') }}
        <img src="{{asset( $news->thumbnail)}}" width="50px">
    </div>
    <div class="form-group">
        {{ Form::label('image', 'Image') }}

        <img src="{{asset($news->image)}}" width="100px">
    </div>
    <div class="form-group">
        {{ Form::label('category_id', 'Category') }} <span style="color: red">*</span>
        {{ Form::select('category_id', $categories, request('category_id', $news->category_id), array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('author', 'Author') }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control', 'disabled' => true)) }}
    </div>

    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [ 1 => 'Publish', 2 => 'Un-Publish'], request('status', null), array('class' => 'form-control', 'disabled' => true)) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot', 'Is Hot News') }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', false), ['class' => 'form-control', 'disabled' => true]) }}
    </div>
    <a class="btn btn-primary" href="{{route('news.update', $news->id)}}"> Edit</a>
    <a class="btn btn-default" href="{{route('news.index')}}"> Cancel</a>

@endsection

@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'content_kh' );
        CKEDITOR.replace( 'content_en' );
    </script>
@endpush
