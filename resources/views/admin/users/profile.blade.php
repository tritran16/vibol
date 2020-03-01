@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('common.profile')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="#">
                                <i class="fa fa-edit"></i> {{__('common.button.edit')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-3 col-sm-6">

                        <div class="card hovercard">
                            <div class="cardheader">

                            </div>
                            <div class="avatar">
                                <img alt="" src="{{url('/images/default-user.png')}}" style="width: 100px;height: 100px">
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="info">
                                <div class="title center-block">
                                    <a target="_blank" href="#"><b>{{auth()->user()->name}} </b></a>
                                </div>
                                <div class="desc"><i class="fa fa-inbox"></i> <b>{{auth()->user()->email}}</b></div>
                                <div class="desc"><i class="fa fa-book"></i> <b>&nbsp;Administrator</b></div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="bottom">
                                <a class="btn btn-primary btn-twitter btn-sm" href="https://twitter.com/">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" rel="publisher"
                                   href="https://plus.google.com/">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                                <a class="btn btn-primary btn-sm" rel="publisher"
                                   href="https://facebook.com">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <div class="clearfix">&nbsp;</div>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                    </div>


            </div>
        </div>
    </section>
@endsection
