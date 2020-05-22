@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Edit Page - {{__('About Us')}}</h2>
                    </div>
                </div>


                <div class="box box-primary" style="margin-top: 15px">
                    <!-- Messages -->
                    <div class="tab-content" style="margin-top: 15px">
                        <form method="POST" action="{{route('page.about_us.save')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-2 col-xs-12 col-sm-12">
                                    <strong>@lang('Content')</strong>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-10">
                                    <div class="form-group">
                                        {{ Form::textarea('content', request('content', $content), array('class' => 'form-control textarea', 'id' => 'content', 'rows' => 10)) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-xs-12 col-sm-12">
                                  &nbsp;
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-10">
    {{--                                {{ Form::submit(__('common.button.update'), array('class' => 'btn btn-primary')) }}--}}
                                    <button type="submit" class="btn btn-primary">{{__('common.button.update')}}</button>
                                    <button type="button" class="btn btn-default" onclick="cancel()">{{__('common.button.cancel')}}</button>
                                </div>
                                <script type="text/javascript">
                                    function cancel() {
                                        location.href = "{{route('page.about_us')}}";
                                    }
                                </script>
                            </div>
                        </form>

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
