@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                @include('admin.elements.flash')
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{__('about.header')}}</h2>
                    </div>
                    <div class="pull-right">

                        <a class="btn btn-success btn-flat" href="{{ route('abouts.create') }}">
                            <i class="fa fa-plus"></i> {{__('about.create.button')}}
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('about.image')}}</th>
                            <th>{{__('about.video_link')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($abouts as $about)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <img src="{{asset($about->image)}}" style="width: 50px" />
                                </td>
                                <td><a href="{{$about->video_link}}" target="_blank">{{ $about->video_link }}</a></td>

                                <td>
                                    <a class="btn btn-sm btn-primary btn-flat" href="{{ route('abouts.edit', $about->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['abouts.destroy', $about->id],'style'=>'display:inline']) !!}
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

@push('scripts')
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
    </script>
@endpush