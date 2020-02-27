@extends('layouts.admin')

@section('content')
<h1>{{__('notification.create.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\NotificationsController@store'], 'method' => 'POST')) }}
    <div class="form-group">
        {{ Form::label('notification_type',  __('notification.type')) }} <span style="color: red">*</span>
        {{ Form::select('notification_type', $types, request('notification_type', null),
            array('class' => 'form-control', 'id' => 'type')) }}
    </div>

    <div class="form-group" id="items">
        {{ Form::label('notification_id',  __('notification.item')) }} <span style="color: red">*</span>
        <select class="form-control" id="item_id" name="notification_id" onchange="loadContent()">
            <option value="">Select News</option>
            @foreach($news as $n)
                <option value="{{$n->id}}">{{$n->title}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {{ Form::label('title', __('notification.title')) }}<span style="color: red">*</span>
        {{ Form::text('title', request('title', null), array('class' => 'form-control', 'id' => 'title')) }}
    </div>

    <div class="form-group">
        {{ Form::label('body', __('notification.body')) }}<span style="color: red">*</span>
        {{ Form::textarea('body', request('body', null), array('class' => 'form-control', 'id' => 'content')) }}
    </div>

    {{ Form::submit(__('notification.create.button'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('admin.notification.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}
@endsection
@push('scripts')
    <script type="text/javascript">
        $('#type').change(function () {
            //alert($('#type').val());
            $.ajax({
                url: "<?php echo url('admin/notifications/load_list_item') ?>/" + $('#type').val(),
                method: 'GET',
                success : function(html) {
                   $('#items').html(html);
                }
            });
        });

        function loadContent() {
            $.ajax({
                url: "<?php echo url('admin/notifications/load_content') ?>/" + $('#item_id').val() + "/" + + $('#type').val(),
                method: 'GET',
                success : function(data) {
                    var jdata = $.parseJSON(data);
                    $('#title').val(jdata.title);
                    $('#content').val(jdata.content);
                }
            });
        }
    </script>
@endpush
