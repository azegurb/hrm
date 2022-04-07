<!DOCTYPE html>
<html class="no-js css-menubar" id="html" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="Orkhan A. | www.asan.gov.az">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title') | HRM System</title>

    <link rel="apple-touch-icon" href="{{asset('media/logo.png')}}">
    <link rel="shortcut icon" href="{{asset('core/assets/images/favicon.ico')}}">

    @include('components.head' , ['noCustomS' => !empty($noCustomS) ? $noCustomS : ''])

    @yield('links')

    <script>
        Breakpoints();
    </script>
</head>
<body class="animsition site-navbar-small page-aside-left">
    <!--[if lt IE 8]>
    <p class="browserupgrade"> İnternet bələdçisini yeniləyin <a href="http://browsehappy.com/">brouzeri yeniləmək üçün texniki xidmətə müraciət edin</a></p>
    <![endif]-->
    <!-- Header -->
    @include('components.header')

    <!-- Site menubar -->
    @include('components.menubar' , ['menus' => $menus])

    <!-- Page content -->
    <div class="page" data-plugin="formdata">
        @include('components.tree')
        @if(isset($sidebar) and !empty($sidebar))
            <div class="page-aside">
                <div class="page-aside-switch">
                    <i class="icon md-chevron-left" aria-hidden="true"></i>
                    <i class="icon md-chevron-right" aria-hidden="true"></i>
                </div>
                <div class="page-aside-inner">
                    <div data-role="container">
                            @include('components.sidebars.'.$sidebar , ['menus' => $menus,'data' => !empty($data) ? $data : ''])
                    </div>
                </div>
                <!---page-aside-inner-->
            </div>
        @endif
        <div class="page-main">
            <div class="page-content root-div-of-page loader_panel" style="padding:5px 5px 0;">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="page-main site-footer">
        <div class="site-footer-legal">© 2017 <a href="http://accounts.portofbaku.com"><b>TEST MMC/b></a></div></footer>
    <!-- Scripts -->
    @include('components.footer_script' , ['nopage' => !empty($nopage) ? true : false])

    @yield('scripts')
    {{-- Show Alerts--}}
    @include('components._alert')
    {{-- /Show Alerts --}}
    <script>
        (function(document, window, $) {
            'use strict';
            var Site = window.Site;
            $(document).ready(function() {
                Site.run();
            });
        })(document, window, jQuery);

    </script>
</body>
</html>