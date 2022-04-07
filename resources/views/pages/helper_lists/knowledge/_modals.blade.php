@include('components.modal-header' , ['id' => 'knowledge-modal','mdlTitle' => 'Bilik səviyyələri', 'mdUrl' => route('knowledge.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_knowledge" required="required">
</div>
@include('components.modal-footer')