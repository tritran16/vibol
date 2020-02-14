@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Books</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('books.create') }}">
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
                            <th>Name</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($books as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><a href="{{route('books.show', $item->id)}}">{{ $item->name }}</a></td>
                                <td>
                                    <a target="_blank" href="{{$item->link?$item->link:asset('storage/books/pdf/'. $item->id . '/'.  $item->filename)}}">{{ $item->link?$item->link:$item->filename }}</a>
                                </td>
                                <td>@if ($item->status == 1)
                                        <label class="label label-primary" href="#">Active</label>
                                    @elseif ($item->status == 2)
                                        <label class="label label-default" href="#">Un-Active</label>
                                    @else
                                        <label class="label label-info" href="#">New</label>
                                    @endif

                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>

                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('books.edit', $item->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['books.destroy', $item->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Do you want remove this books?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $books->render() !!}
                </div>

            </div>
        </div>
    </section>
@endsection
