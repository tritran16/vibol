@extends('layouts.admin')

@section('content')
<h1>{{__('advice.create.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\DailyAdvicesController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <div class="form-group">
        {{ Form::label('author', __('advice.author')) }}
        {{ Form::text('author', request('author', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('type', __('advice.type')) }}
        {{ Form::select('type', [ 1 => 'Image & Text', 2 => 'Video'], request('type', null), array('class' => 'form-control', 'onchange' => 'changeType(this)')) }}
    </div>
    <script type="text/javascript">
        function changeType(item) {
            console.log($(item).val());
            if ($(item).val() == 1) {
               $('#sec-video').hide();
               $('#sec-img').show();
            }
            else {
                $('#sec-video').show();
                $('#sec-img').hide();;
            }
        }
    </script>
    <div class="form-group">
        {{ Form::label('advice', __('advice.advice')) }}
        {{ Form::textarea('advice', request('advice', null), array('class' => 'form-control', 'id' => 'txtAdvice')) }}
    </div>

    <div class="form-group" id="sec-video" {{request('type') != 2  && old('type') != 2 ? 'style=display:none': ''}}>
        {{ Form::label('video', __('advice.video')) }}
        {{ Form::file('video', ['id' => 'video', 'accept' => "video/mp4,video/x-m4v,video/*"]) }}
        <span class="error">(Only video file)</span>

    </div>
    <section  id="sec-img" {{(request('type') == 2 || old('type') == 2 )? 'style=display:none': ''}}>
    <div class="form-group">
        {{ Form::label('image', __('advice.image')) }}
        {{ Form::file('image', ['id' => 'img', 'accept' => "image/jpeg"]) }}
        <span class="error">(Only file type : jpg)</span>

    </div>


    <div class="container">
        <img id="previewImage" src="#" alt="" style="width:100px; display: none" />
        <div class="top" id="textAdvice"></div>
    </div>

{{--    <div class="form-group">--}}
{{--        {{ Form::label('text_size', __('advice.text_size')) }}--}}
{{--        {{ Form::select('text_size', [--}}
{{--            8 => '8', 10 => '10', 12 => '12', 14 => '14', 16 => '16', 18 => '18', 20 => '20', 22 => '22', 24 => '24',--}}
{{--            26 => '26', 28 =>'28', 30 => '30', 32 => '32', 36 => '36', 40 => '40'--}}
{{--        ],request('text_size', 12), array('class' => 'form-control', 'id' => 'text-size')) }}--}}
{{--    </div><div class="form-group">--}}
{{--        {{ Form::label('text_size', __('advice.text_size')) }}--}}
{{--        {{ Form::select('text_size', [--}}
{{--            8 => '8', 10 => '10', 12 => '12', 14 => '14', 16 => '16', 18 => '18', 20 => '20', 22 => '22', 24 => '24',--}}
{{--            26 => '26', 28 =>'28', 30 => '30', 32 => '32', 36 => '36', 40 => '40'--}}
{{--        ],request('text_size', 12), array('class' => 'form-control', 'id' => 'text-size')) }}--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {{ Form::label('text_color', __('advice.text_color')) }}--}}
{{--        <div class="input-group">--}}
{{--            <span class="input-group-addon">#</span>--}}
{{--            {{ Form::text('text_color', request('text_color', null), array('class' => 'form-control', 'id' => 'text-color', 'autocomplete'=>"off")) }}--}}
{{--        </div>--}}
{{--    </div>--}}

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
    <div class="form-group">
        {{ Form::label('status', __('advice.status')) }}
        {{ Form::select('status', [0 =>  __('advice.status.new'), 1 =>  __('advice.status.active')], request('status', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('daily_advices.index')}}"> {{__('common.button.cancel')}}</a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="{{asset('/css/colorpicker.css')}}" />
<script type="text/javascript" src="{{asset('/js/colorpicker.js')}}"></script>
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
    $('#txtAdvice').on('change', function () {
        $('#text-advice').html(nl2br(advice));
    });
    $('#text-size').on('change', function () {
        $('#text-advice').css('font-size', $('#text-size').val() + 'px');
    });

    $('#text-color').ColorPicker({
        color: '#0022ff',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#text-color').val(hex);
            advice = $('#txtAdvice').val();
            if (advice) {
                console.log(advice);
                $('#text-advice').html(nl2br(advice));
                $('#text-advice').css('color', '#' + hex);
                $('#text-advice').css('font-size', $('#text-size').val() + 'px');
            }
        }
    });

    function nl2br (str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
</script>
{{ Form::close() }}

@endsection
