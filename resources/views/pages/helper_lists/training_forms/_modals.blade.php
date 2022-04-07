@include('components.modal-header' , ['id' => 'training-forms-modal','mdlTitle' => 'Təlim formaları', 'mdUrl' => route('training-forms.store')])
<div class="col-lg-12 float-left">
    <h4>Təli̇m formasının adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_training_form" required="required">
</div>
@include('components.modal-footer')