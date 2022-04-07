@include('components.modal-header' , ['id' => 'educational-institutions-modal','mdlTitle' => 'Təhsil müəssisələri', 'mdUrl' => route('educational-institutions.store') , 'tb'=>'tb'])
<div class="col-lg-12 float-left">
    <h4>Adı:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_edu_institutions_name" required="required">
    <h4>Təhsil müəssisəsinin növü:</h4>
    <div class="form-group">
        <select class="form-control select" id="listEducationalInstitutions" data-url="{{route('listEducationalTypeController.get')}}" name="input_educational_type"></select>
    </div>
    <div class="checkbox-custom checkbox-primary">
        <input type="checkbox" id="inputUnchecked" name="input_abroad">
        <label for="inputUnchecked">Xaricdə</label>
    </div>
</div>
@include('components.modal-footer')