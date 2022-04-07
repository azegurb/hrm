@include('components.modal-header' , ['id' => 'contest-results-modal','mdlTitle' => 'Müsabiqənin nəticələri', 'mdUrl' => route('contest-results.store')])
<div class="col-lg-12 float-left">
    <h4>Nəticə:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_contest_result" required="required">
</div>
@include('components.modal-footer')