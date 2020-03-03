@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('news.list')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('news.create') }}">
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
                            <th>{{__('news.title')}}</th>
                            <th>{{__('news.category.name')}}</th>
                            <th>{{__('news.status')}}</th>
                            <th>{{__('news.is_hot_news')}}</th>
                            <th>{{__('news.created_at')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($news as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <a href="{{route('news.show', $item->id)}}">
                                        <img src="{{asset($item->thumbnail)}}" width="50px"/> {{ $item->translate('kh')->title }}</a></td>
                                <td>{{$item->category->translate('kh')->name}}</td>
                                <td>@if ($item->status == 1)
                                        <label class="label label-primary" href="#">Publish</label>
                                    @elseif ($item->status == 2)
                                        <label class="label label-default" href="#">Un-publish</label>
                                    @else
                                        <label class="label label-info" href="#">New</label>
                                    @endif

                                </td>
                                <td>
                                    @if ($item->is_hot)
                                        <label class="label label-danger">Hot</label>
                                    @else
                                        <label class="label label-primary">No</label>
                                    @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if ($item->status != 1)
                                        <a type="button" class="btn btn-success" href="{{route('admin.news.active', $item->id)}}" onclick="confirm('Do you want publish this News?')">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('news.edit', $item->id) }}" title="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['news.destroy', $item->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('{{__('common.confirm_delete_item')}}')" title="delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $news->render() !!}
                </div>

            </div>
        </div>
    </section>
@endsection
