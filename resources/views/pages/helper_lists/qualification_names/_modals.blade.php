@include('components.modal-header' , ['id' => 'qualification-names-modal','mdlTitle' => 'İxtisas dərəcəsi', 'mdUrl' => route('qualification-names.store'), 'tb' => 'tb'])
<div class="col-lg-9 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputqualname" name="input_qualification_name" required="required">
</div>
<div class="col-lg-3 float-left">
    <h4>Veri̇lmə ardıcıllığı:</h4>
    <input type="number" class="form-control" id="inputqualseq" value="0" name="input_qualification_sequence" required="required">
</div>
@include('components.modal-footer')