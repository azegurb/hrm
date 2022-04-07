@extends('components.side_menubar')

@section('sidebar-list')
    <div id="side-navs" data-parent="Şəxsi Kartlar">
        @foreach($menus as $menu)
            @if($menu->id == 17)
                @foreach($menu->catalogs as $catalog)
                    <a class="list-group-item {{ $catalog->uri == null ? 'disabled' : '' }}" href="/{{$catalog->uri != null ? $catalog->uri : 'javascript:void(0)'}}"><i class="icon {{!empty($catalog->customCssClass) ? $catalog->customCssClass : 'md-file-text'}}" aria-hidden="true"></i>{{$catalog->title}}</a>
                @endforeach
            @endif
        @endforeach
        {{--<a class="list-group-item" href="{{ route('work-experience.index') }}"><i class="icon md-image" aria-hidden="true"></i>Əmək fəaliyyəti</a>--}}
        {{--<a class="list-group-item" href="{{ route('special-work-graphics.index') }}"><i class="icon md-volume-up" aria-hidden="true"></i>Xüsusi iş qrafiki</a>--}}
        {{--<a class="list-group-item" href="{{ route('contacts.index') }}"><i class="icon md-camera" aria-hidden="true"></i>Əlaqə vasitələri</a>--}}
        {{--<a class="list-group-item" href="{{ route('provision.index') }}"><i class="icon md-camera" aria-hidden="true"></i>Təminatlar</a>--}}
        {{--<a class="list-group-item" href="{{ route('permission.index') }}"><i class="icon md-file" aria-hidden="true"></i>İcazələr</a>--}}
        {{--<a class="list-group-item disabled" href="javascript:void(0)"><i class="icon md-link" aria-hidden="true"></i>Tapşırıqlar</a>--}}
        {{--<a class="list-group-item" href="{{ route('salary.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Maaş</a>--}}
        {{--<a class="list-group-item" href="{{ route('attestation.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Dövlət qulluğu keçməsi</a>--}}
        {{--<a class="list-group-item" href="{{ route('qualification-degree.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>İxtisas dərəcəsi / Xüsusi(hərbi/diplomatik)rütbə</a>--}}
        {{--<a class="list-group-item" href="{{ route('education.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Təhsili</a>--}}
        {{--<a class="list-group-item" href="{{ route('language.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Biliklər / Sertifikatlar</a>--}}
        {{--<a class="list-group-item" href="{{ route('academic-degree.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Elmi dərəcəsi və elmi adları</a>--}}
        {{--<a class="list-group-item" href="{{ route('reward-gov.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Dövlət təltifləri / Fərdi mükafatlar</a>--}}
        {{--<a class="list-group-item" href="{{ route('disciplinary.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>İntizam məsuliyyəti / Xidməti araşdırma</a>--}}
        {{--<a class="list-group-item" href="{{ route('work-attendance.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>İşə davamiyyət</a>--}}
        {{--<a class="list-group-item disabled" href="javascript:void(0)"><i class="icon md-file-text" aria-hidden="true"></i>Qiymətləndirmə</a>--}}
        {{--<a class="list-group-item" href="{{ route('training.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Təlim</a>--}}
        {{--<a class="list-group-item" href="{{ route('training-needs.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Təlim tələbatı</a>--}}
        {{--<a class="list-group-item" href="{{ route('business-trip.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Ezamiyyət</a>--}}
        {{--<a class="list-group-item" href="{{ route('vocation.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Məzuniyyət</a>--}}
        {{--<a class="list-group-item" href="{{ route('document.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Sənədlər</a>--}}
        {{--<a class="list-group-item" href="{{ route('family.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Ailə tərkibi</a>--}}
        {{--<a class="list-group-item" href="{{ route('note.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Xüsusi qeydlər</a>--}}
        {{--<a class="list-group-item" href="{{ route('sicklist.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Xəstəlik vərəqəsi</a>--}}
        {{--<a class="list-group-item" href="{{ route('other-info.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Digər məlumatlar</a>--}}
        {{--<a class="list-group-item" href="{{ route('salaryperson.index') }}"><i class="icon md-file-text" aria-hidden="true"></i>Maaş v2</a>--}}
    </div>
@endsection