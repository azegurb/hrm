<!-- Stylesheets -->
<link rel="stylesheet" href="{{asset('core/global/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('core/global/css/bootstrap-extend.min.css')}}">
<link rel="stylesheet" href="{{asset('core/assets/css/site.min.css')}}">
<!-- Plugins -->
<link rel="stylesheet" href="{{asset('core/global/vendor/animsition/animsition.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/asscrollable/asScrollable.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/switchery/switchery.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/intro-js/introjs.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/slidepanel/slidePanel.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/flag-icon-css/flag-icon.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/waves/waves.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/clockpicker/clockpicker.css')}}">
<!-- Fonts -->
<link rel="stylesheet" href="{{asset('core/global/fonts/font-awesome/font-awesome.css')}}">
<link rel="stylesheet" href="{{asset('core/global/fonts/material-design/material-design.min.css')}}">
<link rel="stylesheet" href="{{asset('core/global/fonts/glyphicons/glyphicons.css')}}">
<link rel="stylesheet" href="{{asset('core/global/fonts/brand-icons/brand-icons.min.css')}}">
<!-- Tree -->
<link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-treeview/bootstrap-treeview.css')}}">
<link rel="stylesheet" href="{{asset('core/global/vendor/jstree/jstree.min.css')}}">

{{--<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>--}}
{{--<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">--}}
<!--[if lt IE 9]>
<script src="{{asset('core/global/vendor/html5shiv/html5shiv.min.js')}}"></script>
<![endif]-->
<!--[if lt IE 10]>
<script src="{{asset('core/global/vendor/media-match/media.match.min.js')}}"></script>
<script src="{{asset('core/global/vendor/respond/respond.min.js')}}"></script>
<![endif]-->
<!-- Scripts -->
<script src="{{asset('core/global/vendor/breakpoints/breakpoints.js')}}"></script>
@if(empty($noCustomS))
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endif