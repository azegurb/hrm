<input type="hidden" name="orderTypeLabel" value="appointmentDTO">

<input type="hidden" name="userPosition1" id="userPosition1">
<input type="hidden" name="userPosition2" id="userPosition2">

<div class="mt-20" id="financialAid" style="border-top:1px solid #efefef;">
    <div class="col-12">
        <div class="row">
            <div class="col-1"></div>

            <div class="col-2">
                <h4>Başlama tarixi: </h4>
                <input type="text" data-plugin="datepicker" id="" name="startDate" class="form-control">
            </div>
            <div class=" col-2 checkbox-custom checkbox-primary text-left pt-25 ml-50">
                <input type="checkbox" id="isLimited" value="true" class="check-provision" name="status">
                <label for="10126">Müddətli</label>
            </div>
            <div class="col-2" style="display: none;" id="dayForLimited">
                <h4>Bitmə tarixi: </h4>
                <input type="text" data-plugin="datepicker" id="" name="endDate" class="form-control">
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-4">
                <h4>1-ci əməkdaş: </h4>
                <select name="user1Id" id="user1Id" class="userId form-control select" data-url="{{ route('users','select') }}" required>
                    <option></option>
                </select>
            </div>
            <div class="col-3">
                <h4>Struktur: </h4>
                <input type="text" disabled id="structureName" name="" class="form-control">
            </div>
            <div class="col-3">
                <h4>Vəzifə: </h4>
                <input type="text" disabled name="" id="positionName" class="form-control">
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-4">
                <h4>2-ci əməkdaş: </h4>
                <select name="user2Id" id="user2Id" class="userId form-control select" data-url="{{ route('users','select') }}" required>
                    <option></option>
                </select>
            </div>
            <div class="col-3">
                <h4>Struktur: </h4>
                <input type="text" disabled id="structureName2" name="" class="form-control">
            </div>
            <div class="col-3">
                <h4>Vəzifə: </h4>
                <input type="text" disabled name="" id="positionName2" class="form-control">
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {



    })
    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });

    /* Structure > Position > Users select */

    $('#user1Id').selectObj('user1Id', 'ordersModal');

    $('#user1Id').on('select2:select', function () {

        // Define variables
        var userId =  $(this).val();
        var url    =  'orders/get-position-by-userId/' + userId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                console.log(response.id);
                write(response.positionId.posNameId.name,response.id,response.positionId.structureId.name);


            },
            error: function(error){

                console.log('error yarandi');
            }
        });


        function write(posName,posId,strName){
            var posName = posName;
            var posId   = posId;
            var strName = strName;

            $('#structureName').val(strName);
            $('#positionName').val(posName);
            $('#userPosition1').val(posId);

        }



//        let url = $('#positionId').data('url') + '/' +  $(this).val();

        $('#positionId').selectObj('positionId' ,false, url);

    });


    /* user2 */
    $('#user2Id').selectObj('user2Id', 'ordersModal');

    $('#user2Id').on('select2:select', function () {

        // Define variables
        var userId =  $(this).val();
        var url    =  'orders/get-position-by-userId/' + userId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
//                console.log(response);
                write(response.positionId.posNameId.name,response.id,response.positionId.structureId.name);


            },
            error: function(error){

                console.log('error yarandi');
            }
        });


        function write(posName,posId,strName){
            var posName = posName;
            var posId   = posId;
            var strName = strName;

            $('#structureName2').val(strName);
            $('#positionName2').val(posName);
            $('#userPosition2').val(posId);

        }



//        let url = $('#positionId').data('url') + '/' +  $(this).val();

        $('#positionId').selectObj('positionId' ,false, url);

    });


    $('[data-plugin="datepicker"]').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });
    $('#orderDate').on('dateChange', function () {

        var orderDate = $(this).val();
        console.log(orderDate);
    });


    $('#dayForLimited').css("display","none");

    $('#isLimited').change(function () {
        checkStatus = this.checked;

        if(checkStatus == true){
            $('#dayForLimited').css("display","block");
            $('#limitDay').attr("required","");
        }else {
            $('#dayForLimited').css("display","none");
            $('#limitDay').removeAttr("required");
        }

        
    });


</script>