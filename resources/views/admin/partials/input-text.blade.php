<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    {{ Form::label($name, $title, ['class' => 'col-sm-3 control-label']) }}
    <div class="col-sm-9">
        {{ Form::$type($name, null, [
            'class' => 'form-control',
            'placeholder' => $title,
            'id' => $id ?? ''
            ])
        }}
        @if ($errors->has($name))
            <span class="help-block"><i class="fa fa-times-circle-o"></i> {{ $errors->first($name) }}</span>
        @endif
    </div>
</div>
