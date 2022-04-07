@include('components.modal-header' , ['id' => 'villages-modal','mdlTitle' => 'Qəsəbələr', 'mdUrl' => route('villages.store') , 'tb' => 'tb'])
<div class="col-lg-6 float-left">
    <h4>Şəhər:</h4>
    <select class="form-control select" id="city" data-url="{{ route('listCity.list') }}" name="input_city" required="required"></select>
</div>
<div class="col-lg-6 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="name_village" name="input_village" required="required">
</div>
@include('components.modal-footer')