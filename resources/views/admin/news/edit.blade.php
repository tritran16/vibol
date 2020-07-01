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
<style >
    .ck-editor__editable {
        min-height: 500px;
    }
</style>
{{ Form::model($news, array('route' => array('news.update', $news->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
{{--    <div class="form-group">--}}
{{--        {{ Form::label('title', 'Title') }}<span style="color: red">*</span>--}}
{{--        {{ Form::text('title', request('title', null), array('class' => 'form-control')) }}--}}
{{--    </div>--}}

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
                                {{ Form::label('title_kh', __('news.title_khmer') ) }}<span style="color: red">*</span>
                                {{ Form::text('title_kh', request('title_kh', $news->translate('kh')->title), array('class' => 'form-control', 'maxlength' => 190 )) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('short_desc_kh', __('news.short_description_khmer') ) }}<span style="color: red">*</span>
                                {{ Form::text('short_desc_kh', request('short_desc_kh', $news->translate('kh')->short_desc), array('class' => 'form-control', 'maxlength' => 1000)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content_kh', __('news.content_khmer')) }}<span style="color: red">*</span>
                                {{ Form::textarea('content_kh', request('content_kh', $news->translate('kh')->content), array('class' => 'form-control textarea', 'id' => 'content_kh', 'rows' => 10)) }}
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
                                {{ Form::text('title_en', request('title_en', $news->translate('en')->title), array('class' => 'form-control', 'maxlength' => 190)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('short_desc_en', __('news.short_description_en') ) }}<span style="color: red">*</span>
                                {{ Form::text('short_desc_en', request('short_desc_en', $news->translate('en')->short_desc), array('class' => 'form-control', 'maxlength' => 1000)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content_en', __('news.content_en')) }}<span style="color: red">*</span>
                                {{ Form::textarea('content_en', request('content_en', $news->translate('kh')->content), array('class' => 'form-control textarea', 'id' => 'content_en', 'rows' => 10)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-upload-image">
            Upload Image
        </button>
    </div>
    <div class="form-group">
        {{ Form::label('thumbnail', __('news.thumbnail')) }}<span style="color: red">*</span>
        {!! Form::file('thumbnail', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}
        <br />
        <img src="{{asset( $news->thumbnail)}}" width="100px">
    </div>
{{--    <div class="form-group">--}}
{{--        {{ Form::label('image', __('news.image')) }}--}}

{{--        {!! Form::file('image', ['accept' => "image/png, image/jpeg, image/jpg"]) !!}--}}
{{--        <br />--}}
{{--        <img src="{{asset($news->image)}}" width="200px">--}}
{{--    </div>--}}
    <div class="form-group">
        {{ Form::label('category_id', __('news.category.name')) }} <span style="color: red">*</span>
        {{ Form::select('category_id', $categories, request('category_id', $news->category_id), array('class' => 'form-control')) }}
    </div>

{{--    <div class="form-group">--}}
{{--        {{ Form::label('video_link',  __('news.video_link')) }}--}}
{{--        {{ Form::text('video_link', request('video_link', $news->video_link), array('class' => 'form-control')) }}--}}
{{--    </div>--}}

    <div class="form-group">
        {{ Form::label('author', __('news.author')) }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
{{--    <div class="form-group">--}}
{{--        {{ Form::label('short_desc', 'Short Description') }}<span style="color: red">*</span>--}}
{{--        {{ Form::text('short_desc', request('short_desc', null), array('class' => 'form-control')) }}--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        {{ Form::label('content', 'Content') }}--}}
{{--        {{ Form::textarea('content', request('content', null), array('class' => 'form-control', 'id' => 'content')) }}--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        {{ Form::label('published_date', 'Publish Date') }}<span style="color: red">*</span>--}}
{{--        {{ Form::text('published_date', request('published_date', null), array('class' => 'form-control date')) }}--}}

{{--    </div>--}}
    <div class="form-group">
        {{ Form::label('status', __('news.status')) }}
        {{ Form::select('status', [ 1 => __('news.status.publish'), 2 => __('news.status.un_publish')], request('status', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_hot', __('news.is_hot_news')) }}
        {{ Form::checkbox('is_hot', '1', request('is_hot', $news->is_hot)) }}
    </div>
    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}
<div class="modal fade" id="modal-upload-image">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="modal-title">Upload Image</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <form method="post" action="{{route('admin.news.upload_image')}}" enctype="multipart/form-data" id="frmUpload">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class='preview' style="display: none">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Upload Image Successful!
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-md-2">
                                {{ Form::label('Image URL',  __('Image URL')) }}
                            </div>
                            <div class="col-lg-10 col-xl-2 col-md-10">
                                <input id="url" class="form-control warning disabled"/>
                                <a class="btn btn-default pull-right" href="#" onclick="copyURL()" title="Copy all field From Khmer field">
                                    <i class="fa fa-clone"></i>
                                    {{__('Copy')}}
                                </a>
                            </div>


                        </div>
                        <div class="row ">
                            <img class="img-responsive center-block" src="" id="imgPreview" width="100" height="100" >
                        </div>
                    </div>
                    <div class="input-group">
                        <input class="form-control" type="file" id="img" name="img" accept = "image/png, image/jpeg, image/jpg"/>
                        <span class="input-group-btn">
                            <input type="button" class="btn btn-primary" value="Upload" id="btnUpload">
                        </span>
                    </div>

                </form>
                <p id="img_url"> </p>
                <script type="text/javascript">
                    function copyURL() {
                        var $temp = $("<input>");
                        $("body").append($temp);
                        $temp.val($('#url').val()).select();
                        document.execCommand("copy");
                        console.log('copy success');
                        $temp.remove();

                    }
                    $("#btnUpload").click(function() {
                        var fd = new FormData();
                        var files = $('#img')[0].files[0];
                        fd.append('image',files);
                        fd.append('_token', '{{csrf_token()}}');
                        $.ajax({
                            url: '{{route('admin.news.upload_image')}}',
                            type: 'POST',
                            data: fd,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function(response){

                                if(response != 0){
                                    $("#imgPreview").attr("src",response.url);
                                    $('#url').val(response.url);
                                    $(".preview").show(); // Display image element
                                }else{
                                    alert('file not uploaded');
                                }
                            },
                        });
                    });
                </script>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-outline-light" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $('.date').datepicker({
            dateFormat: 'yy/mm/dd',
            minDate: 0,
        });
        //CKEDITOR.replace( 'content_kh' );
        //CKEDITOR.replace( 'content_en' );
        tinymce.init({
            selector: 'textarea#content_kh',
            menubar: false,
            height: 500,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste imagetools wordcount",
                "media"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media",
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });

        tinymce.init({
            selector: 'textarea#content_en',
            menubar: false,
            height: 500,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste imagetools wordcount",
                "media"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media",
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });

        function copy(){
            $("input[name=title_en]").val($("input[name=title_kh]").val())
            $("input[name=short_desc_en]").val($("input[name=short_desc_kh]").val())
            // var content_kh = editor_kh.getData();
            // editor_en.setData(content_kh);
            var content_en = tinymce.get("content_kh").getContent();
            tinymce.get("content_en").setContent(content_en);
        }
    </script>
@endpush
