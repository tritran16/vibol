<ul class="sidebar-menu" data-widget="tree">
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
                    <i class="fa fa-play-circle-o"></i> {{__('common.menu.videos.list_video')}}
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
                    <i class="fa fa-file-pdf-o"></i> {{__('common.menu.books.list_book')}}
                </a>
            </li>

        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-star"></i> <span>{{__('common.menu.poetry')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

            <li>
                <a href="{{ route('poetrys.index') }}">
                    <i class="fa fa-star-o"></i> {{__('common.menu.poetry')}}
                </a>
            </li>

        </ul>
    </li>

    <li>
        <a href="{{ route('daily_advices.index') }}"><i class="fa fa-book"></i> <span>{{__('common.menu.advices')}}</span></a>
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
                    <i class="fa fa-newspaper-o"></i> {{__('common.menu.news.list_news')}}
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('abouts.index') }}"><i class="fa fa-user-circle-o"></i> <span>{{__('common.menu.about')}}</span></a>
    </li>
    <li>
        <a href="{{ route('educations.index') }}">
            <i class="fa fa-sticky-note"></i> {{__('education.list')}}
        </a>
    </li>
    <li>
        <a href="{{ route('bank_accounts.index') }}">
            <i class="fa fa-bank"></i> {{__('bank_account.list')}}
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-cogs"></i> <span>{{__('common.menu.system')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu ">
            <li>
                <a href="{{ route('admin_accounts.index') }}">
                    <i class="fa fa-id-card-o"></i> {{__('common.admin_account.list')}}
                </a>
            </li>
            <li >

                <a href="{{ route('banners.index') }}">
                    <i class="fa fa-image"></i> {{__('common.banner.list')}}
                </a>
                <a href="{{ route('sponsors.index') }}">
                    <i class="fa fa-heart-o"></i> {{__('common.sponsor.list')}}
                </a>
            </li>
        </ul>
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
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-users"></i> {{__('common.menu.users.list_user')}}
                </a>
            </li>

        </ul>
    </li>

</ul>
