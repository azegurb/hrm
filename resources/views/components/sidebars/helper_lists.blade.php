@extends('components.side_menubar')

@section('sidebar-title', 'KÖMƏKÇİ SİYAHILAR')

@section('sidebar-list')
    <div id="side-navs" data-parent="Köməkçi Siyahılar">
        @foreach($menus as $menu)
            @if($menu->id == 56 && !empty($menu->catalogs))
                @foreach($menu->catalogs as $catalog)
                    <a class="list-group-item {{ $catalog->uri == null ? 'disabled' : '' }}" href="/{{$catalog->uri != null ? $catalog->uri : 'javascript:void(0)'}}"><i class="icon {{!empty($catalog->customCssClass) ? $catalog->customCssClass : 'md-file-text'}}" aria-hidden="true"></i>{{$catalog->title}}</a>
                @endforeach
            @endif
        @endforeach
    </div>
@endsection