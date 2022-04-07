@include('components.modal-header' , ['id' => 'punishment-modal','mdlTitle' => 'Cəza növləri', 'mdUrl' => route('punishment.store'), 'tb' => 'tb'])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_punishment" required="required">
</div>
@include('components.modal-footer')