<header class="navbar navbar-default">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-bars fa-fw"></i>
            </a>
        </li>
        <!-- END Main Sidebar Toggle Button -->

    </ul>
    <!-- END Left Header Navigation -->

    <!-- Search Form -->
    @if(version_compare(config('cnv.current_version'), config('cnv.latest_version') , '<'))
        <div class="nav navbar-nav-custom">
            <p class="text-danger" style="margin: 14px 0;">
                <i class="fa fa-info-circle"></i>
                {{ trans('option::language.you_has_been_use_old_version') }}.
                <a href="{{ admin_url('option/update') }}">{{ trans('option::language.update_now') }}</a>
            </p>
        </div>
    @endif
    <!-- END Search Form -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <!-- User Dropdown -->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ $user->avatar }}" alt="avatar"> <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                <li class="dropdown-header text-center">{{ trans('user::language.account') }}</li>
                @if(!$user->is_super_admin && false)
                <li>
                    <a href="page_ready_user_profile.html">
                        <i class="fa fa-user fa-fw pull-right"></i>
                        {{ trans('user::language.profile') }}
                    </a>
                </li>
                <li class="divider"></li>
                @endif
                <li>
                    <a href="{{ route('auth.logout') }}">
                        <i class="fa fa-ban fa-fw pull-right"></i>
                        {{ trans('user::language.logout') }}
                    </a>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>
<!-- END Header -->
