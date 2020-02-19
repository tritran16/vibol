<ul class="sidebar-menu" data-widget="tree">
    <li>
        <a href="{{ route('daily_advices.index') }}"><i class="fa fa-book"></i> <span>{{__('common.menu.advices')}}</span></a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-group"></i> <span>{{__('common.menu.users')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="">
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-pencil"></i>  {{__('common.menu.users.roles')}}
                </a>
            </li>
            <li class="">
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-users"></i> {{__('common.menu.users.list_user')}}
                </a>
            </li>

        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-book"></i> <span> {{__('common.menu.books')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('book_categories.index') }}">
                    <i class="fa fa-arrow-circle-down"></i> {{__('common.menu.books.categories')}}
                </a>
            </li>
            <li >
                <a href="{{ route('books.index') }}">
                    <i class="fa fa-list"></i> {{__('common.menu.books.list_book')}}
                </a>
            </li>

        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-window-restore"></i> <span>{{__('common.menu.videos')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('video_categories.index') }}">
                    <i class="fa fa-arrow-circle-down"></i> {{__('common.menu.videos.categories')}}
                </a>
            </li>
            <li>
                <a href="{{ route('videos.index') }}">
                    <i class="fa fa-list"></i> {{__('common.menu.videos.list_video')}}
                </a>
            </li>

        </ul>
    </li>

    <li  class="treeview">
        <a href="#">
            <i class="fa fa-list"></i> <span>{{__('common.menu.news')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('news_categories.index') }}">
                    <i class="fa fa-object-group"></i> {{__('common.menu.news.categories')}}
                </a>
            </li>
            <li>
                <a href="{{ route('news.index') }}">
                    <i class="fa fa-location-arrow"></i> {{__('common.menu.news.list_news')}}
                </a>
            </li>
        </ul>
    </li>

</ul>
