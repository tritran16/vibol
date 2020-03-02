@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('video.category.list')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('video_categories.create') }}">
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
                            <th>{{__('video.category.name')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($video_categories as $category)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $category->name }}</td>

                                <td>
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('video_categories.edit', $category->id) }}" title="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['video_categories.destroy', $category->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('{{__('common.confirm_delete_item')}}')" title="delete">
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
