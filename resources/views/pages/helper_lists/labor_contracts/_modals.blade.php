@include('components.modal-header' , ['id' => 'labor-contracts-modal','mdlTitle' => 'Əmək müqaviləsi', 'mdUrl' => route('labor-contracts.store') , 'tb' => 'tb'])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_labor_contract" required="required">
    <div class="checkbox-custom checkbox-primary">
        <input type="checkbox" id="inputUnchecked" name="input_civilservice">
        <label for="inputUnchecked">Dövlət qulluğu olması</label>
    </div>
</div>
@include('components.modal-footer')