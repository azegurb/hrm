<input type="hidden" name="orderTypeLabel" value="salaryAddition">

{{-- get uniqid for each iteration of the view --}}
@php $id = uniqid(); @endphp

<div class="mt-20" id="appointment{{$id}}" style="border-top:1px solid #efefef;">

    <div class="row">
        @if(isset($objwhle))
            <input type="hidden" name="orderCommonId" value="{{ $objwhole->id }}">
        @endif

        <div class="col-md-12">
            @if(isset($objwhle))
            <input type="hidden" name="salaryAdditionId" value="{{$objwhole->fields['salaryAddition']['ordersalaryaddition']->data[0]->id}}">
            @endif
                <button type="button" class="close" onclick="drop('appointment{{$id}}')"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">

                </div>

                <div class="col-md-6" id="typo-dynamic{{$id}}">

                </div>

                <div class="col-md-3">
                    @if(isset($array))
                        {{--<button class="btn btn-primary mt-35 float-right" type="button"--}}
                                {{--onclick="getFile('{{route('work-experiences.get-file' ,--}}
                                            {{--[--}}
                                                {{--$objwhole->fields['salaryAddition']['userInfo'],--}}
                                                {{--$objwhole->fields['salaryAddition']['reluserpayment'],--}}
                                            {{--])--}}
                                         {{--}}')">--}}
                            {{--<i class="icon md-assignment" aria-hidden="true"></i> Əmr--}}
                        {{--</button>--}}
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">

                    <div class="employee-select">
                        <h4 class="example-title">Əməkdaş: </h4>

                        <select name="userId" id="userId" class="emp form-control select"
                                data-url="{{ route('users','select') }}" required>
                            @if(isset($objwhole))
                                {{--@foreach($objwhole->employees as $employee)--}}
                                    <option value="{{ $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->userId->id }}" selected>{{ $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->userId->firstName.' '.$objwhole->fields['salaryAddition']['reluserpayment']->data[0]->userId->lastName }}</option>
                                {{--@endforeach--}}
                            @endif
                        </select>
                    </div>

                    @if(isset($array) )
                        <input type="hidden" name="userPositionId"
                               value="{{ isset($objwhole->fields['userInfo']->positionId->id) ? $objwhole->fields['userInfo']->positionId->id : '' }}">
                    @endif
                </div>
                <div class="col-md-2">
                    <h4>Struktur:</h4>

                    <select class="form-control structureName select" id="listStructures{{$id}}"
                            data-url="{{ route('structures.list') }}">
                        @if(isset($array))
                            <option value="{{ $objwhole->fields['salaryAddition']['userInfo']->positionId->structureId->id }}"
                                    selected>@if($objwhole->fields['salaryAddition']['userInfo']->positionId->structureId->parentId!=null){{  $objwhole->fields['salaryAddition']['userInfo']->positionId->structureId->parentId->name.' '.$objwhole->fields['salaryAddition']['userInfo']->positionId->structureId->name }} @else {{  $objwhole->fields['salaryAddition']['userInfo']->positionId->structureId->name }} @endif</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <h4>Vəzifə:</h4>
                    <select class="form-control posName select" id="listPositionNames{{$id}}"
                            data-url="{{ route('position-names-search.list') }}">
                        @if(isset($objwhole))
                            <option value="{{ $objwhole->fields['salaryAddition']['userInfo']->positionId->posNameId->id }}"
                                    selected>{{ $objwhole->fields['salaryAddition']['userInfo']->positionId->posNameId->name }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <h4>Əmək haqqı:</h4>
                    <div>
                        <select name="positionId[{{$id}}]" class="form-control salary select" id="positionPayment{{$id}}"
                                data-url="{{ route('position-payment.get') }}">
                            @if(isset($objwhole->fields))
                                <option value="{{ isset($objwhole->fields['salaryAddition']['userInfo']->payment[0]->id ) ? $objwhole->fields['salaryAddition']['userInfo']->payment[0]->id : '' }}" selected>{{ $objwhole->fields['salaryAddition']['userInfo']->payment[0]->value }}</option>
                            @endif
                        </select>
                    </div>

                </div>

                <div class="col-md-2">
                    <h4>Başlama tarixi :</h4>
                    <input style="font-size: 15px;" type="text" id="startDate{{$id}}"
                           value="@if(isset($objwhole->fields)) {{ date('d.m.Y', strtotime($objwhole->fields['salaryAddition']['reluserpayment']->data[0]->startDate)) }} @endif"
                           class="order-related-date form-control" name="startDate" data-plugin="datepicker">
                </div>

                <div class="col-md-2">
                    <div class="row">
                        @if(isset($objwhole) && $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->isPercent==1)
                            <?php $ispercent='checked';$isnumber='';?>
                        @elseif(isset($objwhole) && $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->isPercent==0)
                            <?php $ispercent='';$isnumber='checked';?>

                        @else
                            <?php $ispercent='checked';$isnumber='';?>
                        @endif
                        <div class="col-md-4 radio-custom radio-primary float-left inline-block" style="padding-top: 30px !important;">
                            <input type="radio" {{$ispercent}} id="percent{{$id}}" name="isPercent[{{$id}}]" class="isPercentClass" value="true" checked/>
                            <label for="percent">Faizlə</label>

                        </div>
                        <div class="col-md-4 radio-custom radio-primary float-left inline-block pb-15" style="padding-top: 30px !important;">
                            <input type="radio" {{$isnumber}} id="cash{{$id}}" name="isPercent[{{$id}}]" class="isAmountClass" value="false" />
                            <label for="cash">Məbləğ</label>
                        </div>

                    </div>

                </div>


            </div>

        </div>

        <div class="col-md-12">
            <div class="row">
                {{--<div class="col-md-2">--}}
                    {{--<div id="#timed-month{{$id}}">--}}
                        {{--<h4>Müddət (ay):</h4>--}}
                        {{--<input type="number" class="form-control" name="duration[{{$id}}]" id="duration{{$id}}"--}}
                               {{--value="@if(isset($array)){{$array->appointmentMonth}}@endif">--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="col-md-6">
                    <div class="row">


                </div>

                    <div class="col-md-3">
                        <div class="fillSum">
                            @if(isset($objwhole->fields))
                                @if($ispercent!='')
                                <h4 id="paymentText">Ödəniş faizi:</h4>
                                <input type="number" step="any" name="percentSum" value="{{ $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->valus }}" class="form-control" min="1" max="100" required>
                                    @else
                                    <h4 id="paymentText">Ödəniş məbləği:</h4>
                                    <input type="number" step="any" name="numberSum" value="{{ $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->valus }}" class="form-control" min="1" required>
                                @endif

                                @else

                                <h4 id="paymentText">Ödəniş faizi:</h4>
                                <input type="number" step="any" name="percentSum" value="" class="form-control" min="1" max="100" required>

                            @endif

                        </div>
                    </div>
                      <div class="col-md-4">
                            {{--<div id="paymentMethod{{$id}}">--}}
                                {{--@if((isset($array) && isset($array->isFree == false))--}}
                                    {{--<div class="col-md-12 mt-30">--}}

                                        {{--<div class="col-md-6 radio-custom radio-primary float-left inline-block">--}}
                                            {{--<input type="radio" id="percent{{$id}}" class="isPercentClass" name="isPercent[{{$id}}]"--}}
                                                   {{--value="true" @if($array->isPercent == true){{ 'checked' }}@endif/>--}}
                                            {{--<label for="percent">Faizlə</label>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-6 radio-custom radio-primary float-left inline-block">--}}
                                            {{--<input type="radio" id="cash{{$id}}" class="isAmountClass" name="isPercent[{{$id}}]"--}}
                                                   {{--value="false" @if($array->isPercent == false){{ 'checked' }}@endif/>--}}
                                            {{--<label for="cash">Nəğd</label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row" id="amount{{$id}}">
                                @if((isset($array) && isset($array->free) && $array->isFree == false))
                                    @if ($array->isPercent == true)
                                        <div class="col-md-12">
                                            <div class="fillSum">
                                                <h4 id="paymentText{{$id}}">Ödəniş faizi:</h4>
                                                <input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1"
                                                       max="100" value="{{ $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->valus }}">
                                            </div>
                                        </div>

                                    @else

                                        <div class="col-md-12">
                                            <div class="fillSum">
                                                <h4 id="paymentText{{$id}}">Ödəniş məbləği:</h4>
                                                <input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1"
                                                       value="{{ $objwhole->fields['salaryAddition']['reluserpayment']->data[0]->isPercent }}">
                                            </div>
                                        </div>

                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('.employee-select').on('change', '.emp', function(){

        $.ajax({
            type: 'GET',
            url: '/orders/get-position-by-userId/'+$(this).val(),
            success: function (response) {


                var str='<option value="'+response.positionId.structureId.id+'">'+response.positionId.structureId.name+'</option>';
                var posStr='<option value="'+response.positionId.posNameId.id+'">'+response.positionId.posNameId.name+'</option>';
                var salaryStr='<option value="'+response.payment[0].id+'">'+response.payment[0].value+'</option>';

                $('.structureName').html(str);
                $('.posName').html(posStr);
                $('.salary').html(salaryStr);
                $('.structureName').selectObj('employee{{$id}}', 'appointment{{$id}}');

                $('#listStructures{{$id}}').selectObj('listStructures{{$id}}', 'appointment{{$id}}');

            }
        });

    })

    /* trigger default selects */

    $('#appointmentType{{$id}}').select2({width: '100%', placeholder: 'Seçilməyib'});

    $('#listPositionNames{{$id}}').select2({width: '100%', placeholder: 'Seçilməyib'});

    $('#positionPayment{{$id}}').select2({width: '100%', placeholder: 'Seçilməyib'});

    /* trigger remote selects */

    $('#userId').selectObj('userId', 'appointment{{$id}}');



    $('#listContractTypes{{$id}}').selectObj('listContractTypes{{$id}}', 'appointment{{$id}}');


    /* when list structures is selected positon names lists will be get */

    $('#listStructures{{$id}}').on('change', function () {

        /* clear position names */
        $('#listPositionNames{{$id}}').empty();

        /* empty position payment */
        $('#positionPayment{{$id}}').empty();

        let url = $('#listPositionNames{{$id}}').attr('data-url') + '/' + $(this).val();

        $('#listPositionNames{{$id}}').selectObj('listPositionNames{{$id}}', 'appointment{{$id}}', url);

    });

    {{--/* when position names is choosen then select position payment */--}}

    $('#listPositionNames{{$id}}').on('change', function () {

        let structure = $('#listStructures{{$id}}').val();

        $('#positionPayment{{$id}}').empty();

        let url = $('#positionPayment{{$id}}').attr('data-url') + '/' + $(this).val() + '/' + structure;

        $('#positionPayment{{$id}}').selectObj('positionPayment{{$id}}', 'appointment{{$id}}', url);

    });



    {{--/* when civil service is selected contract types will be changed */--}}
    {{--$('#civilService{{$id}}').on('change', function () {--}}

        {{--var protocol = window.location.protocol == "https:" ? "https://" : "http://";--}}

        {{--var host = protocol + window.location.host;--}}

        {{--var url = "";--}}

        {{--/* civil service true or false sned to back */--}}

        {{--if ($(this).is(':checked')) {--}}

            {{--$('#lbl_civilService{{$id}}').text('Bəli');--}}

            {{--url = "/helper-lists/labor-contracts/select/true";--}}

            {{--$('#listContractTypes{{$id}}').data('url', host + url);--}}

            {{--$('#listContractTypes{{$id}}').selectObj('listContractTypes{{$id}}', 'ordersModal');--}}

        {{--} else {--}}

            {{--$('#lbl_civilService{{$id}}').text('Xeyr');--}}

            {{--url = "/helper-lists/labor-contracts/select/false";--}}

            {{--$('#listContractTypes{{$id}}').data('url', host + url);--}}

            {{--$('#listContractTypes{{$id}}').selectObj('listContractTypes{{$id}}', 'ordersModal');--}}
        {{--}--}}
    {{--});--}}

    {{--/* when contract type is choosen appointment month will be appended or deleted */--}}

    {{--$('#listContractTypes{{$id}}').on('change', function () {--}}

        {{--let slabel = $(this).select2('data')[0].slabel;--}}

        {{--if (slabel == 'LWC') {--}}
            {{--$('#duration{{$id}}').parent().show();--}}
            {{--$('#duration{{$id}}').prop('disabled', false);--}}
        {{--} else {--}}
            {{--$('#duration{{$id}}').parent().hide();--}}
            {{--$('#duration{{$id}}').prop('disabled', true);--}}
        {{--}--}}

    {{--});--}}


    {{--/* trigger datepicker */--}}
    $('[data-plugin="datepicker"]').datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        autoclose: true,
        weekStart: 1
    });

    {{--/*--}}
     {{--*--}}
     {{--* Additional payment to user--}}
     {{--* */--}}

    $('body').on('click', '.isPercentClass', function () {

        $('.fillSum').html('<h4 id="paymentText">Ödəniş faizi:</h4><input type="number" step="any" name="percentSum" class="form-control" min="1" max="100" required>');

    });

    $('body').on('click', '.isAmountClass', function () {

        $('.fillSum').html('<h4 id="paymentText">Ödəniş məbləği:</h4><input type="number" step="any" name="numberSum" class="form-control" min="1" required>');

    });


    {{--$('#isPaid{{$id}}').on('change', function () {--}}


        {{--if ($(this).is(':checked')) {--}}

            {{--$('#paymentMethod{{$id}}').html(   '<div class="col-md-12 mt-30">' +--}}
                {{--'<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +--}}
                {{--'<input type="radio" id="percent{{$id}}" name="isPercent[{{$id}}]" class="isPercentClass" value="true" checked/>' +--}}
                {{--'<label for="percent">Faizlə</label>' +--}}
                {{--'</div>' +--}}
                {{--'<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +--}}
                {{--'<input type="radio" id="cash{{$id}}" name="isPercent[{{$id}}]" class="isAmountClass" value="false" />' +--}}
                {{--'<label for="cash">Məbləğ</label>' +--}}
                {{--'</div>' +--}}
                {{--'</div>');--}}

            {{--$('#amount{{$id}}').html(  '<div class="col-md-12"><div class="fillSum">' +--}}
                {{--'<h4 id="paymentText">Ödəniş faizi:</h4>' +--}}
                {{--'<input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" max="100" required>' +--}}
                {{--'</div></div>');--}}


            {{--$('input[name="isPercent"]').on('click', function () {--}}


                {{--if ($(this).prop('id') === 'percent') {--}}

                    {{--$('#amount{{$id}}').html(  '<div class="col-md-12">' +--}}
                        {{--'<h4 id="paymentText">Ödəniş faizi:</h4>' +--}}
                        {{--'<input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" max="100" required>' +--}}
                        {{--'</div>');--}}

                {{--} else {--}}

                    {{--$('#amount{{$id}}').html(  '<div class="col-md-12">' +--}}
                        {{--'<h4 id="paymentText">Ödəniş məbləği:</h4>' +--}}
                        {{--'<input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" required>' +--}}
                        {{--'</div>');--}}
                {{--}--}}

            {{--});--}}

            {{--/* change label text */--}}
            {{--$('#lblPayment{{$id}}').text('Bəli');--}}

            {{--/* append payment type id */--}}
{{--//            setPaymentTypeId();--}}

            {{--/* get user payment */--}}
            {{--getIndividualUserPayment();--}}

        {{--} else {--}}

            {{--/* change label text */--}}
            {{--$('#lblPayment{{$id}}').text('Xeyr');--}}

            {{--$('#paymentMethod{{$id}}').empty();--}}
            {{--$('#amount{{$id}}').empty();--}}

        {{--}--}}

    {{--});--}}

    {{--/* when is paid is choosen then add PaymentTypeId to hidden input */--}}

    {{--let setPaymentTypeId = function () {--}}

        {{--$.ajax({--}}
            {{--type: 'GET',--}}
            {{--url: '{{ route('payment-type-id-by-label.get', 'Individual') }}',--}}
            {{--success: function (response) {--}}

                {{--if (response.code == 200) {--}}

                    {{--$('#amount{{$id}}').append('<input type="hidden" name="paymentTypeId[{{$id}}]" value="' + response.data[0].id + '">');--}}

                {{--}--}}

            {{--}--}}
        {{--});--}}

    {{--};--}}

    {{--/* get user payment and append */--}}
    {{--let getIndividualUserPayment = () => {--}}

        {{--/* user */--}}
        {{--let userId = $('#employee{{$id}}').val();--}}

        {{--/* payment type */--}}
        {{--let paymentTypeLabel = 'Individual';--}}

        {{--$.ajax({--}}
            {{--url: '/staff-table/get-individual-user-payment/' + userId + '/' + paymentTypeLabel,--}}
            {{--type: 'GET',--}}
            {{--success: function(response) {--}}

                {{--if (response.code == 200)--}}
                {{--{--}}
                    {{--if (response.data[0].isPercent == false)--}}
                    {{--{--}}
                        {{--$('#cash{{$id}}').trigger('click');--}}
                    {{--}--}}

                    {{--$('input[name="valueSum[{{$id}}]"]').val(response.data[0].valus);--}}

                {{--} else--}}
                {{--{--}}
                    {{--throw new Error('Response is not OK');--}}
                {{--}--}}

            {{--},--}}
            {{--error: function(error){--}}

                {{--console.log(error);--}}
            {{--}--}}
        {{--});--}}


    {{--};--}}

    {{--/* trigger jquery switches */--}}

    {{--new Switchery(document.querySelector('#isPaid{{$id}}'), {--}}
        {{--color: '#3f51b5'--}}
    {{--});--}}

    {{--new Switchery(document.querySelector('#civilService{{$id}}'), {--}}
        {{--color: '#3f51b5'--}}
    {{--});--}}

    {{--/*--}}
     {{--*--}}
     {{--* When appointment type is changed options will be changed--}}
     {{--*--}}
     {{--* */--}}
    {{--$('#row5-{{$id}}').css("display","none");--}}

    {{--$('#appointmentType{{$id}}').on('change', function () {--}}

        {{--/* if appointment is hiring new employee then you need to note trialPeriod */--}}
        {{--if ($(this).val() == 1) {--}}

            {{--$('#row5-{{$id}}').css("display","none");--}}
            {{--$('#typo-dynamic{{$id}}').css("display","block");--}}
            {{--$('#row3-{{$id}}').css("display","block");--}}
            {{--$('#row2-{{$id}}').css("display","block");--}}

            {{--$('#typo-dynamic{{$id}}').html('<div class="row">' +--}}
                {{--'<div class="col-md-4">' +--}}
                {{--'<h4>Sınaq müddəti (ay): </h4>' +--}}
                {{--'<input type="number" step="1" name="trialPeriodMonth[{{$id}}]" class="form-control">' +--}}
                {{--'</div>' +--}}
                {{--'</div>');--}}

        {{--} else {--}}

            {{--/* if appointment is transfer then you need to see old positionId */--}}

            {{--let html =  '<div class="row">' +--}}
                {{--'<div class="col-md-6">' +--}}
                {{--'<h4>Cari struktur:</h4>' +--}}
                {{--'<select class="form-control" id="listStructuresOld{{$id}}" readonly>' +--}}

                {{--'</select>' +--}}
                {{--'</div>' +--}}
                {{--'<div class="col-md-6">' +--}}
                {{--'<h4>Cari vəzifə:</h4>' +--}}
                {{--'<select name="fromPositionId[{{$id}}]" class="form-control" id="listPositionNamesOld{{$id}}" readonly>' +--}}

                {{--'</select>' +--}}
                {{--'</div>' +--}}
                {{--'</div>';--}}

            {{--/* append html */--}}
            {{--$('#typo-dynamic{{$id}}').html(html);--}}

        {{--}--}}

    {{--});--}}

    {{--/* when employee is selected find fromPositionId */--}}

    {{--$('#employee{{$id}}').on('change', function () {--}}

        {{--/* function depends on appointment type */--}}
        {{--let appointmentType = $('#appointmentType{{$id}}').val();--}}
        {{--let user = $(this).val();--}}

        {{--if (appointmentType == 2) {--}}

            {{--/* get user position */--}}
            {{--$.ajax({--}}
                {{--type: 'GET',--}}
                {{--url:  '/staff-table/get-position-by-user/' + user,--}}
                {{--success: function (response) {--}}

                    {{--if (response.code == 200) {--}}

                        {{--/* generate option for structure */--}}
                        {{--let structure = $('<option></option>')--}}
                            {{--.val(1)--}}
                            {{--.text(response.data[0].structureIdName)--}}
                            {{--.prop('selected', true);--}}

                        {{--/* generate option for position id */--}}
                        {{--let position  = $('<option></option>')--}}
                            {{--.val(response.data[0].positionIdId)--}}
                            {{--.text(response.data[0].posNameIdName)--}}
                            {{--.prop('selected', true);--}}

                        {{--/* append structure and position */--}}
                        {{--structure.appendTo($('#listStructuresOld{{$id}}'));--}}
                        {{--position.appendTo($('#listPositionNamesOld{{$id}}'));--}}

                    {{--}--}}

                {{--}--}}
            {{--});--}}

        {{--}--}}

    {{--});--}}

</script>