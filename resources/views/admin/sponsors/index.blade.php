@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('sponsor.list')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('sponsors.create') }}">
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
                            <th>{{__('sponsor.name')}}</th>
                            <th>{{__('sponsor.image')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($sponsors as $sponsor)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $sponsor->name }}</td>
                                <td><img src="{{ asset($sponsor->image) }}" style="width: 200px" /></td>
                                <td>
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('sponsors.edit', $sponsor->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['sponsors.destroy', $sponsor->id],'style'=>'display:inline']) !!}
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
