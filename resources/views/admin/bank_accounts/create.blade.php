@extends('layouts.admin')

@section('content')
<h1>{{__('bank_account.create.header')}}</h1>

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
{{ Form::open(array('action' => ['Admin\BankAccountsController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
    
    
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
    </div>
    <div class="form-group">
        {{ Form::label('pdf_file', __('bank_account.pdf_file')). "(KH)" }}<span style="color: red">*</span>
        {{ Form::file('pdf_file', ['accept' => "application/pdf"]) }}
    </div>
    <div class="form-group">
        {{ Form::label('pdf_file_en', __('bank_account.pdf_file'). "(EN)") }}<span style="color: red">*</span>
        {{ Form::file('pdf_file_en', ['accept' => "application/pdf"]) }}
    </div>
    <div class="form-group">
        {{ Form::label('description_en', __('bank_account.description_en')) }}<span style="color: red">*</span>
        {{ Form::textarea('description_en', request('description_en', null), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('description_kh', __('bank_account.description_kh')) }}<span style="color: red">*</span>
        {{ Form::textarea('description_kh', request('description_en', null), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('bank_accounts.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection

@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'description_en' );
        CKEDITOR.replace( 'description_kh' );
    </script>
@endpush
