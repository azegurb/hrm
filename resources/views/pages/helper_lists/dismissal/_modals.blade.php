@include('components.modal-header' , ['id' => 'dismissal-modal','mdlTitle' => 'Vəzifədən azadetmə səbəbləri', 'mdUrl' => route('dismissal.store')])
<div class="col-lg-12 float-left">
    <h4>Azadetmə səbəbi̇:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_dismissal" required="required">
</div>
@include('components.modal-footer')