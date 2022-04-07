<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
            <i class="icon md-more" aria-hidden="true"></i>
        </button>
        <a class="navbar-brand navbar-brand-center" onclick="clearUser()" href="{{ url('/personal-cards') }}">
            <img class="navbar-brand-logo navbar-brand-logo-normal" style=" height: 60px;margin-top: -20px;" src="{{asset('media/logo.png')}}"
                    title="HRM System">
            <img class="navbar-brand-logo navbar-brand-logo-special" style=" height: 60px;margin-top: -20px;" src="{{asset('media/logo.png')}}"
                    title="HRM System">
            <span class="navbar-brand-text hidden-xs-down"></span>
        </a>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
                data-toggle="collapse">
            <span class="sr-only">Toggle Search</span>
            <i class="icon md-search" aria-hidden="true"></i>
        </button>
    </div>
    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar navbar-right">
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                    <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
                <li class="nav-item hidden-float">
                    <a style="display: none;" class="nav-link icon md-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
                            role="button">
                        <span class="sr-only">Toggle Search</span>
                    </a>
                </li>
            </ul>
            <!-- End Navbar Toolbar -->
            <span class="text-center"
            style="font-weight: bold;font-size: 20px;color: white;position: relative;top: 15px;">
                İNSAN RESURSLARININ QEYDİYYATI İNFORMASİYA SİSTEMİ
            </span>
            <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                       data-animation="scale-up" role="button">
                        <span class="pt-5">{{ !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı' }}</span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        @if(authUser() != null)
                            @foreach(authUser()->user_data->userGroupType as $position)
                                <a style="background:{{authUser()->login_params->user_type == $position->id ? 'lightgrey' : ''}}" class="dropdown-item user-group-change" href="javascript:void(0)" data-id="{{$position->id}}" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> {{$position->name}}</a>
                            @endforeach
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('/logout')}}" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Çıxış</a>
                    </div>
                </li>
            </ul>
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
            <form role="search">
                <div class="form-group">
                    <div class="input-search">
                        <i class="input-search-icon md-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" placeholder="Search...">
                        <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
                                data-toggle="collapse" aria-label="Close"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Site Navbar Seach -->
    </div>
</nav>