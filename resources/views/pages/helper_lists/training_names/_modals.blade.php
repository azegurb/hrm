@include('components.modal-header' , ['id' => 'training-names-modal','mdlTitle' => 'Təlim adları', 'mdUrl' => route('training-names.store')])
<div class="col-lg-12 float-left">
    <h4>Təli̇mi̇n növü:</h4>
    <div class="form-group">
        <select class="form-control select" id="listTrainingType" data-url="{{route('listTrainingTypeController.get')}}" name="input_list_training_type" required="required">
        </select>
    </div>
    <h4>Təli̇mi̇n adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_training_name" required="required">
</div>
@include('components.modal-footer')