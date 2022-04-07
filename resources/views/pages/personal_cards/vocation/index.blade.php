<section id="links">
</section>
<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse">
        <div  class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'vocation-search','sname' => 'vc-search' , 'pid' => 'vocation_pagination' , 'pname' => 'vc-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover toggle-circle">
                <thead>
                <tr>
                    <th class="table-width-4">№</th>
                    <th>Məzuniyyətin tipi</th>
                    <th>Məzuniyyətin əmri</th>
                    <th>Əmrin tarixi</th>
                    <th>Məzuniyyət dövrü</th>
                    <th>Məzuniyyət müddəti</th>
                    <th>İşə başlama tarixi</th>
                    <th>Əsas məzuniyyət</th>
                    <th>Əsas məzuniyyətin qalığı</th>
                    <th>Əlavə məzuniyyət</th>
                    <th>Əlavə məzuniyyətin qalığı</th>
                    {{--<th class="text-right"></th>--}}
                </tr>
                </thead>
                <tbody id="vocation-tbody">
                {{--<tr align="center"><td colspan="11" class="alert alert-warning">Bu bölmə təmir edilir!</td></tr>--}}

                {{--{{dd($data)}}--}}
                @if($data->totalCount > 0)

                    @foreach($data->data as $key => $value)
                            <tr id="{{$value->id}}" onclick="toggletree('{{$value->id}}')" data-expanded="false">
                                <td rowspan="7">{{++$key}}</td>
                                <td>{{$value->listVacationTypeIdName}}</td>
                                <td>{{$value->orderCommonIdOrderNum}}</td>
                                <td>{{$value->orderCommonIdOrderDate}}</td>
                                <td>

                               @foreach ($value->details as $details)
                                        {{$details->vacationWorkPeriodFrom}} - {{$details->vacationWorkPeriodFrom}}
                                @endforeach
                                </td>
                                <td>
                                    @foreach ($value->details as $details)

                                    {{$details->endDate}} - {{$details->startDate}}

                                    @endforeach
                                </td>
                                <td>

                                    {{$value->details[0]->workStartDate}}</td>
                                <td>
                                    @foreach ($value->details as $details)
                                        {{$details->mainVacationDay}} gün <br>
                                    @endforeach
                                </td>
                                <td> @foreach ($value->details as $details)
                                        {{$details->mainRemainderVacationDay}} gün<br>
                                    @endforeach

                                    </td>
                                <td> @foreach ($value->details as $details)
                                        {{$details->additionVacationDay}} gün<br>
                                    @endforeach

                                    </td>
                                <td>
                                    @foreach ($value->details as $details)
                                        {{$details->additionRemainderVacationDay}} gün<br>
                                    @endforeach


                                </td>
                                {{--<td class="text-right">--}}
                                    {{--<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData('{{route('vocation.edit' , $value->id)}}' , 'vocation-modal','expandable')">--}}
                                        {{--<i class="icon md-edit" aria-hidden="true"></i>--}}
                                        {{--<span class="tptext tpedit">Düzəliş et</span>--}}
                                    {{--</div>--}}
                                    {{--<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this) , "{{route('vocation.destroy' , $value->id)}}")'>--}}
                                        {{--<i class="icon md-delete" aria-hidden="true"></i>--}}
                                        {{--<span class="tptext tpdel">Sil</span>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            </tr>
                            <tr><td colspan="10"><b>Əmək qanunvericiliyi üzrə əlavə məzuniyyətin məlumatları</b></td></tr>
                        <tr>
                            <td>İş stajına görə düşən (ümumi)</td>
                            <td>İş stajına görə düşən (istifaə)</td>
                            <td>İş şəraitinə görə düşən (ümumi)</td>
                            <td>İş şəraitinə görə düşən (istifadə)</td>
                            <td>14 yaşına qədər 2 uşağı olan (ümumi)</td>
                            <td>14 yaşına qədər 2 uşağı olan (istifadə)</td>
                            <td>14 yaşına qədər 3 uşağı olan (ümumi)</td>
                            <td>14 yaşına qədər 3 uşağı olan (istifadə)</td>
                            <td colspan="2">İş ili dövrləri</td>
                            {{--<td></td>--}}
                        </tr>
                            <tr>

                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->experienceDay}}<br>
                                    @endforeach

                                </td>
                                <td> @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->totalExperienceDay}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->workConditionDay}}<br>
                                    @endforeach

                                </td>
                                <td>

                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->totalWorkConditionDay}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->child142}}<br>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->totalChild142}}<br>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->child143}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->totalChild143}}<br>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->orderVacationDetailIdVacationWorkPeriodFrom}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsAdd as $detailsAdd)
                                        {{$detailsAdd->orderVacationDetailIdVacationWorkPeriodTo}}<br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr><td colspan="10"><b>Kollektive müqavilə üzrə əlavə məzuniyyətin məlumatları</b></td></tr>
                            <tr>
                            <td>Bütün qadınlara (ümumi)</td>
                            <td>Bütün qadınlara (istifaə)</td>
                            <td>14 yaşına qədər 2 uşağı olan (ümumi)</td>
                            <td>14 yaşına qədər 2 uşağı olan (istifadə)</td>
                            <td>14 yaşına qədər 3 uşağı olan (ümumi)</td>
                            <td>14 yaşına qədər 3 uşağı olan (istifadə)</td>
                            <td>Çernobıl əlilləri üçün (ümumi)</td>
                            <td>Çernobıl əlilləri üçün (istifadə)</td>
                            <td colspan="2">İş ili dövrləri</td>
                            </tr>

                            <tr>

                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->allWomenDay}}<br>
                                    @endforeach

                                </td>
                                <td> @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->totalAllWomenDay}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->child142}}<br>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->totalChild142}}<br>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->child143}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->totalChild143}}<br>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->chernobylAccidenDay}}<br>
                                    @endforeach

                                </td>
                                <td>

                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->totalChernobylAccidenDay}}<br>
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->orderVacationDetailIdVacationWorkPeriodFrom}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($value->detailsCollective as $detailsCollective)
                                        {{$detailsCollective->orderVacationDetailIdVacationWorkPeriodTo}}<br>
                                    @endforeach
                                </td>
                            </tr>

                    @endforeach
                @else
                    <tr align="center"><td colspan="11" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>

            </table>
            <table>
                <thead>

                </thead>

            </table>
            {{-- Pagination load more button --}}
            {{--@include('components.pagination' , ['id' => 'vocation_pagination','url' => route('vocation.index') , 'totalCount' => 5,'page' => $page])--}}
            {{-- /Pagination load more button --}}
        </div>
        {{--<div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">--}}
            {{--<button id="addToTable"  class="btn btn-floating btn-info waves-effect" data-target="#vocation-modal" data-toggle="modal" type="button">--}}
                {{--<i class="icon md-plus" aria-hidden="true"></i>--}}
            {{--</button>--}}
        {{--</div>--}}
    </div>
    <!-- Modal -->
    @include('pages.personal_cards.vocation._modals')
    <!-- End Modal -->
</section>
<section id="scripts">
    {{--<script src="{{asset('js/custom/pages/vocation/tree-toggle.js')}}"></script>--}}
    {{--<script src="{{asset('js/custom/pages/vocation/expandable.js')}}"></script>--}}
    {{--<script src="{{asset('js/custom/pages/vocation/rowGen.js')}}"></script>--}}
    <script src="{{asset('core/global/vendor/moment/moment.min.js')}}"></script>

    <script>
        $('#listVacationType').selectObj('listVacationType');
        $('#order').selectObj('order');
        $('#vocation-search').search('vocation-search','vocation_pagination','','','vocation-tbody','rowGen');
        $('#vocation_pagination').pagination('load','vocation_pagination','vocation-search');
        $('#vocation-tbody').find('tr').attr('data-expanded' , false);
        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
    </script>

</section>