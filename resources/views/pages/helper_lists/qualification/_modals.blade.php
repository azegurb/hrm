@include('components.modal-header' , ['id' => 'qualification-modal','mdlTitle' => 'İxtisas dərəcəsi', 'mdUrl' => route('qualification.store') , 'tb' => 'tb'])
<div class="col-lg-12 float-left">
    <h4>Təsni̇fatı:</h4>
    <div class="form-group">
        <select class="form-control select" id="listPositionClassification" data-url="{{route('listPositionClassification.get')}}" name="input_pos_classification" required="required">
        </select>
    </div>
    <h4>İxti̇sas dərəcəsi:</h4>
    <div class="form-group">
        <select class="form-control select" id="listQualificationType" data-url="{{route('listQualificationType.get')}}" name="input_qual_type" required="required">
        </select>
    </div>
    <h4>Dövlət qulluğunda staj:</h4>
    <input type="number" class="form-control" id="inputHelpText" value="0" name="input_req_dq" required="required">
    <h4>Cari̇ təsni̇fatda staj:</h4>
    <input type="number" class="form-control" id="inputHelpText" value="0" name="input_req_curclasi" required="required">
    <h4>Ardıcıllıq:</h4>
    <input type="number" class="form-control" id="inputHelpText" value="0" name="input_sequence" required="required">
</div>
@include('components.modal-footer')