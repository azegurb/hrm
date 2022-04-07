<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div class="row">
                <ul class="site-menu" data-plugin="menu" id="head-menu">
                    @foreach($menus as $menu)
                    <li class="site-menu-item">
                        <a target="{{$menu->uri == 'report' ? '_blank' : '_self'}}" href="{{$menu->uri != null ? '/'.$menu->uri : 'javascript:void(0)'}}">

                            <i class="site-menu-icon {{!empty($menu->customCssClass) ? $menu->customCssClass : 'md-file-text'}}" aria-hidden="true"></i>
                            <span class="site-menu-title">{{$menu->title}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>
<div class="page-header page-header-bordered pg-header" id="breadcrump-container">
    <ol class="breadcrumb" id="breadcrumb-ol">
        <li class="breadcrumb-item"><a onclick="clearUser()" class="mainpagechanger">Əsas səhifə</a></li>
    </ol>

</div>
