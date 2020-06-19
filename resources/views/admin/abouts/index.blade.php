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
                        <a class="btn btn-primary " href="{{ route('abouts.edit', $about->id) }}">
                            <i class="fa fa-pencil"></i> {{__('common.button.edit')}}
                        </a>
                    </div>
                </div>


                <div class="box box-primary" style="margin-top: 15px">
                    <!-- Messages -->
                    <div class="tab-content" style="margin-top: 15px">
{{--                        <div class="form-group">--}}
{{--                            {{ Form::label('image',  __('about.image')) }}--}}
{{--                            <img class="img-rounded" src="{{asset($about->image)}}" width="200px"/>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            {{ Form::label('video_link',  __('about.video_link')) }}
                            {{ Form::text('video_link', $about->video_link, array('class' => 'form-control')) }}
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <strong>{{__('common.page.about_us_content')}}</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        {{ Form::textarea('content', request('content', $about->content), array('class' => 'form-control textarea disable', 'disabled' => true,'id' => 'content', 'rows' => 10)) }}
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            {{ Form::label('video_link',  __('about.video_link')) }}--}}
{{--                            {{ Form::text('video_link', $about->video_link, array('class' => 'form-control')) }}--}}
{{--                        </div>--}}

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-10">

                            </div>
                        </div>

                    </div>
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