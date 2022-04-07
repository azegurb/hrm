@include('components.modal-header' , ['id' => 'permission-reasons-modal','mdlTitle' => 'İcazə səbəbləri', 'mdUrl' => route('permission-reasons.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_permission_reason" required="required">
</div>
@include('components.modal-footer')