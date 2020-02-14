@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Advices</h2>
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
                            <th>Advice</th>
                            <th>Image</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Updated </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @if ($today_advice)
                        <tr style="background-color: #00d6b2">
                            <td></td>
                            <td>{{ $today_advice->advice }}</td>
                            <td><img src="{{asset( $today_advice->image)}}" class="img-bordered" style="width: 40px"></td>
                            <td>{{ $today_advice->author }}</td>
                            <td>Active</td>
                            <td>{{ $today_advice->updated_at }}</td>
                            <td></td>
                        </tr>
                        @else
                            <tr>
                                <td colspan="6">
                                    <span class="center-block">No Advice Today</span>
                                </td>
                            </tr>
                        @endif
                        @foreach ($advices as $advice)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $advice->advice }}</td>
                                <td><img src="{{asset( $advice->image)}}" class="img-bordered" style="width: 40px"></td>
                                <td>{{ $advice->author }}</td>
                                <td>@if ($advice->status == 1)
                                        <label class="label label-primary" href="#">Active</label>
                                    @elseif ($advice->status == 2)
                                        <label class="label label-default" href="#">Un-Active</label>
                                    @else
                                        <label class="label label-info" href="#">New</label>
                                    @endif

                                </td>
                                <td>{{ $advice->updated_at }}</td>
                                <td>
                                    @if ($advice->status != 1)
                                        <a type="button" class="btn btn-success" href="{{route('admin.daily_advices.active', $advice->id)}}" onclick="return confirm('Do you want active this advice?')">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('daily_advices.edit', $advice->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['daily_advices.destroy', $advice->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Do you want remove this Advice?')">
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
