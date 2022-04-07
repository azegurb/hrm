<input type="hidden" name="orderTypeLabel" value="damageCompensation">
<input type="hidden" name="relUserPaymentId" value="@if(isset($array->relUserPaymentId)){{$array->relUserPaymentId}}@endif">
<input type="hidden" name="orderCommonId"    value="@if(isset($array->orderCommonId)){{$array->orderCommonId}}@endif">
<div class="mt-20" id="damageCompensation" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-3">
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


        <div class="col-3">
            <h4>Ödənilmə başlanılan tarix: </h4>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="icon md-calendar" aria-hidden="true"></i>
                </span>
                <input type="text" id="paymentStartDate" name="paymentStartDate" class="form-control" data-plugin="datepicker" required>
            </div>
        </div>
        <div class="col-3 mt-30">
            <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                <input type="radio" id="percent" name="isPercent" value="true" checked/>
                <label for="percent">Faizlə</label>
            </div>
            <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                <input type="radio" id="cash" name="isPercent" value="false"/>
                <label for="cash">Nəğd</label>
            </div>
        </div>
        <div class="col-3">
            <div class="row">
                <div class="col-12" id="amount">
                    <h4 id="paymentText">Ödəniş faizi:</h4>
                    <input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" required>
                </div>
            </div>
        </div>
        <div class="col-6"></div>
        <div class="col-6">
            <h4>Qeyd: </h4>
            <textarea name="note" id="note" cols="30" rows="5" class="form-control"></textarea>
        </div>
        <div class="col-6">
            <h4>Əsas: </h4>
            <textarea name="damageOrderBasis" id="damageOrderBasis" cols="30" rows="5" class="form-control"></textarea>
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


    /* load select2 and datapicker */

    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });

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
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });




    /*
    *
    * When isPercent value is changed change text input from cash to percent or vice versa
    *
    * */

    $('input[name="isPercent"]').on('click', function () {

        if ($(this).prop('id') === 'percent') {

            $('#amount').html('<h4 id="paymentText">Ödəniş faizi:</h4>' + '<input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" required>');

        } else {

            $('#amount').html('<h4 id="paymentText">Ödəniş məbləği:</h4>' + '<input type="number" step="any" name="valueSum" class="form-control" min="1" required>');
        }

    });

</script>