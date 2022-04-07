<section id="links">

</section>
<section id="content">
        <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
            <div style="padding-bottom:0px" class="panel-body pt-20">
                <div class="tab-content">
                    {{--Filters--}}
                        @include('components.filter-bar' , ['sid' => 'family-search','sname' => 'tr-search' , 'pid' => 'family_paginate' , 'pname' => 'tr-pagination'])
                    {{--/Filters--}}

                    {{--@if(count($new) > 0)--}}
                        {{--<table class="table">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th class="table-width-5">№</th>--}}
                                {{--<th>Qohumluğun dərəcəsi</th>--}}
                                {{--<th>Adı</th>--}}
                                {{--<th>Soyadı</th>--}}
                                {{--<th>Atasının adı</th>--}}
                                {{--<th class="table-width-10">Doğulduğu tarix</th>--}}
                                {{--<th>Doğulduğu yer</th>--}}
                                {{--<th>İş yeri və vəzifəsi</th>--}}
                                {{--<th>Yaşadığı ünvan</th>--}}
                                {{--<th class="table-width-8"></th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@foreach($new as $newNC)--}}
                                {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listFamilyRelationTypesId.name','name', 'surname', 'middlename', 'birthDate', 'placeOfBirth', 'position', 'placeOfLive']])--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}

                    {{--@endif--}}

                    <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                        <thead>
                        <tr style="font-size: 15px">
                            <th class="table-width-5">№</th>
                            <th>Qohumluğun dərəcəsi</th>
                            <th>Adı</th>
                            <th>Soyadı</th>
                            <th>Atasının adı</th>
                            <th class="table-width-10">Doğulduğu tarix</th>
                            <th>Doğulduğu yer</th>
                            <th>İş yeri və vəzifəsi</th>
                            <th>Yaşadığı ünvan</th>
                            <th class="table-width-8"></th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@if(count($new) > 0)--}}
                            {{--@foreach($new as $newNC)--}}
                                {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listFamilyRelationTypesId.name','name', 'surname', 'middlename', 'birthDate', 'placeOfBirth', 'position', 'placeOfLive']])--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                        @if($data->totalCount > 0)
                            @foreach($data->data as $key=>$familyInfo)
                                <tr id="{{ $familyInfo->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $familyInfo->listFamilyRelationTypesId->name }}</td>
                                    <td>{{ $familyInfo->name }}</td>
                                    <td>{{ $familyInfo->surname }}</td>
                                    <td>{{ $familyInfo->middlename }}</td>
                                    <td>{{ date('d.m.Y', strtotime($familyInfo->birthDate)) }}</td>
                                    <td>{{ $familyInfo->placeOfBirth }}</td>
                                    <td>{{ $familyInfo->position }}</td>
                                    <td>{{ $familyInfo->placeOfLive }}</td>
                                    <td class="text-nowrap text-right">
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('family.edit' , $familyInfo->id)}}' , 'family-modal')">
                                            <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                        </div>
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('family.destroy' , $familyInfo->id)}}" )'>
                                            <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                        </div>
                                    </td>
                                </tr>
                                {{--@if(!is_null($value->nc))--}}
                                    {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listFamilyRelationTypesId.name','name', 'surname', 'middlename', 'birthDate', 'placeOfBirth', 'position', 'placeOfLive']])--}}
                                {{--@endif--}}
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{-- Pagination load more button --}}
                    @include('components.pagination' , ['id' => 'family_paginate','url' => route('family.index') , 'totalCount' => $data->totalCount,'page' => $page])
                    {{-- /Pagination load more button --}}
                    <label ></label>
                    <div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">
                        <button id="addToTable"  style="margin-right: 20px; margin-right: -2px;" class="btn btn-floating btn-info waves-effect" data-target="#family-modal" data-toggle="modal" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal --}}
            @include('pages.personal_cards.family._modals', ['modalid'=>'family-modal_form'])
        {{-- /Modal --}}
</section>

<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/family-row.js')}}"></script>
    <script>
        $('#familyRelationTypes').selectObj('familyRelationTypes');
        $('#family-search').search('family-search','family_paginate');
        $('#family_paginate').pagination('load','family_paginate','family-search');
    </script>

    <script>
        $(document).ready(function () {

//            function confirmation(elem,isC,id){
//                $.ajax({
//                    url:'/personal-cards/family-confirm/'+id+'/'+isC+'/',
//                    type: 'GET',
//                    success: function(response){
//                        if(response == 200){
//                            $('[href="/personal-cards/family"]').click();
//                        }
//                    }
//                });
//            }
            $(".date_id").datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                weekStart: 1
            });

        })

    </script>
</section>