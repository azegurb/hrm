@include('components.modal-header' , ['id' => 'countries-modal','mdlTitle' => 'Ölkələr', 'mdUrl' => route('countries.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_country" required="required">
</div>
@include('components.modal-footer')