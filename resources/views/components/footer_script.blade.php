<!-- Core  -->
<script src="{{asset('core/global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
<script src="{{asset('core/global/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('core/global/vendor/tether/tether.js')}}"></script>
<script src="{{asset('core/global/vendor/bootstrap/bootstrap.js')}}"></script>
<script src="{{asset('core/global/vendor/animsition/animsition.js')}}"></script>
<script src="{{asset('core/global/vendor/mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('core/global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
<script src="{{asset('core/global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
<script src="{{asset('core/global/vendor/waves/waves.js')}}"></script>
<!-- Plugins -->


<script src="{{asset('core/global/vendor/switchery/switchery.min.js')}}"></script>
<script src="{{asset('core/global/vendor/intro-js/intro.js')}}"></script>
<script src="{{asset('core/global/vendor/screenfull/screenfull.js')}}"></script>
<script src="{{asset('core/global/vendor/slidepanel/jquery-slidePanel.js')}}"></script>
<script src="{{asset('core/global/vendor/clockpicker/jquery-clockpicker.js')}}"></script>
<!-- Scripts -->

<script src="{{asset('core/global/js/State.js')}}"></script>
<script src="{{asset('core/global/js/Component.js')}}"></script>
<script src="{{asset('core/global/js/Plugin.js')}}"></script>
<script src="{{asset('core/global/js/Base.js')}}"></script>
<script src="{{asset('core/global/js/Config.js')}}"></script>
<script src="{{asset('core/assets/js/Section/Menubar.js')}}"></script>
<script src="{{asset('core/assets/js/Section/Sidebar.js')}}"></script>
<script src="{{asset('core/assets/js/Section/PageAside.js')}}"></script>
<script src="{{asset('core/assets/js/Plugin/menu.js')}}"></script>

<script type="text/javascript" src="{{ asset('core/assets/js/jquery-mask.min.js') }}"></script>

<!-- Config -->
<script src="{{asset('core/global/js/config/colors.js')}}"></script>
<script src="{{asset('core/assets/js/config/tour.js')}}"></script>
<script>
    //Config.set('assets', '../../assets');
    var setAssets = "{{url('core/assets')}}";
    Config.set('assets', setAssets);
    var refered = "{{\URL::previous()}}"
</script>
<!-- Page -->
<script src="{{asset('core/assets/js/Site.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/asscrollable.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/slidepanel.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/switchery.js')}}"></script>
<!-- Load Pages -->
@if(empty($nopage) && !$nopage)
<script src="{{asset('js/custom/plugins/page-loader.js')}}"></script>
@endif
{{--Core--}}
<script src="{{asset('core/global/vendor/bootbox/bootbox.js')}}"></script>
<script src="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>
{{--Tree--}}
<script src="{{asset('core/global/vendor/bootstrap-treeview/bootstrap-treeview.min.js')}}"></script>
<script src="{{asset('core/global/vendor/jstree/jstree.min.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/bootstrap-treeview.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/jstree.js')}}"></script>
<script src="{{asset('core/assets/examples/js/advanced/treeview.js')}}"></script>


{{--Extends--}}
<script src="{{asset('core/global/js/Plugin/bootbox.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/bootstrap-sweetalert.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/toastr.js')}}"></script>
<script src="{{asset('core/assets/examples/js/advanced/bootbox-sweetalert.js')}}"></script>

<script type="text/javascript" src="{{asset('js/custom/plugins/external_plugins/pace.min.js')}}" ></script >
<script type="text/javascript" src="{{asset('js/custom/plugins/external_plugins/blockui.min.js')}}" ></script >
<script type="text/javascript" src="{{asset('js/custom/plugins/external_plugins/touchspin.min.js')}}" ></script >
<script type="text/javascript" src="{{asset('js/custom/plugins/external_plugins/components_loaders.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/external_plugins/moment.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/validator/validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/validator/messages_az.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/validator/initializer.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/page-row/page-generator.js')}}"></script>

<script type="text/javascript" src="{{asset('js/custom/plugins/filter/advanced-filtering.js')}}"></script>

<script src="{{asset('js/custom/plugins/delete.js')}}"></script>
<script src="{{asset('js/custom/plugins/formdata.js')}}"></script>
<script src="{{asset('js/custom/plugins/editData.js')}}"></script>
<script src="{{asset('js/custom/plugins/modal-on-close.js')}}"></script>
<script src="{{asset('js/custom/plugins/selectData.js')}}"></script>
<script src="{{asset('js/custom/plugins/pagination/paginate.js')}}"></script>
<script src="{{asset('js/custom/plugins/search.js')}}"></script>
<script src="{{asset('core/assets/examples/js/advanced/animation.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/tree/open-close.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/tree/treeinit.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom/plugins/breadcrump.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/custom/plugins/changeUserGroup.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/custom/plugins/generateNC.js')}}"></script>
