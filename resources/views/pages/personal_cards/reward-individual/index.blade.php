{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'individual-rewards-search','sname' => 'hon-rew-search' , 'pid' => 'individual_rewards_pagination' , 'pname' => 'hon-rew-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead style="border-top: 1px solid #e0e0e0;">
    <tr>
        <th>№</th>
        <th>Mükafat</th>
        <th>Səbəb</th>
        <th>Verilmə tarixi</th>
        <th></th>
    </tr>
    </thead>
    <tbody id="mainTbody" class="tr-pro">
    {{--@foreach($new as $newNC)--}}
        {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRewardIndividualNameIdName','reason', 'orderNum', 'issueDate']])--}}
    {{--@endforeach--}}
        @if($data->totalCount > 0)
            @foreach($data->data as $key => $value)
                <tr id="{{$value->id}}">
                    <td>{{++$key}}</td>
                    <td>{{$value->listRewardIndividualNameIdName}}</td>
                    <td>{{$value->reason}}</td>
                    <td>{{$value->orderNum}}</td>
                    <td>{{$value->issueDate}}</td>
                    <td class="text-nowrap text-right">
                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('reward-individual.edit' , $value->id)}}' , 'individual-reward')">
                            <i class="icon md-edit" aria-hidden="true"></i>
                            <span class="tptext tpedit">Düzəliş et</span>
                        </div>
                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('reward-individual.destroy' , $value->id)}}" )'>
                            <i class="icon md-delete" aria-hidden="true"></i>
                            <span class="tptext tpdel">Sil</span>
                        </div>
                    </td>
                </tr>
                {{--@if(!is_null($value->nc))--}}
                    {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRewardIndividualNameIdName','reason', 'orderNum', 'issueDate']])--}}
                {{--@endif--}}
            @endforeach
        @else
            <tr align="center">
                <td colspan="5" class="alert alert-warning">Məlumat yoxdur</td>
            </tr>
        @endif
    </tbody>
</table>
{{--/Table--}}
{{-- Pagination load more button --}}
@include('components.pagination' , ['id' => 'individual_rewards_pagination','url' => route('reward-individual.index') , 'totalCount' => $data->totalCount,'page' => $page])
{{-- /Pagination load more button --}}
{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#individual-reward">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}

<!-- Individual Reward Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'individual-reward','mdlTitle' => 'Fərdi mükafatların qeydiyyatı ekranı' ,'mdUrl' => route('reward-individual.store') , 'tb' => 'mainTbody' , 'pid' => 'individual_rewards_pagination'])
    <div class="col-md-12">
        <label for="individual-rewards"><h4>Mükafatlar:</h4></label>
        <input type="hidden" class="append" name="listRewardIndividualNameIdName" value="">
        <select id="individualreward" data-url="{{route('listRewardIndividualNameId.get')}}" name="listRewardIndividualNameId" class="form-control select" required="required">
        </select>
    </div>
    <div class="col-md-12 mt-20">
        <label for="reward-couse"><h4>Səbəb:</h4></label>
        <textarea class="form-control" name="reason" id="reward-couse" required="required"></textarea>
    </div>
    <div class="col-md-6 pull-r mt-20">
        <label for="individual-order-numb-date"><h4>Əmrin nömrəsi və tarix:</h4></label>
        <input type="text" class="form-control" name="orderNum" id="individual-order-numb-date" required="required">
    </div>
    <div class="col-md-6 pull-l mt-20">
        <label for="individual-date"><h4>Verilmə tarixi:</h4></label>
        <input type="text" class="form-control date-picker" name="issueDate" id="individual-date" required="required">
    </div>
@include('components.modal-footer')
<!-- /Modal -->
<!-- /Modal -->
<script src="{{asset('js/custom/plugins/page-row/individual-reward-row.js')}}"></script>
<script src="{{asset('js/custom/plugins/select-text-appender.js')}}"></script>

<script>
    $('#individualreward').selectObj('individualreward');
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekStart: 1
    });
    $('#individual-rewards-search').search('individual-rewards-search','individual_rewards_pagination');
    $('#honor_rewards_pagination').pagination('load','individual_rewards_pagination','individual-rewards-search');
</script>