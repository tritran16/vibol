@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{__('notification.list')}}</h2>
                        </div>
                        <div class="pull-right">

                            <a class="btn btn-success btn-flat" href="{{ route('admin.notification.create') }}">
                                <i class="fa fa-plus"></i> {{__('notification.create.button')}}
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
                            <th>{{__('notification.item')}}</th>
                            <th>{{__('notification.type')}}</th>
                            <th>{{__('notification.date')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $i++ }}</td>

                                @php
                                    $link = '';
                                    if ($notification->notification_type == 'App\Models\News') {
                                        $link = url('admin/news/' . $notification->notification_id);
                                        $item = \App\Models\News::find($notification->notification_id);
                                        $item_name =  isset($item)?$item->translate('kh')->title:'';
                                    }
                                    elseif ($notification->notification_type == 'App\Models\Video') {
                                        $link = url('admin/videos/' . $notification->notification_id);
                                        $item = \App\Models\Video::find($notification->notification_id);
                                        $item_name = isset($item)? $item->title:'';
                                    }
                                    elseif ($notification->notification_type == 'App\Models\Book') {
                                        $link = url('admin/books/' . $notification->notification_id);
                                        $item = \App\Models\Book::find($notification->notification_id);
                                        $item_name =  isset($item)?$item->name: '';
                                    }
                                    else { // Advice
                                         $link = url('admin/daily_advices/');
                                         $item = \App\Models\DailyAdvice::find($notification->notification_id);
                                        $item_name =  __('advice.advice');
                                    }
                                @endphp
                                <td><a href="{{$link}}">{{ $item_name }}</a></td>
                                <td>{{ $notification->notification_type == "App\Models\News" ? __('common.menu.news') :
                                        ($notification->notification_type == "App\Models\Book" ? __('common.menu.books') :
                                            (
                                                $notification->notification_type == "App\Models\Video" ? __('common.menu.videos') :
                                            __('common.menu.advices')
                                            )
                                        )
                                }}</td>
                                <td>{{ $notification->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection
