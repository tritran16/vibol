@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2><span>{{__('book.header')}}</span>
                                <a class="btn btn-success btn-flat" href="{{ route('books.create') }}">
                                    <i class="fa fa-plus"></i> {{__('common.button.create')}}
                                </a>
                            </h2>

                        </div>
                        <div class="pull-right">


                            {!! Form::open(['method' => 'GET', 'url' => '/admin/books', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                                <div class="input-group">

                                    {!! Form::select('category_id', array_merge([''=> __('book.categories.select')], $categories), isset($category_id) ? $category_id : '', ['class' => 'form-control', 'multiple' => false]) !!}
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" maxlength="255" name="keyword" placeholder="{{__('common.keyword')}}" value="{{Request::get('keyword') ? Request::get('keyword') : ''}}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>


                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
                @include('admin.elements.flash')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('book.name')}}</th>
                            <th>{{__('book.link')}}</th>
                            <th>{{__('book.category')}}</th>
                            <th>{{__('book.status')}}</th>
                            <th>{{__('book.is_hot')}}</th>
                            <th>{{__('book.created_at')}}</th>
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
                                <td>
                                    {{$item->category->name}}
                                </td>
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
                                <td>{{ substr($item->created_at, 0, 10) }}</td>
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
