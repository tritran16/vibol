@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{__('common.page.about_us')}}</h2>
                    </div>
                </div>
                @include('admin.elements.flash')

                <div class="box box-primary" style="margin-top: 15px">
                    <!-- Messages -->
                    <div class="tab-content" style="margin-top: 15px">

                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <strong>{{__('common.page.about_us_content')}}</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <div class="form-group">
                                        {{ Form::textarea('content', request('content', $content), array('class' => 'form-control textarea disable', 'disabled' => true,'id' => 'content', 'rows' => 10)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                              &nbsp;
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <a class="btn btn-primary " href="{{ route('page.about_us.edit') }}">
                                    <i class="fa fa-pencil"></i> {{__('common.button.edit')}}
                                </a>
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