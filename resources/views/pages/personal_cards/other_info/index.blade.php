<section id="links">

</section>
<section id="content">

    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div  class="panel-body pt-20">
            <div class="tab-content pl-20 pr-20">

                @include('components.filter-bar' , ['sid' => 'info-search','sname' => 'oi-search' , 'pid' => 'other_info_paginate' , 'pname' => 'oi-pagination'])
                {{--@if(count($new) > 0)--}}
                {{--<table class="table" style="border: 1px solid #ffe0b2;border-radius: 3px">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<td colspan="6" class="alert alert-info text-center">--}}
                            {{--<strong style="font-size: 20px">Yeni təsdiqə göndərilənlər</strong>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<th class="table-width-5">№</th>--}}
                        {{--<th class="align-top">Seçkili (qanunvericilik və yerli özünü idarəetmə) orqanların işində iştirakı</th>--}}
                        {{--<th class="align-top">Dövlət orqanlarında dövlət qulluğunun rəhbər vəzifələrin tutulması üçün ehtiyat kadrlar siyahısına daxil olunması ilə bağlı qeydlər</th>--}}
                        {{--<th class="align-top">Çap edilmiş elmi əsərlərin və kitabların adları</th>--}}
                        {{--<th class="align-top">Əmək k(peşə) fəaliyyəti ilə bağlı mühüm əhəmiyyət kəsb edən tədbirlərdə iştirakı</th>--}}
                        {{--<th class="text-right table-width-8"></th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                        {{--@foreach($new as $newNC)--}}
                            {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['electionActivitiesNotes','civilServiceNotes', 'scientificWorksNotes', 'professionalActivitiesNotes']])--}}
                        {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
                {{--@endif--}}

                <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                    <thead>
                        <tr>
                            <th class="table-width-5">№</th>
                            <th class="align-top">Seçkili (qanunvericilik və yerli özünü idarəetmə) orqanların işində iştirakı</th>
                            <th class="align-top">Dövlət orqanlarında dövlət qulluğunun rəhbər vəzifələrin tutulması üçün ehtiyat kadrlar siyahısına daxil olunması ilə bağlı qeydlər</th>
                            <th class="align-top">Çap edilmiş elmi əsərlərin və kitabların adları</th>
                            <th class="align-top">Əmək k(peşə) fəaliyyəti ilə bağlı mühüm əhəmiyyət kəsb edən tədbirlərdə iştirakı</th>
                            <th class="text-right table-width-8"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($data->totalCount > 0)
                            @foreach($data->data as $key=>$otherInfo)
                                <tr id="{{ $otherInfo->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $otherInfo->electionActivitiesNotes }}</td>
                                    <td>{{ $otherInfo->civilServiceNotes }}</td>
                                    <td>{{ $otherInfo->scientificWorksNotes }}</td>
                                    <td>{{ $otherInfo->professionalActivitiesNotes }}</td>
                                    <td class="text-nowrap text-right">
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('other-info.edit' , $otherInfo->id)}}' , 'other-info-modal')">
                                            <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                        </div>
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('other-info.destroy' , $otherInfo->id)}}" )'>
                                            <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                        </div>
                                    </td>
                                </tr>
                                {{--@if(!empty($otherInfo->nc))--}}
                                    {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['electionActivitiesNotes','civilServiceNotes', 'scientificWorksNotes', 'professionalActivitiesNotes']])--}}
                                {{--@endif--}}
                            @endforeach
                        @else
                            <tr align="center">
                                <td style="display: none">0</td>
                                <td colspan="6" class="alert alert-warning">Məlumat daxil edilməmişdir !</td>
                            </tr>
                        @endif
                        </tbody>
                </table>
                {{-- Pagination load more button --}}
                @include('components.pagination' , ['id' => 'other_info_paginate','url' => route('other-info.index'), 'totalCount' => $data->totalCount,'page' => $page])
                {{-- /Pagination load more button --}}
                       <label ></label>
                    <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                        <button id="addToTable"  style="margin-right: 20px; margin-right: -2px;" class="btn btn-floating btn-info waves-effect" data-target="#other-info-modal" data-toggle="modal" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
            </div>
        </div>
    </div>
    @include('pages.personal_cards.other_info._modals', ['modalid'=>'other-info-modal_form'])

</section>

<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/other-info-row.js')}}"></script>
    <script>
        function confirmation(elem,isC,id){
            $.ajax({
                url:'/personal-cards/other-confirm/'+id+'/'+isC+'/',
                type: 'GET',
                success: function(response){
                    if(response == 200){
                        $('[href="/personal-cards/contacts"]').click();
                    }
                }
            });
        }
        $('#info-search').search('info-search','other_info_paginate');
        $('#other_info_paginate').pagination('load','other_info_paginate','info-search');
    </script>
</section>