@include('components.modal-header' , ['id' => 'position-provisions-modal','mdlTitle' => 'Təminatlar', 'mdUrl' => route('position-provisions.store') ,'tb' => 'tb' , 'pid' => 'position_provisions_pagination'])
<div class="col-lg-6 float-left">
    <h4>Struktur bölmə:</h4>
    <select class="form-control select" name="structureId" disabled="disabled"></select>
</div>

<div class="col-lg-6 float-left">
    <h4>Vəzifə:</h4>
    <select class="form-control select" name="positionId" disabled="disabled"></select>
</div>
<div class="col-lg-12 float-left">
    <h4>Təminatlar:</h4>
    <select class="form-control select" id="provision" multiple="multiple" data-url="{{route('provisions.get')}}" name="provisions[]" required="required"></select>
</div>


@include('components.modal-footer')