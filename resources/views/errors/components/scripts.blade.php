<!-- Core  -->
<script src="{{asset('/core/global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
<script src="{{asset('/core/global/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('/core/global/vendor/tether/tether.js')}}"></script>
<script src="{{asset('/core/global/vendor/bootstrap/bootstrap.js')}}"></script>
<script src="{{asset('/core/global/vendor/animsition/animsition.js')}}"></script>
<script src="{{asset('/core/global/vendor/mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('/core/global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
<script src="{{asset('/core/global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
<script src="{{asset('/core/global/vendor/ashoverscroll/jquery-asHoverScroll.js')}}"></script>
<script src="{{asset('/core/global/vendor/waves/waves.js')}}"></script>
<!-- Plugins -->
<script src="{{asset('/core/global/vendor/switchery/switchery.min.js')}}"></script>
<script src="{{asset('/core/global/vendor/intro-js/intro.js')}}"></script>
<script src="{{asset('/core/global/vendor/screenfull/screenfull.js')}}"></script>
<script src="{{asset('/core/global/vendor/slidepanel/jquery-slidePanel.js')}}"></script>
<!-- Scripts -->
<script src="{{asset('/core/global/js/State.js')}}"></script>
<script src="{{asset('/core/global/js/Component.js')}}"></script>
<script src="{{asset('/core/global/js/Plugin.js')}}"></script>
<script src="{{asset('/core/global/js/Base.js')}}"></script>
<script src="{{asset('/core/global/js/Config.js')}}"></script>
<script src="{{asset('/core/assets/js/Section/Menubar.js')}}"></script>
<script src="{{asset('/core/assets/js/Section/Sidebar.js')}}"></script>
<script src="{{asset('/core/assets/js/Section/PageAside.js')}}"></script>
<script src="{{asset('/core/assets/js/Plugin/menu.js')}}"></script>
<!-- Config -->
<script src="{{asset('/core/global/js/config/colors.js')}}"></script>
<script src="{{asset('/core/assets/js/config/tour.js')}}"></script>
<script>
    var setAssets = "{{url('core/assets')}}";
    Config.set('assets', setAssets);
</script>
<!-- Page -->
<script src="{{asset('/core/assets/js/Site.js')}}"></script>
<script src="{{asset('/core/global/js/Plugin/asscrollable.js')}}"></script>
<script src="{{asset('/core/global/js/Plugin/slidepanel.js')}}"></script>
<script src="{{asset('/core/global/js/Plugin/switchery.js')}}"></script>
<script>
    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);
</script>