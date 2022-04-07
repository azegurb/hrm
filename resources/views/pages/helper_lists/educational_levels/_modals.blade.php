@include('components.modal-header' , ['id' => 'educational-levels-modal','mdlTitle' => 'Təhsil səviyyələri', 'mdUrl' => route('educational-levels.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_educational_level" required="required">
</div>
@include('components.modal-footer')