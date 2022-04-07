<section id='links'>
</section>
<section id='content'>
    <div class="col-lg-12 col-xs-12" id="qualification-degree">
        <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
            <div class="panel-heading panel-heading-tab">
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                    <li class="nav-item"><a class="nav-link active" onclick="refresh()" data-toggle="tab" href="#govpanelTab1"
                                            aria-controls="panelTab1" role="tab" aria-expanded="true">Dövlət təltifləri</a>
                    </li>
                    <li class="nav-item"><a class="nav-link load-link" data-toggle="tab" href="#govpanelTab2" data-url="{{route('reward-honor.index')}}" aria-controls="govpanelTab2"
                                            role="tab">Fəxri adlar</a>
                    </li>
                    <li class="nav-item"><a class="nav-link load-link" data-toggle="tab" href="#govpanelTab3" data-url="{{route('reward-individual.index')}}" aria-controls="govpanelTab3"
                                            role="tab">Fərdi mükafatlar</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content" >
                    <div class="tab-pane active m-t-20" id="govpanelTab1" role="tabpanel">
                        @include('components.filter-bar' , ['sid' => 'government-rewards-search','sname' => 'gov-rew-search' , 'pid' => 'government_rewards_pagination' , 'pname' => 'gov-rew-pagination'])
                        {{--Table--}}
                        <table class="table table-hover dataTable w-full">
                            <thead >
                            <tr>
                                <th class="table-width-5">№</th>
                                <th>Təltiflər</th>
                                <th>Vəsiqə nömrəsi və tarix</th>
                                <th>Sərəncam nömrəsi və tarix</th>
                                <th class="table-width-10">Verilmə tarixi</th>
                                <th class="text-right table-width-8"></th>
                            </tr>
                            </thead>
                            <tbody id="mainTbody" class="tr-pro">
                            {{--@foreach($new as $newNC)--}}
                                {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRewardGovNameIdName','cardNumber', 'orderNum', 'issueDate']])--}}
                            {{--@endforeach--}}
                            @if($data->totalCount > 0)
                                @foreach($data->data as $key => $value)
                                    <tr id="{{$value->id}}">
                                        <td>{{++$key}}</td>
                                        <td>{{$value->listRewardGovNameIdName}}</td>
                                        <td>{{$value->cardNumber}}</td>
                                        <td>{{$value->orderNum}}</td>
                                        <td>{{$value->issueDate}}</td>
                                        <td class="text-nowrap text-right">
                                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('reward-gov.edit' , $value->id)}}' , 'gov-reward')">
                                                <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                            </div>
                                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('reward-gov.destroy' , $value->id)}}" )'>
                                                <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                            </div>
                                        </td>
                                    </tr>
                                    {{--@if(!is_null($value->nc))--}}
                                        {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRewardGovNameIdName','cardNumber', 'orderNum', 'issueDate']])--}}
                                    {{--@endif--}}
                                @endforeach
                            @else
                                <tr align="center"><td colspan="6" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                            @endif
                            </tbody>
                        </table>
                        {{--/Table--}}
                        {{-- Pagination load more button --}}
                        @include('components.pagination' , ['id' => 'government_rewards_pagination','url' => route('reward-gov.index') , 'totalCount' => $data->totalCount,'page' => $page])
                        {{-- /Pagination load more button --}}
                        {{--Slide Panel Trigger--}}
                        <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
                             data-selectable="selectable">
                            <button type="button" class="btn btn-floating btn-info waves-effect"
                                    data-toggle="modal" data-target="#gov-reward">
                                <i class="icon md-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                        {{--Slide Panel Trigger--}}
                    </div>
                    <div class="tab-pane m-t-20" id="govpanelTab2" role="tabpanel"></div>
                    <div class="tab-pane m-t-20" id="govpanelTab3" role="tabpanel"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gov Reward Add/Edit Modal-->
    @include('components.modal-header' , ['id' => 'gov-reward','mdlTitle' => 'Dövlət təltiflərinin qeydiyyatı ekranı' ,'mdUrl' => route('reward-gov.store')])
        <div class="col-md-12">
            <h4>Təltiflər: </h4>
            <input type="hidden" class="append" name="listRewardGovNameIdName" value="">
            <select id="reward" name="listRewardGovNameId" data-url="{{route('listRewardGovNameId.get')}}" class="form-control select"  required="required"></select>
        </div>
        <div class="col-md-6 pull-l mt-20">
            <h4>Vəsiqə nömrəsi və tarixi: </h4>
            <input type="text" class="form-control" name="cardNumber" id="reward-numb-date"  required="required">
        </div>
        <div class="col-md-6 pull-r mt-20">
            <h4>Sərəncam nömrəsi və tarixi: </h4>
            <input type="text" class="form-control" name="orderNum" id="order-numb-date"  required="required">
        </div>
        <div class="col-md-6 pull-l mt-20">
            <h4>Tarix: </h4>
            <input type="text" name="issueDate" class="form-control date-picker date_id" id="gov-date"  required="required">
        </div>
{{--@include('pages.personal_cards.common', ['modalid'=>'gov-reward_form'])--}}
    @include('components.modal-footer')
    <!-- /Modal -->
</section>

<section id='scripts'>
    <script src="{{asset('js/custom/plugins/page-row/reward-gov-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/select-text-appender.js')}}"></script>
    <script src="{{asset('js/custom/plugins/refresh.js')}}"></script>
    <script src="{{asset('js/custom/plugins/loader.js')}}"></script>
    <script>
        $('#reward').selectObj('reward');
        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
        $('#government-rewards-search').search('government-rewards-search','government_rewards_pagination');
        $('#government_rewards_pagination').pagination('load','government_rewards_pagination','government-rewards-search');
    </script>
</section>