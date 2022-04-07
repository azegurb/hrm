@include('components.modal-header' , ['id' => 'position-name-modal','mdlTitle' => 'Vəzifə adları qeydiyyatı ekranı', 'mdUrl' => route('position-names.store')])
    <div class="col-lg-9 float-left">
        <h4>Vəzi̇fə adı:</h4>
        <input type="text" class="form-control" id="inputHelpText" name="input_position_name" required="required">
    </div>
    <div class="col-lg-3 float-left">
        <h4>Sıralama ardıcıllığı:</h4>
        <input type="number" id="speciality" class="form-control" name="input_position_order" value="0" required="required">
    </div>
@include('components.modal-footer')