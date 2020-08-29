@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{__('Daily Advice')}}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="pull-left">
                            <a class="btn btn-sm btn-default btn-flat" href="{{ route('daily_advices.index') }}">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="pull-right">
                            <a class="btn btn-sm btn-primary btn-flat" href="{{ route('daily_advices.edit',$daily_advice->id) }}">
                                <i class="fa fa-pencil"></i>
                            </a>

                        </div>
                    </div>

                </div>

                <div class="box box-primary" style="margin-top: 15px">
                    <!-- Messages -->
                    <div class="tab-content" style="margin-top: 15px">
                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <strong>@lang('Daily Advice')</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{ $daily_advice->advice }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <strong>@lang('Status')</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{ config('constants.daily_advices')[$daily_advice->status] }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 text-center">
                                @if ($daily_advice->status != 1)
                                    <a type="button" class="btn btn-primary" value="Active" href="#" onclick=""> </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
