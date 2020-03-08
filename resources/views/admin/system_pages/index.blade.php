@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('common.system_page.list')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('system_pages.create') }}">
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
                            <th>{{__('common.system_page.name')}}</th>
                            <th>{{__('common.system_page.url')}}</th>
                            <th>{{__('common.system_page.status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $page->name }}</td>
                                <td>{{ $page->url }}</td>
                               <td>
                                    @if ($page->status == 1)
                                        <label class="label label-primary" href="#">Active</label>
                                    @elseif ($page->status == 0)
                                        <label class="label label-default" href="#">Un-Active</label>
                                    @endif

                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('system_pages.edit', $page->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['system_pages.destroy', $page->id],'style'=>'display:inline']) !!}
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
