<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<script>
        open = true;
        side = false;
</script>
<style>
    /*td { position: relative; }*/

    .isClosed td:not(:first-child){
        text-decoration:line-through;
        color: red
    }
</style>
<div class="panel-body pt-20">
    <div class="container-fluid">

        <div class="row">
            {{-- Filters --}}

            @include('components.filter-bar' , ['sid' => 'user-search','sname' => 'u-search' , 'pid' => 'users_paginate' , 'pname' => 'u-pagination'])
            {{-- /Filters --}}


            <table  class="table table-hover w-full" id="searchTable">
                <thead >
                <tr>
                    <th style="width: 2%">№</th>
                    <th style="width: 2%"></th>
                    <th>Soyadı</th>
                    <th>Adı</th>
                    <th>Atasının adı</th>
                    <th>Vəzifə</th>
                    <th><select name="current" id="currentA" style="width:200px; float: right" class="form-control"><option value="1">Bütün işçilər</option><option value="2">Cari işçilər</option><option value="3">Arxiv işçilər</option></select></th>
                </tr>
                </thead>
                <tbody align="left" id="users-tbody">
                @if(!empty($userlist) && $userlist->totalCount != '')
                    @foreach($userlist->data as $key => $value)
                        <tr id="{{$value->id}}">
                            <td onclick="getUser('{{$value->id}}')" data-toggle="tab" href="#panelTab2"
                                aria-controls="panelTab2" role="tab">{{++$key}}</td>
                            <td onclick="getUser('{{$value->id}}')" data-toggle="tab" href="#panelTab2"
                                aria-controls="panelTab2" role="tab">
                                <span class="avatar">
                                    <img class="img-rounded img-bordered img-bordered-primary personal-img"
                                         src="{{$value->photo != null ? 'data:image/png;base64,'.$value->photo : asset('media/noavatar.png')}}" alt="">
                                </span>
                            </td>
                            <td onclick="getUser('{{$value->id}}')" data-toggle="tab" href="#panelTab2"
                                aria-controls="panelTab2" role="tab">{{$value->lastName}}</td>
                            <td onclick="getUser('{{$value->id}}')" data-toggle="tab" href="#panelTab2"
                                aria-controls="panelTab2" role="tab">{{$value->firstName}}</td>
                            <td onclick="getUser('{{$value->id}}')" data-toggle="tab" href="#panelTab2"
                                aria-controls="panelTab2" role="tab">{{$value->patronymic}}</td>
                            <td onclick="getUser('{{$value->id}}')" data-toggle="tab" href="#panelTab2"
                                aria-controls="panelTab2" role="tab">{{$value->structureName.' '.$value->positionName}}</td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal('{{url('/get-user-by-id/'.$value->id.'/responseHttp')}}' , 'usersModal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , '{{route('users.destroy' , $value->id)}}' )" data-original-title="Sil">
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="alert alert-danger">Məlumat Yoxdur</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'users_paginate','url' => route('users.list' , 'json') , 'totalCount' => !empty($userlist) ? $userlist->totalCount : '','page' => $userlist->page])
            {{-- /Pagination load more button --}}
            <!-- Add button-->
            <div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{route('users.create')}}', 'usersModal')" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i>
                </button>
            </div>
            <!-- /Add button-->
        </div>
    </div>
</div>