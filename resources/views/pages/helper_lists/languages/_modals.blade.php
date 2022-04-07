@include('components.modal-header' , ['id' => 'languages-modal','mdlTitle' => 'Dillər', 'mdUrl' => route('languages.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_language" required="required">
</div>
@include('components.modal-footer')