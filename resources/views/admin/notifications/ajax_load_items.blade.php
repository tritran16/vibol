<div class="form-group" id="items">
    @if ($type == 2)

        {{ Form::label('notification_id',  __('notifications.item')) }} <span style="color: red">*</span>
        <select class="form-control" id="item_id" name="notification_id" onchange="loadContent()">
            <option value="">Select News</option>
            @foreach($items as $n)
                <option value="{{$n->id}}">{{$n->title}}</option>
            @endforeach
        </select>

    @elseif ($type == 3)
        {{ Form::label('notification_id',  __('video.title')) }} <span style="color: red">*</span>
        <select class="form-control" id="item_id" name="notification_id" onchange="loadContent()">
            <option value="">Select Video</option>
            @foreach($items as $n)
                <option value="{{$n->id}}">{{$n->title}}</option>
            @endforeach
        </select>
    @elseif ($type == 4)
        {{ Form::label('notification_id',  __('book.name')) }} <span style="color: red">*</span>
        <select class="form-control" id="item_id" name="notification_id" onchange="loadContent()">
            <option value="">Select Book</option>
            @foreach($items as $n)
                <option value="{{$n->id}}">{{$n->name}}</option>
            @endforeach
        </select>
    @endif
</div>