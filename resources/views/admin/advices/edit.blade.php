@extends('layouts.admin')

@section('content')
<h1>{{__('advice.update.header')}}</h1>

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
{{ Form::model($advice, array('route' => array('daily_advices.update', $advice->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}

<input type="hidden" name="token" value="{{ csrf_token() }}" />
<div class="form-group">
    {{ Form::label('author', __('advice.author')) }}
    {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('type', __('advice.type')) }}
    {{ Form::select('type', [ 1 => 'Image & Text', 2 => 'Video'], request('type', null), array('class' => 'form-control')) }}
</div>
<section id="sec-video" {{$advice->type != 2   && old('type') != 2 ? 'style=display:none': ''}}>
    <div class="form-group" >
        {{ Form::label('video_file', __('advice.video_file')) }}
        {{ Form::file('video_file', ['id' => 'video', 'accept' => "video/mp4,video/x-m4v,video/*"]) }}
        <span class="error">(Only video file)</span>

    </div>
    <span> -- OR -- </span>
    <div class="form-group">
        {{ Form::label('video_link', __('advice.video_link')) }}
        {{ Form::text('video_link', request('video', null), array('class' => 'form-control')) }}
    </div>

</section>
<section  id="sec-img" {{($advice->type == 2  || old('type') == 2 )? 'style=display:none': ''}}>
    <div class="form-group">
        {{ Form::label('advice', __('advice.advice')) }}
        {{ Form::textarea('advice', request('advice', null), array('class' => 'form-control', 'id' => 'txtAdvice')) }}
    </div>
    <div class="form-group">
        {{ Form::label('image', __('advice.image')) }}
        {{ Form::file('image', ['id' => 'img', 'accept' => "image/jpeg"]) }}
        <span class="error">(Only file type : jpg)</span>

    </div>


    <div class="container">
        <img id="previewImage" src="#" alt="" style="width:100px; display: none" />
        <div class="top" id="textAdvice"></div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-md-10 text-center">
            <span id="text-advice" class="border"> </span>
        </div>

    </div>

    <div class="form-group">
        {{ Form::label('text_position', __('advice.text_position')) }}
        {{ Form::select('text_position',
            [1 => 'Top Left', 2 => 'Top Center', 3 => 'Top Right',
             4 => 'Middle Left', 5 => 'Middle Center', 6 => 'Middle Right',
             7 => 'Bottom Left', 8 => 'Bottom Center', 9 => 'Bottom Right'
            ],
             request('text_position', null), array('class' => 'form-control')) }}
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>
    .container {
        position: relative;
        text-align: center;
        color: red;
    }
    /* Bottom left text */
    .bottom {
        position: absolute;
        bottom: 8px;
        left: 50%;
    }

    /* Top left text */
    .top {
        position: absolute;
        top: 8px;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    /* Centered text */
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<script type="text/javascript">
    function preview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            //$('#textAdvice').html($('#txtAdvice').val());
            $('#previewImage').show();
        }
    }

    $("#img").change(function() {
        preview(this);
    });
</script>
<div class="form-group">
    {{ Form::label('text_position', __('advice.text_position')) }}
    {{ Form::select('text_position',
         [1 => 'Top Left', 2 => 'Top Center', 3 => 'Top Right',
             4 => 'Middle Left', 5 => 'Middle Center', 6 => 'Middle Right',
             7 => 'Bottom Left', 8 => 'Bottom Center', 9 => 'Bottom Right'
            ],
        request('text_position', null), array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('status',  __('advice.status')) }}
    {{ Form::select('status', [0 =>  __('advice.status.new'), 1 =>  __('advice.status.active')], request('status', null), array('class' => 'form-control')) }}
</div>

{{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
<a class="btn btn-default" href="{{route('daily_advices.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
