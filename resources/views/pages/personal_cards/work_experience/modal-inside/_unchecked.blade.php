<div class="row">
    <div class="col-md-4 float-left mb-20">
        <h4>Əmrin növü:</h4>
        <select name="listOrderTypeId" required="required" id="order-type" data-url="{{route('order-types.list')}}?type=true" {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}>
            @if(!empty($data) && !empty($data->data->listOrderTypeIdId))
                <option value="{{$data->data->listOrderTypeIdId}}" selected>{{$data->data->listOrderTypeIdName}}</option>
            @endif
        </select>
        <div id="ordertypelabel"></div>
    </div>
    <div class="col-md-4 mb-20" id="order-type-container" style="position: relative;">
        <h4>Əmrin nömrəsi:</h4>
        <input type="text" name="orderNum" class="form-control" onfocus="getCommon($(this))" onkeyup="getCommon($(this))" id="orderNum"
               {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}
               value="{{!empty($data) && !empty($data->data->orderNum) ? $data->data->orderNum : ''}}"
               required="required">
        <input type="hidden" name="orderNumId" id="orderNumId" value="{{!empty($data) && !empty($data->data->orderId) ? $data->data->orderId : ''}}">
        <div id="search-results"></div>
    </div>
    <div class="col-md-4 mb-20">
        <h4>Əmrin tarixi:</h4>
        <div class="input-group">
            <span class="input-group-addon">
                    <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
            <input type="text" name="orderDate" class="form-control date_id"
                   {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}
                   value="{{!empty($data) && !empty($data->data->orderDate) ? $data->data->orderDate : ''}}"
                   required="required">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-20">
        <h4>Əmrin əsası:</h4>
        <input type="text" name="basis" class="form-control"
               value="{{!empty($data) && !empty($data->data->basis) ? $data->data->basis : ''}}"
               {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}
               required="required">
    </div>
</div>
<div class="row">
    <div class="col-md-3 float-left mt-20">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" id="differentOrgIsCivilService" value="true"
                   name="isCivil" {{!empty($data) && $data->data->isCivilService == true ? 'checked' : ''}}
                    {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}/>
            <label for="isCivilService"><b>Dövlət qulluğu</b></label>
        </div>
    </div>
</div>
<div class="row">
    <input type="hidden" name="appointmentId" id="appointmentField" value="{{!empty($data) && !empty($data->data->orderAppointmentIdId) ? $data->data->orderAppointmentIdId : ''}}">
     {{--Structure--}}
    <div class="col-md-4 float-left mb-20">
        <h4>Struktur:</h4>
        <select name="structureId" required="required" id="structureId" data-url="{{route('structures.list')}}"
                {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}>
            @if(!empty($data) && !empty($data->data->structureIdId))
                <option value="{{$data->data->structureIdId}}" selected>{{$data->data->structureIdName}}</option>
            @endif
        </select>
    </div>
     {{--Position--}}
    <div class="col-md-4 float-left mb-20">
        <h4>Vəzifə:</h4>
        <div id="civilContainer">
            <select name="positionId" required="required" id="positionId" {{!empty($data) && !empty($data->data->positionIdId) ? '' : 'disabled'}}
                    {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}>
                @if(!empty($data) && !empty($data->data->positionIdId))
                    <option value="{{$data->data->positionIdId}}" selected>{{$data->data->positionIdName}}</option>
                @endif
            </select></div>
    </div>
    <div class="col-md-4 float-left mb-20">
        <h4>Vəzifə maaşı:</h4>
        <input type="number" class="form-control" name="positionSalary" value="{{!empty($data) && !empty($data->data->oldSalary) ? $data->data->oldSalary : ''}}" {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}} required>
    </div>
</div>
<div class="row">
    <div class="col-md-4 float-left mb-20" id="differentOrgListContractTypeIdContainer">
        <h4>Əmək müqaviləsi:</h4>
        <select name="differentOrgListContractTypeId" id="differentOrgListContractTypeId" data-url="{{route('labor-contracts-select' , 'false')}}"
                required="required"
                {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}>
            @if(!empty($data) && !empty($data->data->listContractTypeIdId))
                <option value="{{$data->data->listContractTypeIdId}}" selected>{{$data->data->listContractTypeIdName}}</option>
            @endif
        </select>
    </div>
    <div class="col-md-4 mb-20">
        <h4>Başlama tarixi:</h4>
        <input type="text" name="startDate" id="startDate" class="form-control date_id"
               {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}
               value="{{!empty($data) && !empty($data->data->startDate) ? $data->data->startDate : ''}}" required="required">
    </div>
    <div class="col-md-4 mb-20">
        <h4>Müqavilə müddəti:</h4>
        <input type="number" name="appointmentMonth" id="appointmentMonth"
               {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}
               value="{{!empty($data) && !empty($data->data->appointmentMonth) ? $data->data->appointmentMonth : ''}}" placeholder="Ay sayı" class="form-control" required="required">
    </div>
</div>
@if(!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert" align="center">
                <strong>Cari </strong>vəzifənin redaktəsi yalnız əmrlər bölməsindən mümkündür
            </div>
        </div>
    </div>
@endif
<script>
    @if(!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false)
        $('#work-experiance-modal').find('button[type="submit"]').hide();
    @else
        $('#work-experiance-modal').find('button[type="submit"]').show();
    @endif
    $('#order-type').selectObj('order-type');
    $('#positionId').selectObj('positionId');
    $('#structureId').selectObj('structureId');
    $('#differentOrgListContractTypeId').selectObj('differentOrgListContractTypeId');
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy'
    });
</script>