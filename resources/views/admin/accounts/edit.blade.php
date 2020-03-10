@extends('layouts.admin')

@section('content')
<h1>{{__('common.admin_account.update')}}</h1>

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
{{ Form::model($account, array('route' => array('admin_accounts.update', $account->id), 'method' => 'PUT')) }}
    <input type="hidden" name="id" value="{{$account->id}}"/>
    <div class="form-group">
        {{ Form::label('name', __('common.admin_account.name')) }}<span style="color: red">*</span>
        {{ Form::select('name', [ 'facebook' => 'Facebook', 'viber' => 'Viber', 'telegram' => 'Telegram', 'whatsapp' => 'WhatsApp'], request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('account_id', __('common.admin_account.account_id')) }}<span style="color: red">*</span>
        {{ Form::text('account_id', request('account_id', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('account_name', __('common.admin_account.account_name')) }}<span style="color: red">*</span>
        {{ Form::text('account_name', request('account_name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('account_link', __('common.admin_account.account_link')) }}
        {{ Form::text('account_link', request('account_link', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('status',  __('common.admin_account.account_status')) }}
        {{ Form::select('status', [ 0 => 'Un-Active', 1 => 'Active'], request('status', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
<button class="btn btn-secondary" onclick="history.back()">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection
