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
    {{ Form::label('advice', __('advice.advice')) }}
    {{ Form::textarea('advice', request('advice', null), array('class' => 'form-control', 'id' => 'txtAdvice')) }}
</div>
<div class="form-group">
    {{ Form::label('image', __('advice.image')) }}
    {{ Form::file('image', ['id' => 'img', 'accept' => "image/png, image/jpeg;"]) }}
    <span class="error">(Only file type : image/png or image/jpeg;)</span>

</div>
<div class="container">
    <img id="previewImage" src="{{asset($advice->image)}}" alt="" style="width:100px;" />
    <div class="top" id="textAdvice"></div>
</div>
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
    {{ Form::select('text_position', [1 => 'Top', 2 => 'Middle', 3 => 'Bottom'], request('text_position', null), array('class' => 'form-control')) }}
</div>
<div class="form-group">
    {{ Form::label('status',  __('advice.status')) }}
    {{ Form::select('status', [0 =>  __('advice.status.new'), 1 =>  __('advice.status.active')], request('status', null), array('class' => 'form-control')) }}
</div>

{{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
<a class="btn btn-default" href="{{route('daily_advices.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
