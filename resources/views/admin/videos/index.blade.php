@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Videos</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('videos.create') }}">
                                <i class="fa fa-plus"></i> Create
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
                            <th>Title</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Is Hot</th>
                            <th>Created At</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($videos as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><a href="{{route('videos.show', $item->id)}}"><img src="{{asset($item->thumbnail)}}" width="50px"/>{{ $item->title }}</a></td>
                                <td><a target="_blank" href="{{$item->link}}">{{ $item->source }}</a></td>
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
                                    @if ($item->status != 1)
                                        <a type="button" class="btn btn-success" href="{{route('admin.videos.active', $item->id)}}" onclick="confirm('Do you want publish this advice?')">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('videos.edit', $item->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['videos.destroy', $item->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Do you want remove this videos?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $videos->render() !!}
                </div>

            </div>
        </div>
    </section>
@endsection
