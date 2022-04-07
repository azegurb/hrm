@include('components.modal-header' , ['id' => 'contest-types-modal','mdlTitle' => 'Müsabiqə növləri', 'mdUrl' => route('contest-types.store')])
<div class="col-lg-12 float-left">
    <h4>Müsabi̇qəni̇n növü:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_contest_type" required="required">
</div>
@include('components.modal-footer')