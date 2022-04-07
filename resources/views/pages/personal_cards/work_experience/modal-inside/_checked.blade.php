<hr>
<div class="row">

    {{-- Organization --}}
    <div class="col-md-12 float-left mb-20">
        <h4>Müəsisə / Şirkət</h4>
        <select name="listOrganizationId" id="listOrganizationId" data-url="{{route('org-name-select')}}"  required="required">
            @if(!empty($data) && !empty($data->data->listOrganizationIdId))
                <option value="{{$data->data->listOrganizationIdId}}" selected>{{$data->data->listOrganizationIdName}}</option>
            @endif
        </select>
    </div>
    {{--{{dd($data->data)}}--}}
    {{-- Structure --}}
    <div class="col-md-12 float-left mb-20">
        <h4>Struktur:</h4>
        <select name="listStructureId" id="listStructureId" data-url="{{route('str-by-org-select')}}"  required="required">
            @if(!empty($data) && !empty($data->data->structuresNameIdName))
                <option value="{{$data->data->structuresNameIdName}}" selected>{{$data->data->structuresNameIdName}}</option>
            @endif
        </select>
    </div>

    {{--Position--}}
    <div class="col-md-12 float-left mb-20">
        <h4>Vəzifə:</h4>
        <div id="civilContainer">
            <select name="listPositionNameId" required="required" id="positionId" data-url="{{url('personal-cards/get-select/for-position')}}"
                    {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}}>
                @if(!empty($data) && !empty($data->data->listPositionNameIdId))
                    <option value="{{$data->data->listPositionNameIdId}}" selected>{{$data->data->listPositionNameIdName}}</option>
                @endif
            </select></div>
    </div>

    {{--CivilService??--}}
    <div class="col-lg-4 float-left mt-20">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" id="differentOrgIsCivilService" value="true" {{!empty($data) &&
              !empty($data->data->differentOrgIsCivilService) &&
              $data->data->differentOrgIsCivilService == true ? 'checked' : ''}}
            name="differentOrgIsCivilService"/>
            <label for="differentOrgIsCivilService"><b>Dövlət qulluğu</b></label>
        </div>
    </div>

    {{--<div class="col-md-6 float-left mb-20" id="differentOrgListContractTypeIdContainer">--}}
        {{--<h4>Əmək müqaviləsi:</h4>--}}
        {{--<select name="differentOrgListContractTypeId" id="differentOrgListContractTypeId" data-url="{{route('labor-contracts-select' , 'false')}}"  required="required">--}}
            {{--@if(!empty($data) &&!empty($data->data->differentOrgListContractTypeId))--}}
                {{--<option value="{{$data->data->differentOrgListContractTypeId->id}}" selected>{{$data->data->differentOrgListContractTypeId->name}}</option>--}}
            {{--@endif--}}
        {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-6 float-left mb-20">--}}
        {{--<h4>Əmrin növü:</h4>--}}
        {{--<select name="listOrderTypeId"  required="required" id="order-type" data-url="{{route('order-types.list')}}?type=true">--}}
            {{--@if(!empty($data) && !empty($data->data->listOrderTypeId))--}}
                {{--<option value="{{$data->data->listOrderTypeId->id}}" selected>{{$data->data->listOrderTypeId->name}}</option>--}}
            {{--@endif--}}
        {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-4">--}}
        {{--<h4>Əmrin tarixi:</h4>--}}
        {{--<div class="input-group">--}}
            {{--<span class="input-group-addon">--}}
                    {{--<i class="icon md-calendar" aria-hidden="true"></i>--}}
            {{--</span>--}}
            {{--<input type="text" name="reasondifferentOrgOrderDate" class="form-control date_id" value="{{!empty($data) && !empty($data->data->differentOrgOrderDate) ? $data->data->differentOrgOrderDate : ''}}"  required="required">--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="col-md-8 float-left">
        <h4>İşləmə tarixi:</h4>
        <div class="input-daterange" data-plugin="datepicker">
            <div class="input-group">
            <span class="input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
                <input type="text" class="form-control date_id" name="differentOrgStartDate" value="{{!empty($data) && !empty($data->data->differentOrgStartDate) ? $data->data->differentOrgStartDate : ''}}"  required="required"/>
            </div>
            <div class="input-group">
                <span class="input-group-addon">&mdash;</span>
                <input type="text" class="form-control date_id" name="differentOrgEndDate" value="{{!empty($data) && !empty($data->data->differentOrgEndDate) ? $data->data->differentOrgEndDate : ''}}"  required="required"/>
            </div>
        </div>
    </div>
    {{--<div class="col-md-6 mt-20">--}}
        {{--<h4>Əmrin nömrəsi:</h4>--}}
            {{--<input type="text" name="differentOrgOrderNum" class="form-control" value="{{!empty($data) && !empty($data->data->differentOrgOrderNum) ? $data->data->differentOrgOrderNum : ''}}"  required="required">--}}
    {{--</div>--}}
</div>
<script>
    @if(empty($data))
        $('#work-experiance-modal').find('button[type="submit"]').show();
    @endif
    $('#listOrganizationId').selectObj('listOrganizationId');
    $('#order-type').selectObj('order-type');
    $('#positionId').selectObj('positionId');
    $('#listStructureId').selectObj('listStructureId');
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekStart: 1
    });


    //Set Url
    var url = $('#listStructureId').data('url');
    console.log(url);
    $('#listOrganizationId').selectObj('listOrganizationId');
    $('#listOrganizationId').on('select2:select',function () {
        var id = $(this).select2('data')[0].id;
        console.log( url + '/' + id);
        $('#listStructureId').selectObj('listStructureId',false, url + '/' + id);
    });

</script>