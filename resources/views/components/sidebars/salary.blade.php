@extends('components.side_menubar')

@section('sidebar-title', 'Əmək haqqı')

@section('sidebar-list')

        <div id="side-navs" data-parent="Əmək haqqı">
            {{--div class="list-group-item dd-menu" href="#"><<i class="icon md-account-circle" aria-hidden="true"></i>Məzuniyyət hesablanması</div>--}}

            {{--<div class="ml-20 dd-content">--}}
                {{--<a class="list-group-item" href="{{ route('salary_vacation.index') }}"><i class="icon md-globe" aria-hidden="true"></i>Əməkhaqqı hesablanması</a>--}}

            {{--</div>--}}
            <a class="list-group-item" href="{{ route('privileges.index') }}"><i class="icon md-globe" aria-hidden="true"></i>Güzəştlər</a>
            <a class="list-group-item" href="{{ route('advance.index') }}"><i class="icon md-globe" aria-hidden="true"></i>Avanslar</a>


        </div>

@endsection