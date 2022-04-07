<section id='links'>
</section>
<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse">
        <div  class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'contact-search','sname' => 'c-search' , 'pid' => 'contacts_paginate' , 'pname' => 'c-pagination'])
            {{-- /Filters --}}
            <table class="table">
                <thead>
                <tr >
                    <th class="table-width-5">№</th>
                    <th class="table-width-10">Ezamiyyətin başlama tarixi</th>
                    <th class="table-width-10">Ezamiyyətin bitmə tarixi</th>
                    <th class="table-width-5">Ezamiyyətin müddəti</th>
                    <th>Ezamiyyətin yeri</th>
                    <th>Ezamiyyətin səbəbi</th>
                    <th>Ezamiyyətin əmri</th>
                    <th class="table-width-10">Əmrin tarixi</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody id="business-tbody">
                @if($data->totalCount != '')
                    @foreach($data->data as $key=>$value)
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            {{--<td>{{ $value->orderBusinessTripIdStartDate }}</td>--}}
                            <td>{{$value->orderBusinessTripIdStartDate}}</td>
                            <td>{{$value->orderBusinessTripIdEndDate}}</td>
                            <td>{{$value->orderBusinessTripIdTripDay}}</td>
                            <td>{{/* Country */ !empty($value->listCountryIdName) ? $value->listCountryIdName.' ,' : '' /* City */ . !empty($value->listCityIdName) ? $value->listCityIdName.' ,' : '' . /* Village */ !empty($value->listVillageIdName) ? $value->listVillageIdName : '' }}</td>
                            <td>{{$value->orderBusinessTripIdTripReason}}</td>
                            <td>{{$value->orderCommonIdOrderNum}}</td>
                            <td>{{$value->orderCommonIdOrderDate}}</td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" `onclick="editData('{{route('business-trip.edit' , $value->id)}}' , 'trip-modal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this) , "{{route('business-trip.destroy' , $value->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center">
                        <td colspan="9" class="alert alert-warning">Heç bir məlumat tapılmadı</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'trip_paginate','url' => route('business-trip.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}
        </div>
        <div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">
            <button id="addToTable"  class="btn btn-floating btn-info waves-effect" data-target="#trip-modal" data-toggle="modal" type="button">
                <i class="icon md-plus" aria-hidden="true"></i>
            </button>
        </div>

    </div>
    {{-- Contact Modal --}}
    @include('pages.personal_cards.business_trip._modal')
    {{-- /Contact Modal --}}
</section>

<section id='scripts'>
    <script src="{{asset('js/custom/pages/business-trip/city-select.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/business-row.js')}}"></script>

    <!--
        <script>
            $(".input-daterange").datepicker({
                orientation: "left bottom",
                format: "dd.mm.yyyy"
            });
        </script> -->
    <script>
        $('#order').selectObj('order');
        $('#contact-search').search('trip-search','trip_paginate');
        $('#trip_paginate').pagination('load','trip_paginate','trip-search');
            $(".date_id").datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                weekStart: 1
            });
    </script>


</section>