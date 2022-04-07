@include('components.modal-header' , ['id' => 'rank-types-modal','mdlTitle' => 'Xüsusi rütbələr', 'mdUrl' => route('rank-types.store'), 'tb' => 'tb'])
<div class="col-lg-12 float-left">
    <h4>Xüsusi̇ rütbəni̇n növü:</h4>
    <div class="form-group">
        <select class="form-control select" id="listRankType" data-url="{{route('listRankTypeController.get')}}" name="input_list_rank_type" required="required">
        </select>
    </div>
    <h4>Rütbə adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_rank_name" required="required">
</div>
@include('components.modal-footer')