@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('common.admin_account.list')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('admin_accounts.create') }}">
                                <i class="fa fa-plus"></i> {{__('common.button.create')}}
                            </a>
                        </div>
                    </div>
                </div>
                @include('admin.elements.flash')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('common.admin_account.name')}}</th>
                            <th>{{__('common.admin_account.account_id')}}</th>
                            <th>{{__('common.admin_account.account_name')}}</th>
                            <th>{{__('common.admin_account.account_status')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account_id }}</td>
                                <td><a target="{{$account->account_link?'_blank':''}}" href="{{url($account->account_link)?$account->account_link:'#'}}">{{ $account->account_name }}</a></td>
                                <td>
                                    @if ($account->status == 1)
                                        <label class="label label-primary" href="#">Active</label>
                                    @elseif ($account->status == 0)
                                        <label class="label label-default" href="#">Un-Active</label>
                                    @endif

                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('admin_accounts.edit', $account->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['admin_accounts.destroy', $account->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('{{__('common.confirm_delete_item')}}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
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
