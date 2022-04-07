@include('components.modal-header' , ['id' => 'org-structures-modal','mdlTitle' => 'Şirkət strukturları', 'tb' => 'tb', 'mdUrl' => route('organizationstructures.store')])
<div class="col-lg-6 float-left">
    <h4>Şirkət:</h4>
    <select class="form-control select" id="listOrganizations"  data-url="{{route('org-name-select')}}" name="input_organization" required="required"></select>
</div>
<div class="col-lg-6 float-left">
    <h4>Struktur adı:</h4>
    <input type="text" class="form-control" id="inputStructure" name="input_structure" required="required">
    <input type="hidden" id="inputStructureIdHidden" name="input_structure_id_hidden">
</div>
@include('components.modal-footer')