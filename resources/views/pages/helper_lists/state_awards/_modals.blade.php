@include('components.modal-header' , ['id' => 'state-awards-modal','mdlTitle' => 'Təltiflər', 'mdUrl' => route('state-awards.store') , 'tb' => 'tb'])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_state_awards" required="required">
</div>
@include('components.modal-footer')