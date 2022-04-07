<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="Orkhan A. | www.asan.gov.az">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>@yield('title') | HRM System</title>

    <link rel="apple-touch-icon" href="{{asset('core/assets/images/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('core/assets/images/favicon.ico')}}">

    @include('errors.components.head')

    @yield('links')

    <script>
        Breakpoints();
    </script>
</head>
<body class="animsition page-error page-error-400 layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">Siz versiyasının vaxtı keçmiş brauzer istifadə edirsiniz. Xahiş edirik, <a href="http://browsehappy.com/">brouzeri yeniləmək üçün texniki xidmətə müraciət edin</a></p>
<![endif]-->

<!-- Page content -->

            @yield('content')

<!-- Scripts -->
@include('errors.components.scripts')

<script>
    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);
    $('.close-modal').on('click' , function(){
        $('.modal').modal('hide');
    })
</script>
</body>
</html>