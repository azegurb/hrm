@include('components.modal-header' , ['id' => 'academic-names-modal','mdlTitle' => 'Elmi adlar', 'mdUrl' => route('academic-names.store')])
<div class="col-lg-12 float-left">
    <h4>Elmi̇ dərəcə (Elmi̇ ad):</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_academic_name" required="required">
</div>
@include('components.modal-footer')