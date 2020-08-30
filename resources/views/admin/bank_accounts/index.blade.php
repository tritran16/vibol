@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('bank_account.list')}}</h2>
                        </div>
                        <div class="pull-right">

{{--                            <a class="btn btn-success btn-flat" href="{{ route('bank_accounts.create') }}">--}}
{{--                                <i class="fa fa-plus"></i> {{__('common.button.create')}}--}}
{{--                            </a>--}}
                        </div>
                    </div>
                </div>
                @include('admin.elements.flash')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('bank_account.name')}}</th>
                            <th>{{__('bank_account.account')}}</th>
                            <th>{{__('bank_account.owner')}}</th>
                            <th>{{__('bank_account.logo')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($bank_accounts as $bank_account)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $bank_account->name }}</td>
                                <td>{{ $bank_account->account }} </td>
                                <td>{{ $bank_account->owner }} </td>
                                <td><img src="{{ asset($bank_account->logo) }}" style="width: 200px" /></td>
                                <td>
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('bank_accounts.edit', $bank_account->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
{{--                                    {!! Form::open(['method' => 'DELETE','route' => ['bank_accounts.destroy', $bank_account->id],'style'=>'display:inline']) !!}--}}
{{--                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('{{__('common.confirm_delete_item')}}')">--}}
{{--                                        <i class="fa fa-trash"></i>--}}
{{--                                    </button>--}}
{{--                                    {!! Form::close() !!}--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection
