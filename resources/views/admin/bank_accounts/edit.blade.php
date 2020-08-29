@extends('layouts.admin')

@section('content')
<h1>{{__('bank_account.update.header')}}</h1>

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
{{ Form::model($bank_account, array('route' => array('bank_accounts.update', $bank_account->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{$bank_account->id}}" />
    <div class="form-group">
        {{ Form::label('name', __('bank_account.name')) }}<span style="color: red">*</span>
        {{ Form::text('name', request('name', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('account', __('bank_account.account')) }}<span style="color: red">*</span>
        {{ Form::text('account', request('account', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('owner', __('bank_account.owner')) }}<span style="color: red">*</span>
        {{ Form::text('owner', request('owner', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('logo', __('bank_account.logo')) }}<span style="color: red">*</span>
        {{ Form::file('logo', ['accept' => "image/png, image/jpeg, image/jpg"], array('class' => 'form-control')) }}
        @if ($bank_account->logo)
            <br><span> {{ __('bank_account.logo')}} : </span>
            <img src="{{asset( $bank_account->logo)}}" style="width: 200px"/>
        @endif
    </div>
    <div class="form-group">
        {{ Form::label('pdf_file', __('bank_account.pdf_file')) }}
        {{ Form::file('pdf_file', ['accept' => "application/pdf"]) }}

        @if ($bank_account->pdf_file)
        <br><span> File : </span>
        <a target="_blank" href="{{asset($bank_account->pdf_file)}}">{{basename($bank_account->pdf_file) }}</a>
        @endif
    </div>
    <div class="form-group">
        {{ Form::label('description_en', __('bank_account.description_en')) }}
        {{ Form::textarea('description_en', request('description_en', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('description_kh', __('bank_account.description_kh')) }}
        {{ Form::textarea('description_kh', request('description_en', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}
    <button type="button" class="btn btn-secondary" onclick="javascript:window.location.href = '{{route('bank_accounts.index')}}">{{__('common.button.cancel')}}</button>
{{ Form::close() }}

@endsection

@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'description_en' );
        CKEDITOR.replace( 'description_kh' );
    </script>
@endpush
