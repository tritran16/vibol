<ul class="sidebar-menu" data-widget="tree">
    @can('view user')
        <li>
            <a href="{{ route('users.index') }}">
                <i class="fa fa-files-o"></i>
                <span>Users</span>
            </a>
        </li>
    @endcan
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>ACL</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @can('view permission')
                <li class="active">
                    <a href="{{ route('permissions.index') }}">
                        <i class="fa fa-circle-o"></i> Permission
                    </a>
                </li>
            @endcan
            @can('view role')
                <li>
                    <a href="{{ route('roles.index') }}">
                        <i class="fa fa-circle-o"></i> Role
                    </a>
                </li>
            @endcan
        </ul>
    </li>
</ul>