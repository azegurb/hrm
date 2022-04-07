@extends('layouts.main_layout',['sidebar'=>'personal_cards'])

@section('title', !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı')

@section('page-title', '')
@section('links')
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-select/bootstrap-select.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/ladda/ladda.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/uikit/buttons.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{asset('js/custom/plugins/context/jquery.contextMenu.css')}}">
    <link rel="stylesheet" href="{{ asset('/core/global/vendor/switchery/switchery.css') }}">
    <script>
        var hasId = "{{$hasId}}";
        var route = "{{route('personal-cards.index')}}";
        var tree = {!! $tree !!}

    </script>
    <style>
        {{--.context-menu-list{--}}
            {{--position: absolute;--}}
            {{--list-style-type: none;--}}
            {{--background: #ededed;--}}
            {{--cursor: pointer;--}}
            {{--width:200px;--}}
            {{--border:1px solid black;--}}
            {{--border-radius: 3px;--}}
            {{--padding:0;--}}
        {{--}--}}
        {{--.context-menu-list li{--}}
            {{--padding:5px 10px;--}}
        {{--}--}}
        {{--.context-menu-list li:hover{--}}
            {{--background: #e1e1e1;--}}
        {{--}--}}
        li.jstree-open > a .jstree-icon, li.jstree-closed > a .jstree-icon {
            background: url(../core/global/vendor/jstree/city-hover.svg) no-repeat top left;
            background-size: 16px 16px;
        }
        li.jstree-leaf > a .jstree-icon {
            background: url(../core/global/vendor/jstree/building-org.svg) no-repeat top left;
            background-size: 16px 16px;
        }
    </style>
    <yield id="links"></yield>

@endsection

@section('content')
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        {{-- Tabs --}}
        <div class="panel-body panel-body-bg">
            <div class="tab-content" >
                @if(!empty($userlist))


                <div class="tab-pane active m-t-20" id="panelTab1" role="tabpanel">
                    {{--Table--}}
                    @include('pages.personal_cards.index.select' , ['userlist' => $userlist])
                    {{--/Table--}}
                </div>
                @endif
                <div class="tab-pane" id="panelTab2" role="tabpanel">
                    {{--Table--}}
                    @include('pages.personal_cards.index.user')
                    {{--/Table--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('components.modal-header' , ['id' => 'usersModal','mdlTitle' => 'Əməkdaş haqqında məlumatın daxil / redaktə edilməsi ekranı', 'mdlSize' => 'xl', 'mdUrl' => route('users.store'),'tb' => 'users-tbody' , 'custom' => 'postForm($(this) , "fetchUserId" , true)' , 'pid' => 'users_paginate'])
    @include('components.modal-footer')
    <!-- End Modal -->
    @include('pages.personal_cards.index.tree.modal')
    <div class="panel">
        <div class="panel-body pt-5">
            <div class="row">
                <yield id="content" style="width:100%;"></yield>
            </div>
        </div>
    </div>
    {{-- Plugins --}}
    <script src="{{ asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script src="{{ asset('js/custom/plugins/page-row/user-row.js')}}"></script>
    <script src="{{ asset('js/custom/plugins/page-row/user-by-tree.js')}}"></script>
@endsection

@section('scripts')
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/ascolorpicker.js')}}"></script>
    <script src="{{asset('core/global/vendor/clockpicker/bootstrap-clockpicker.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/datepair/datepair.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/datepair/jquery.datepair.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/datepair.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/clockpicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/jt-timepicker.js')}}"></script>
    {{-- Select2 --}}
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/select2.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/spin.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/ladda.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/ladda.js')}}"></script>

    <script src="{{asset('core/global/vendor/raty/jquery.raty.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/panel.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/raty.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/uikit/panel-structure.js')}}"></script>

    <script src="{{asset('js/custom/plugins/page-row/contacts-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/context/jquery.contextMenu.js')}}"></script>
    <script src="{{asset('js/custom/plugins/context/jquery.ui.position.js')}}"></script>

    <script src="{{asset('js/custom/pages/personal_cards/personal_cards.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/select-by-user-id.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/clearUser.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/advanced/animation.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/tree-operations.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/change-parent.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/userInfoToggler.js')}}"></script>
    <script src="{{ asset('/core/global/vendor/switchery/switchery.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".date_id").datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                weekStart: 1
            });

                var elem = document.querySelector('.js-switch-small');

                var init = new Switchery(elem , {size : 'small', color :'#3f51b5'});
        });
        actived();
        @if($hasId == 500)
            fill(`{!! $userInfo !!}`);

        @endif
        $('.root-div-of-page').find('#user-search').search('user-search','users_paginate');
        $('#structuresGet').selectObj('structuresGet' , '' , '' , true);
        $('#structuresType').selectObj('structuresType');
        $('.root-div-of-page').find('#users_paginate').pagination('load','users_paginate','user-search');
    </script>

    <yield id="scripts"></yield>
@endsection