@include('components.modal-header' , ['id' => 'relation-types-modal','mdlTitle' => 'Qohumluq əlaqələri', 'mdUrl' => route('relation-types.store')])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_relation_types" required="required">
</div>
@include('components.modal-footer')