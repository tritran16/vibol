@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('poetry.header')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('poetrys.create') }}">
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
                            <th>{{__('poetry.title')}}</th>
                            <th>{{__('poetry.status')}}</th>
                            <th>{{__('poetry.is_hot')}}</th>
                            <th>{{__('poetry.create_at')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($poetrys as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><a href="{{route('poetrys.show', $item->id)}}"><img src="{{asset($item->thumbnail)}}" width="50px"/>{{ $item->title }}</a></td>

                                <td>@if ($item->status == 1)
                                        <label class="label label-primary" href="#">Active</label>
                                    @elseif ($item->status == 2)
                                        <label class="label label-default" href="#">Un-Active</label>
                                    @else
                                        <label class="label label-info" href="#">New</label>
                                    @endif

                                </td>
                                <td>
                                    @if ($item->is_hot)
                                        <label class="label label-danger">Hot</label>
                                    @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
{{--                                    @if ($item->status != 1)--}}
{{--                                        <a type="button" class="btn btn-success" href="{{route('admin.poetrys.active', $item->id)}}" onclick="confirm('{{__('poetry.confirm.publish.msg')}}')">--}}
{{--                                            <i class="fa fa-check"></i>--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('poetrys.edit', $item->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['poetrys.destroy', $item->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('{{__('poetry.confirm.delete.msg')}}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $poetrys->render() !!}
                </div>

            </div>
        </div>
    </section>
@endsection
