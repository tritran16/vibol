@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('advice.header')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('daily_advices.create') }}">
                                <i class="fa fa-plus"></i> {{__('advice.create.button')}}
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
                            <th>{{__('advice.advice')}}</th>
                            <th>{{__('advice.type')}}</th>
                            <th>{{__('advice.image')}}</th>
                            <th>{{__('advice.status')}}</th>
                            <th>{{__('advice.created_at')}} </th>
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
                                <td>{{$advice->type == 1? 'Image' : 'Video'}} </td>
                                <td><img src="{{asset($advice->image)}}" style="width: 50px" /></td>
                                <td>@if ($advice->status == 1)
                                        <label class="label label-info" href="#">Active</label>
                                    @else
                                        <label class="label label-default" href="#">Un-active</label>
                                    @endif

                                </td>
                                <td>{{ $advice->updated_at }}</td>
                                <td>
{{--                                    @if ($advice->status != 1)--}}
{{--                                        <a type="button" class="btn btn-success" href="{{route('admin.daily_advices.active', $advice->id)}}" onclick="return confirm('Do you want active this advice?')">--}}
{{--                                            <i class="fa fa-check"></i> {{__('advice.active.button')}}--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
{{--                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('daily_advices.edit', $advice->id) }}">--}}
{{--                                        <i class="fa fa-pencil"></i>--}}
{{--                                    </a>--}}
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
