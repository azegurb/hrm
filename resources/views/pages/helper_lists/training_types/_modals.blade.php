@include('components.modal-header' , ['id' => 'training-types-modal','mdlTitle' => 'Təlim növləri', 'mdUrl' => route('training-types.store')])
<div class="col-lg-12 float-left">
    <h4>Təli̇m növünün adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_training_types" required="required">
</div>
@include('components.modal-footer')