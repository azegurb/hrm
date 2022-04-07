@include('components.modal-header' , ['id' => 'award-types-modal','mdlTitle' => 'Mükafat növləri', 'mdlRoute' => route('award-types.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_award_types" required="required">
</div>
@include('components.modal-footer')