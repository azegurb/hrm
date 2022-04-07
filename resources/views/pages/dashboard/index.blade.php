@extends('layouts.main_layout',['sidebar'=>'dashboard'])

@section('title', 'Lövhə')

@section('page-title', '')
@section('links')
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/apps/contacts.css')}}">
    <script>
        var hasId = false;
    </script>
    <style>
        .page-content{
            padding: 0px!important;
        }
    </style>
@endsection

@section('content')
    <!-- Contacts Content -->
    <div class="page-main">
        <!-- Contacts Content -->
        <div id="contactsContent" class="page-content page-content-table">
            <!-- Contacts -->
            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr">
                <thead>
                <tr>
                    <th class="per15" scope="col">Ad</th>
                    <th class="per15" scope="col">Soyad</th>
                    <th class="per15" scope="col">Ata adı</th>
                    <th class="per55" scope="col">İş yeri</th>
                </tr>
                </thead>
                <tbody>
                @if($data->totalCount > 1)
                @foreach($data->data as $value)
                <tr data-url="{{url('dashboard/user-info/'.$value->userId)}}" data-toggle="slidePanel">
                    <td>
                        <a class="avatar" href="javascript:void(0)">
                            <img class="img-fluid" src="{{asset('media/noavatar.png')}}" alt="...">
                        </a>
                        <span style="line-height: 40px">{{$value->firstName}}</span>
                    </td>
                    <td>{{$value->lastName}}</td>
                    <td>{{$value->patronymic}}</td>
                    <td>
                        {{$value->structureName.' '.$value->positionName}}
                    </td>
                </tr>
                @endforeach
                @else
                <tr align="center" class="m-0 p-0"><td class="alert alert-warning" style="border: 0px;" colspan="4">Məlumat yoxdur</td></tr>
                @endif
                </tbody>
            </table>
            <ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('core/global/js/Plugin/jt-timepicker.js')}}"></script>

    <script src="{{asset('core/global/vendor/raty/jquery.raty.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/panel.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/raty.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/uikit/panel-structure.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/advanced/animation.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/sticky-header.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/action-btn.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/editlist.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/aspaginator.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/animate-list.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/jquery-placeholder.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/material.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/selectable.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootbox.js')}}"></script>
    <script src="{{asset('core/assets/js/BaseApp.js')}}"></script>
    <script src="{{asset('core/assets/js/App/Contacts.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/apps/contacts.js')}}"></script>

    <script>

        $('#tree-container-show').hide();
    </script>
@endsection