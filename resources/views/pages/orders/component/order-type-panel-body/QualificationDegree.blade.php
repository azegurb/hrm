<input type="hidden" name="orderTypeLabel" value="QualificationDegree">
{{--<input type="hidden" value="{{ isset($data->fields['discipline'][0]['orderCommonId']) ? $data->fields['discipline'][0]['orderCommonId'] : '' }}" name="orderCommonId">--}}
{{--<input type="hidden" value="{{isset($data->fields['discipline'][0]['userDisciplinaryActionId']) ? $data->fields['discipline'][0]['userDisciplinaryActionId'] : '' }}" name="id">--}}
<div class="mt-20" id="QualificationDegree" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-4">
            <h4>Əməkdaş: </h4>
            <input type="hidden" id="userIdHidden" value="{{ isset($data->fields['discipline'][0]['userId']->id) ? $data->fields['discipline'][0]['userId']->id : '' }}">
            <select id="userId" name="userId" class="form-control select" data-url="{{ route('users','select') }}" value="" required>
                <option value="{{isset($data->fields['discipline'][0]['userId']->id) ? $data->fields['discipline'][0]['userId']->id : ''}}" selected>{{ isset($data->fields['discipline'][0]['userId']->firstName) && isset($data->fields['discipline'][0]['userId']->lastName) ? $data->fields['discipline'][0]['userId']->firstName .' '. $data->fields['discipline'][0]['userId']->lastName . ' ' . $data->fields['discipline'][0]['userId']->patronymic : '' }}</option>
            </select>
        </div>
        <div class="col-3">
            <h4>Struktur: </h4>
            <input type="text" disabled="" id="structureName" name="structureName" class="form-control">
        </div>
        <div class="col-3">
            <h4>Vəzifə: </h4>
            <input type="text" disabled="" id="positionName" name="positionName" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-3">
            <h4>İxtisas dərəcəsinin təsnifatı: </h4>
            <select name="listPosClassification" id="listPosClassification" class="form-control select" data-url="{{ route('qualifications.positionClassifications') }}">
                <option></option>
            </select>
        </div>
        <div class="col-3">
            <h4>İxtisas dərəcəsi: </h4>
            <select name="listQualDegree" id="listQualDegree" class="form-control select" data-url="{{route('qualifications.qualificationTypes')}}">
                <option></option>
            </select>
        </div>
        <div class="col-2">
        </div>
        <div class="col-2">
            <h4>Verilmə tarixi: </h4>
            <input type="text" class="form-control" data-plugin="datepicker" name="input_startDate">
        </div>
    </div>

</div>

<script>

    /* load select2 and datapicker */

    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });

    $('[data-plugin="datepicker"]').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });


    /* Strucutre -> position -> user select */

    $('#listPosClassification').selectObj('listPosClassification','ordersModal');

    $('#listQualDegree').selectObj('listQualDegree','ordersModal');

    $('#userId').selectObj('userId', 'ordersModal');

    $('#userId').on('select2:select', function () {

        $('#structureName').val('');
        $('#positionName').val('');

        // Define variables
        var userId =  $(this).val();
        var url    =  'orders/get-position-by-userId/' + userId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                console.log(response);
                write(response.positionId.posNameId.name,response.positionId.structureId.name);


            },
            error: function(error){

                console.log('error yarandi');
            }
        });


        function write(posName,strName){
            var posName = posName;
            var strName = strName;

            $('#structureName').val(strName);
            $('#positionName').val(posName);

        }



//        let url = $('#positionId').data('url') + '/' +  $(this).val();

        $('#positionId').selectObj('positionId' ,false, url);

    });

    $('#listPosClassification').on('select2:select',function () {
        $('#listQualDegree').empty();

        var id = $(this).select2('data')[0].id;

        var url = $('#listQualDegree').data('url');

        $('#listQualDegree').selectObj('listQualDegree', 'ordersModal', url + '/' + id);
    });

    $( document ).ready(function() {


        var userId =  $('#userIdHidden').val();
        var url    =  'orders/get-position-by-userId/' + userId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                console.log(response);
                write(response.positionId.posNameId.name,response.positionId.structureId.name);


            },
            error: function(error){

                console.log('error yarandi');
            }
        });


        function write(posName,strName){
            var posName = posName;
            var strName = strName;

            $('#structureName').val(strName);
            $('#positionName').val(posName);

        }


    });

</script>
