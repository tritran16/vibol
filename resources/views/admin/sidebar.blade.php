<ul class="sidebar-menu" data-widget="tree">
    <li>
        <a href="{{ route('daily_advices.index') }}"><i class="fa fa-book"></i> <span>Daily Advice</span></a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-group"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="">
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-users"></i> Users
                </a>
            </li>
            <li class="">
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-pencil"></i> Roles
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-window-restore"></i> <span>Videos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('video_categories.index') }}">
                    <i class="fa fa-arrow-circle-down"></i> Video Category
                </a>
            </li>
            <li class="active">
                <a href="{{ route('videos.index') }}">
                    <i class="fa fa-list"></i> Videos
                </a>
            </li>

        </ul>
    </li>

    <li  class="treeview">
        <a href="#">
            <i class="fa fa-list"></i> <span>News</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="active">
                <a href="{{ route('news_categories.index') }}">
                    <i class="fa fa-object-group"></i> News Category
                </a>
            </li>
            <li>
                <a href="{{ route('news.index') }}">
                    <i class="fa fa-location-arrow"></i> News
                </a>
            </li>
        </ul>
    </li>

</ul>
