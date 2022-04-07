{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'honor-rewards-search','sname' => 'i-rew-search' , 'pid' => 'honor_rewards_pagination' , 'pname' => 'i-rew-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead style="border-top: 1px solid #e0e0e0;">
        <tr>
            <th>№</th>
            <th>Fəxri ad</th>
            <th>Vəsiqə nömrəsi və tarix</th>
            <th>Sərəncam nömrəsi və tarix</th>
            <th>Verilmə tarixi</th>
        </tr>
    </thead>
    <tbody id="mainTbody" class="tr-pro">
    {{--@foreach($new as $newNC)--}}
        {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRewardHonorNameIdName','cardNumber', 'orderNum', 'issueDate']])--}}
    {{--@endforeach--}}
    @if($data->totalCount > 0)
    @foreach($data->data as $key => $value)
        <tr id="{{$value->id}}">
            <td>{{++$key}}</td>
            <td>{{$value->listRewardHonorNameIdName}}</td>
            <td>{{$value->cardNumber}}</td>
            <td>{{$value->orderNum}}</td>
            <td>{{$value->issueDate}}</td>
            <td class="text-nowrap text-right">
                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('reward-honor.edit' , $value->id)}}' , 'honor-reward')">
                    <i class="icon md-edit" aria-hidden="true"></i>
                    <span class="tptext tpedit">Düzəliş et</span>
                </div>
                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('reward-honor.destroy' , $value->id)}}" )'>
                    <i class="icon md-delete" aria-hidden="true"></i>
                    <span class="tptext tpdel">Sil</span>
                </div>
            </td>
        </tr>
        {{--@if(!is_null($value->nc))--}}
            {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRewardHonorNameIdName','cardNumber', 'orderNum', 'issueDate']])--}}
        {{--@endif--}}
    @endforeach
    @else
        <tr align="center"><td colspan="5" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
    @endif
    </tbody>
</table>
{{--/Table--}}
{{-- Pagination load more button --}}
@include('components.pagination' , ['id' => 'honor_rewards_pagination','url' => route('reward-honor.index') , 'totalCount' => $data->totalCount,'page' => $page])
{{-- /Pagination load more button --}}
{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#honor-reward">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}

<!-- Honor Reward Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'honor-reward','mdlTitle' => 'Fəxri adların qeydiyyatı ekranı' ,'mdUrl' => route('reward-honor.store') , 'tb' => 'mainTbody' , 'pid' => 'honor_rewards_pagination'])
    <div class="col-md-12">
        <label for="honor-reward"><h4>Fəxri ad:</h4></label>
        <input type="hidden" class="append" name="listRewardHonorNameIdName" value="">
        <select id="honorreward" name="listRewardHonorNameId" data-url="{{route('listRewardHonorNameId.get')}}" class="form-control select" required="required"></select>
    </div>
    <div class="col-md-6 pull-l mt-20">
        <label for="honor-reward-numb-date"><h4>Vəsiqə nömrəsi və tarixi:</h4></label>
        <input type="text" name="cardNumber" class="form-control" id="honor-reward-numb-date" required="required">
    </div>
    <div class="col-md-6 pull-r mt-20">
        <label for="honor-order-numb-date"><h4>Sərəncam nömrəsi və tarixi:</h4></label>
        <input type="text" name="orderNum" class="form-control" id="honor-order-numb-date" required="required">
    </div>
    <div class="col-md-6 pull-l mt-20">
        <label for="honor-date"><h4>Tarix:</h4></label>
        <input type="text" name="issueDate" class="form-control date-picker date_id" id="honor-date" required="required">
    </div>
@include('components.modal-footer')
<!-- /Modal -->
<script src="{{asset('js/custom/plugins/page-row/honor-gov-row.js')}}"></script>
<script src="{{asset('js/custom/plugins/select-text-appender.js')}}"></script>

<script>
    $('#honorreward').selectObj('honorreward');
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekStart: 1
    });
    $('#honor-rewards-search').search('honor-rewards-search','honor_rewards_pagination');
    $('#honor_rewards_pagination').pagination('load','honor_rewards_pagination','honor-rewards-search');
</script>