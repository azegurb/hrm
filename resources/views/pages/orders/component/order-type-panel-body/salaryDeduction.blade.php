<input type="hidden" name="orderTypeLabel" value="salaryDeduction">
<input type="hidden" name="relUserPaymentId" value="@if(isset($array->relUserPaymentId)){{$array->relUserPaymentId}}@endif">
<input type="hidden" name="orderCommonId"    value="@if(isset($array->orderCommonId)){{$array->orderCommonId}}@endif">
<div class="mt-20 multi" id="financialAid" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-4">
            <h4>Əməkdaş: </h4>
            <input type="hidden" value="@if(isset($array->userId['id'])){{$array->userId['id']}}@endif" id="userIdHidden">
            <select name="userId" id="userId" class="userId form-control select" data-url="{{ route('users','select') }}" required>
                <option value="@if(isset($array->userId['id'])){{$array->userId['id']}}@endif" selected>@if(isset($array->userId['firstName']) && isset($array->userId['lastName'])){{$array->userId['firstName']}} {{$array->userId['lastName']}}@endif</option>
            </select>
        </div>

        <div class="col-3">
            <h4>Struktur: </h4>
            <input type="text" name="" id="structureName" disabled="" class="form-control">
        </div>
        <div class="col-3">
            <h4>Vəzifə: </h4>
            <input type="text" name="" id="positionName" disabled="" class="form-control">
        </div>
        <div class="col-1"></div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-3">
            <h4>Tutulma məbləği(AZN): </h4>
            <input type="number" name="value" min="1" class="form-control">
        </div>
        <div class="form-group">
            <h4>Başlama və bitiş tarixi:</h4>
            <div class="input-daterange" data-plugin="datepicker">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="icon md-calendar" aria-hidden="true"></i>
                        </span>
                    <input type="text" class="form-control" name="input_startDate" value="@if(isset($array->startDate)) {{$array->startDate}} @endif" required/>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control" name="input_endDate" value="@if(isset($array->endDate)) {{$array->endDate}} @endif" required/>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });

    /* Structure > Position > Users select */

    $('.userId').selectObj('userId', 'ordersModal');

    $('#userId').on('select2:select', function () {

        // Define variables
        var userId =  $(this).val();
        var url    =  'orders/get-position-by-userId/' + userId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
//                console.log(response);
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

    $('[data-plugin="datepicker"]').datepicker({
        format: 'mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1,
        viewMode: "months",
        minViewMode: "months",
        todayHighlight: true,
        language:'az'
    });
    $('#orderDate').on('dateChange', function () {

        var orderDate = $(this).val();
        console.log(orderDate);
    });

    $('[data-plugin="datepicker"]').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });

</script>
