@include('components.modal-header' , ['id' => 'educational-types-modal','mdlTitle' => 'Təhsil növləri', 'mdUrl' => route('educational-types.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_educational_type" required="required">
</div>
@include('components.modal-footer')