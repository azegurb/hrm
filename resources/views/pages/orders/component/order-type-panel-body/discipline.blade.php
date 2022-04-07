<input type="hidden" name="orderTypeLabel" value="discipline">
<input type="hidden" value="{{ isset($data->fields['discipline'][0]['orderCommonId']) ? $data->fields['discipline'][0]['orderCommonId'] : '' }}" name="orderCommonId">
<input type="hidden" value="{{isset($data->fields['discipline'][0]['userDisciplinaryActionId']) ? $data->fields['discipline'][0]['userDisciplinaryActionId'] : '' }}" name="id">
<div class="mt-20" id="discipline" style="border-top:1px solid #efefef;">
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
            <h4>İşçinin cəlb edildiyi intizam tənbehi: </h4>
            <select name="disciplineType" id="disciplineType" class="form-control select">
                <option></option>
                <option value="1" {{ isset($data->fields['discipline'][0]['listDisciplinaryActionId']->id) ? $data->fields['discipline'][0]['listDisciplinaryActionId']->id == 1 ? 'selected' : '' : ''}}>Azərbaycan Respublikası Əmək Məcəlləsinin 186-cı maddəsinin 2-ci hissəsinin “a” bəndinə əsasən töhmət verilsin</option>
                <option value="2" {{ isset($data->fields['discipline'][0]['listDisciplinaryActionId']->id) ? $data->fields['discipline'][0]['listDisciplinaryActionId']->id == 2 ? 'selected' : '' : ''}}>Azərbaycan Respublikası Əmək Məcəlləsinin 186-cı maddəsinin 2-ci hissəsinin “b” bəndinə əsasən sonuncu xəbərdarlıqla şiddətli töhmət verilsin</option>
            </select>
        </div>
        <div class="col-4">
            <h4>Əsas: </h4>
            <div class=" float-left checkbox-custom checkbox-primary text-left">
                <input type="checkbox" disabled id="strS" value="true" class="check-provision" checked="">
                <label for="strS">Struktur bölmə rəhbərinin təqdimatı</label>
            </div>
            <div class="ml-40 float-left checkbox-custom checkbox-primary text-left">
                <input type="checkbox" id="workerS" value="true" class="check-provision" name="workerS" {{ isset($data->fields['discipline'][0]['isExplanation']) ? $data->fields['discipline'][0]['isExplanation'] == true ? 'checked' : '' : '' }}>
                <label for="workerS" >İşçinin izahatı</label>
            </div>
        </div>
        <div class="col-3">
            <h4>Təqdimatı təqdim edən əməkdaş: </h4>
            <input type="hidden" id="executorUserIdHidden" value="{{ isset($data->fields['discipline'][0]['userId']->id) ? $data->fields['discipline'][0]['executorUserId']->id : '' }}">
            <select name="user2Id" id="user2Id" class="form-control select" data-url="{{ route('users','select') }}" required>
                <option value="{{ isset($data->fields['discipline'][0]['executorUserId']->id) ? $data->fields['discipline'][0]['executorUserId']->id : ''}}" selected> {{ isset($data->fields['discipline'][0]['executorUserId']->firstName) && isset($data->fields['discipline'][0]['executorUserId']->lastName) ? $data->fields['discipline'][0]['executorUserId']->firstName .' '. $data->fields['discipline'][0]['executorUserId']->lastName . ' ' . $data->fields['discipline'][0]['executorUserId']->patronymic : '' }} </option>
            </select>
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

    $('#structureId').selectObj('structureId', 'ordersModal');

    $('#structureId').on('select2:select', function () {

        $('#userId').empty();

        $('#positionId').empty();

        let url = $('#positionId').data('url') + '/' +  $(this).val();

        $('#positionId').selectObj('positionId' ,false, url);

    });


    $('#positionId').on('select2:select', function () {

        $('#userId').empty();

        let url = $('#userId').data('url') + '/' +  $(this).val();

        $('#userId').selectObj('userId' , false, url);

    });

    $('#userId').selectObj('userId', 'ordersModal');

    $('#user2Id').selectObj('user2Id', 'ordersModal');


    $('#userId').on('select2:select', function () {

//        $('#structureName').attr('value') == '';
//        $('#positionName').attr('value') == '';

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
