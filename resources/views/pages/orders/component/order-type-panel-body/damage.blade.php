<input type="hidden" name="orderTypeLabel" value="damage">
<input type="hidden" name="relUserPaymentId" value="@if(isset($array->relUserPaymentId)){{$array->relUserPaymentId}}@endif">
<input type="hidden" name="orderCommonId"    value="@if(isset($array->orderCommonId)){{$array->orderCommonId}}@endif">
<input type="hidden" name="positionId" id="positionIdN" value="@if(isset($array->data[0])){{$array->data[0]->positionId->id}}@endif">
<div class="mt-20" id="damage" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-4">
            <h4>Əməkdaş: </h4>

            <input type="hidden" value="@if(isset($array->data[0]) && is_array($array->data[0]) && $array->data[0]->relUserPaymentsId->userId->id)){{$array->data[0]->relUserPaymentsId->userId->id}}@endif" id="userIdHidden">

            <select name="userId" id="userId" class="userId form-control select" data-url="{{ route('users','select') }}" required>
                <option value="@if(isset($array->data[0]) && $array->data[0]->relUserPaymentsId->userId->id){{$array->data[0]->relUserPaymentsId->userId->id}}@endif" selected>@if(isset($array->data[0]) && isset($array->data[0]->relUserPaymentsId->userId->firstName)){{$array->data[0]->relUserPaymentsId->userId->firstName.' '.$array->data[0]->relUserPaymentsId->userId->lastName}} @endif</option>
            </select>

        </div>

        <div class="col-3">
            <h4>Struktur: </h4>

            <input type="text" name="" id="structureName" value="@if(isset($array->data[0])){{$array->data[0]->positionId->structureId->name.' / '.$array->data[0]->positionId->structureId->parentId->name}}@endif" disabled="" class="form-control">
        </div>
        <div class="col-3">
            <h4>Vəzifə: </h4>
            <input type="text" name="" id="positionName" disabled="" value="@if(isset($array->data[0])){{$array->data[0]->positionId->posNameId->name}}@endif" class="form-control">
        </div>

        <div class="col-1"></div>
        <div class="col-1"></div>

        <div class="col-3">
            <h4>Tutulma məbləği (AZN): </h4>

            <input type="number" step="any" min="1" name="amount" class="amount form-control" value="@if(isset($array->data) && $array->data[0]->valueTotal){{$array->data[0]->valueTotal}}@endif" required>
        </div>
        <div class="col-4">
            <h4>Dəymiş ziyanın tutulacağı aylar:</h4>
            <?php
            if(isset($array->data[0])){
                $startDate=date('m.Y', strtotime($array->data[0]->relUserPaymentsId->startDate));
                $endDate=date('m.Y', strtotime($array->data[0]->relUserPaymentsId->endDate));
            }

            ?>
            <div class="input-daterange" data-plugin="datepicker">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="icon md-calendar" aria-hidden="true"></i>
                        </span>
                    <input type="text" class="form-control damageStartDate" name="input_startDate" value="@if(isset($startDate)) {{$startDate}} @endif" required/>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control damageEndDate" name="input_endDate" value="@if(isset($endDate)) {{$endDate}} @endif" required/>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <h4> Aylıq düşən məbləğ</h4>
            <input type="number" id="fillSum" step="any" min="1" name="amountSingle" class="form-control" value="@if(isset($array->data[0])){{$array->data[0]->relUserPaymentsId->valus}}@endif" required>

        </div>

    </div>
</div>

@if(isset($array->userId['id']))
    <script>
        $(document).ready(function () {

            // Define variables
            let userId =  $('#userIdHidden').val();

            let url    =  'orders/get-position-by-userId/' + userId;


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
        });
    </script>
@endif

<script>
    $(document).ready(function () {


        $('.damageEndDate').on('changeDate', function () {

            if($('.amount').val()==''){

                swal('Diqqət!', 'Məbləği seçməlisiz!', 'info');

                return false;
            }
            let url    =  'orders/get-date-diff/' + $('.damageStartDate').val()+'/'+ $('.damageEndDate').val()+'/'+$('.amount').val();
            // Send AJAX request
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {

                    $('#fillSum').val(response)
                },
                error: function(error){

                    console.log('Xeta');
                }
            });

        });

        $('.damageStartDate').on('changeDate', function () {

            if($('.amount').val()==''){

                swal('Diqqət!', 'Məbləği seçməlisiz!', 'info');

                return false;
            }
            let url    =  'orders/get-date-diff/' + $('.damageStartDate').val()+'/'+ $('.damageEndDate').val()+'/'+$('.amount').val();

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {

                    $('#fillSum').val(response)
                },
                error: function(error){

                    console.log('Xeta');
                }
            });

        });

    });
    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });

    /* Structure > Position > Users select */

    $('.userId').selectObj('userId', 'ordersModal');

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

                $('#positionIdN').val(response.positionId.id)
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
    $('#orderDate').on('changeDate', function () {

        var startDate = $(this).val();
        console.log(startDate);
        var day = startDate.split('.')[0];
        var month = startDate.split('.')[1];
        var year  = startDate.split('.')[2];

        $('.damageStartDate').datepicker('update', new Date(parseInt(year), parseInt(month)-1 , parseInt(day)));
        $('.damageEndDate').datepicker('update', new Date(parseInt(year), parseInt(month) , parseInt(day)));

    });

    $('#damage').on('blur', '.amount', function () {

        if($(this).val()==''){

            swal('Diqqət!', 'Məbləği seçməlisiz!', 'info');

            return false;
        }
        let url    =  'orders/get-date-diff/' + $('.damageStartDate').val()+'/'+ $('.damageEndDate').val()+'/'+$('.amount').val();
        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {

                $('#fillSum').val(response)
            },
            error: function(error){

                console.log('Xeta');
            }
        });
    })

</script>