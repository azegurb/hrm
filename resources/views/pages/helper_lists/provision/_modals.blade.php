@include('components.modal-header' , ['id' => 'provision-modal','mdlTitle' => 'Təminatlar', 'mdUrl' => route('provision.store') ,'tb' => 'tb' , 'pid' => 'provision_pagination'])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_provision" required="required">
</div>
@include('components.modal-footer')