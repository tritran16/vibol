@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Daily Advices</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('daily_advices.create') }}">
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
                            <th>Content</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created </th>
                            <th>Updated </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($advices as $advice)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $advice->advice }}</td>
                                <td>{{ $advice->author }}</td>
                                <td>@if ($advice->status == 1)
                                        <label class="label label-primary" href="#">Active</label>
                                    @elseif ($advice->status == 2)
                                        <label class="label label-default" href="#">Un-Active</label>
                                    @else
                                        <label class="label label-info" href="#">New</label>
                                    @endif

                                </td>
                                <td>{{ $advice->created_at }}</td>
                                <td>{{ $advice->updated_at }}</td>
                                <td>
                                    @if ($advice->status != 1)
                                        <a type="button" class="btn btn-success" href="{{route('admin.daily_advices.active', $advice->id)}}" onclick="confirm('Do you want active this advice?')">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('daily_advices.edit', $advice->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['daily_advices.destroy', $advice->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Do you want remove this Daily Advice?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $advices->render() !!}
                </div>

            </div>
        </div>
    </section>
@endsection
