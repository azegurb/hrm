@include('components.modal-header' , ['id' => 'vocation-modal','mdlTitle' => 'Məzuniyyət','mdUrl' => route('vocation.store') , 'tb' => 'vocation-tbody','custom' => 'postForm($(this) , "rowGen")'])
<div class="row modal-scroll">
        <div class="col-md-6 float-left mb-20">
            <h4>Əmr:</h4>
            <select name="order" id="order" data-url="{{route('orders.select')}}" required="required"></select>
        </div>
    <div class="col-md-6">
        <h4>Məzuniyyətin tipi:</h4>
        <select class="form-control select" id="listVacationType" data-url="{{route('vocation.vocationTypes')}}" name="listvacationtype" required="required"></select>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4 float-right">
            <button class="btn btn-sm btn-floating btn-info waves-effect float-right" onclick="expandable()" type="button">
                <i class="icon md-plus" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
<div class="row expandableRow">
    <div class="col-md-12">
        <table class="table">
            <thead id="expandable-head" style="display: none">
                <th class="per45">İş ili:</th>
                <th class="per20">Başlanğıc tarixi:</th>
                <th class="per12">Gün:</th>
                <th class="per20">Son tarix:</th>
                <th></th>
            </thead>
            <tbody id="expand">

            </tbody>
        </table>
    </div>
</div>
    <div class="col-md-12">
        <h4>Qeyd:</h4>
        <textarea name="comment" id="" class="form-control" cols="30" rows="4" required="required"></textarea>
    </div>
@include('components.modal-footer')