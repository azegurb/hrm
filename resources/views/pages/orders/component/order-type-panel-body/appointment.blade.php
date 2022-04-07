<input type="hidden" name="orderTypeLabel" value="appointment">

{{-- get uniqid for each iteration of the view --}}
@php $id = uniqid(); @endphp

<div class="mt-20" id="appointment{{$id}}" style="border-top:1px solid #efefef;">
    <div class="row">
        @if(isset($array))
            <input type="hidden" name="orderAppointmentId[{{$id}}]" value="{{ $array->orderAppointmentId }}">
        @endif

        <div class="col-md-12">
            <input type="hidden" name="appointmentList[]" value="{{$id}}">
            <button type="button" class="close" onclick="drop('appointment{{$id}}')"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <h4>Təyinatın növü:</h4>
                    <select class="form-control select" id="appointmentType{{$id}}" name="appointmentType[{{$id}}]" required>
                        <option></option>
                        @if(isset($array))
                            @if($array->appointmentType == 1)
                                <option value="1" selected>İşə qəbul</option>
                                <option value="2">Yerdəyişmə</option>
                            @else
                                <option value="1">İşə qəbul</option>
                                <option value="2" selected>Yerdəyişmə</option>
                            @endif
                        @else
                            <option value="1">İşə qəbul</option>
                            <option value="2">Yerdəyişmə</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6" id="typo-dynamic{{$id}}">
                    @if(isset($array) && $array->appointmentType == 2)
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Cari struktur:</h4>
                                <select class="form-control" id="listStructuresOld{{$id}}" name="structureOld[]" readonly>
                                    <option value="1" selected>{{ $array->structureOld }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4>Cari vəzifə:</h4>
                                <select name="fromPositionId[{{$id}}]" class="form-control" id="listPositionNamesOld{{$id}}"
                                        readonly>
                                    <option value="{{ $array->fromPositionId['id'] }}"
                                            selected>{{ $array->fromPositionId['text'] }}</option>
                                </select>
                            </div>
                        </div>
                    @elseif(isset($array) && $array->appointmentType == 1)
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Sınaq müddəti (ay): </h4>
                                <input type="number" step="1" name="trialPeriodMonth[{{$id}}]" class="form-control"
                                       value="{{ $array->trialPeriodMonth }}">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-3">
                    @if(isset($array))
                        <button class="btn btn-primary mt-35 float-right" type="button"
                                onclick="getFile('{{route('work-experiences.get-file' ,
                                            [
                                                $array->position[0]['userPositionId'],
                                                $array->employees[0]['id']
                                            ])
                                         }}')">
                            <i class="icon md-assignment" aria-hidden="true"></i> Əmək Müqaviləsi
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">

                    <div class="employee-select">
                        <h4 class="example-title">Əməkdaş: </h4>
                        <select name="employee[{{$id}}]" id="employee{{$id}}" class="form-control select"
                                data-url="{{ route('users','select') }}" required>
                            @if(isset($array))
                                @foreach($array->employees as $employee)
                                    <option value="{{ $employee['id'] }}" selected>{{ $employee['text'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @if(isset($array) )
                        <input type="hidden" name="userPositionId[{{ $array->employees[0]['id'] }}]"
                                   value="{{ isset($array->position[0]['userPositionId']) ? $array->position[0]['userPositionId'] : '' }}">
                    @endif
                </div>
                <div class="col-md-2">
                    <h4>Struktur:</h4>
                    <select class="form-control select" id="listStructures{{$id}}"
                            data-url="{{ route('structures.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->structure['id'] }}"
                                    selected>{{  $array->structure['parent'].' '.$array->structure['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <h4>Vəzifə:</h4>
                    <select class="form-control select" id="listPositionNames{{$id}}"
                            data-url="{{ route('position-names-search.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->position_name['id'] }}"
                                    selected>{{ $array->position_name['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <h4>Əmək haqqı:</h4>
                    <div>
                        <select name="positionId[{{$id}}]" class="form-control select" id="positionPayment{{$id}}"
                                data-url="{{ route('position-payment.get') }}">
                            @if(isset($array))
                                <option value="{{ isset($array->position[0]['positionId']) ? $array->position[0]['positionId'] : '' }}" selected>{{ $array->wage }}</option>
                            @endif
                        </select>
                    </div>

                </div>
                <div class="col-md-2">
                    <h4>Başlama tarixi :</h4>
                    <input style="font-size: 15px;" type="text" id="startDate{{$id}}"
                           value="@if(isset($array)) {{ $array->startDate }} @endif"
                           class="order-related-date form-control" name="startDate[{{$id}}]" data-plugin="datepicker">
                </div>
                <div class="col-md-2">
                    <h4>Dövlət qulluğu:</h4>
                    <div class="float-left mr-20">
                        <input type="checkbox" id="civilService{{$id}}" name="civilService[{{$id}}]"
                        @if(isset($array) && $array->civilService == true) {{ 'checked' }} @endif
                        />
                    </div>
                    <label class="pt-3" id="lbl_civilService{{$id}}" for="civilService{{$id}}"> Xeyr</label>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h4>Müqavilənin tipi:</h4>
                    <select class="form-control select" name="contract_type[{{$id}}]" id="listContractTypes{{$id}}"
                            data-url="{{ route('labor-contracts-select', 'false') }}" required>
                        @if(isset($array))
                            <option value="{{ $array->contract_type['id'] }}" selected>{{ $array->contract_type['text'] }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <div id="#timed-month{{$id}}">
                        <h4>Müddət (ay):</h4>
                        <input type="number" class="form-control" name="duration[{{$id}}]" id="duration{{$id}}"
                               value="@if(isset($array)){{$array->appointmentMonth}}@endif">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Əlavə əmək haqqı: </h4>
                            <input type="checkbox" id="isPaid{{$id}}" name="isFree[{{$id}}]"
                            @if(isset($array) && $array->isFree == false) {{ 'value=false checked' }} @else {{ 'value=true' }} @endif />
                            <label for="isPaid" id="lblPayment{{$id}}">Xeyr</label>
                        </div>

                        <div class="col-md-4">
                            <div id="paymentMethod{{$id}}">
                                @if((isset($array) && $array->isFree == false))
                                    <div class="col-md-12 mt-30">

                                        <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                                            <input type="radio" id="percent{{$id}}" class="isPercentClass" name="isPercent[{{$id}}]"
                                                   value="true" @if($array->isPercent == true){{ 'checked' }}@endif/>
                                            <label for="percent">Faizlə</label>
                                        </div>
                                        <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                                            <input type="radio" id="cash{{$id}}" class="isAmountClass" name="isPercent[{{$id}}]"
                                                   value="false" @if($array->isPercent == false){{ 'checked' }}@endif/>
                                            <label for="cash">Nəğd</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row" id="amount{{$id}}">
                                @if((isset($array) && $array->isFree == false))
                                    @if ($array->isPercent == true)
                                        <div class="col-md-12">
                                            <div class="fillSum">
                                            <h4 id="paymentText{{$id}}">Ödəniş faizi:</h4>
                                            <input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1"
                                                   max="100" value="{{ $array->valueSum }}">
                                            </div>
                                        </div>

                                    @else

                                        <div class="col-md-12">
                                            <div class="fillSum">
                                            <h4 id="paymentText{{$id}}">Ödəniş məbləği:</h4>
                                            <input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1"
                                                   value="{{ $array->valueSum }}">
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

    @if(!isset($array) || (isset($array) && ($array->duration=="" || $array->duration != true)))
        $('#duration{{$id}}').parent().hide();
    @endif

    /* trigger default selects */

    $('#appointmentType{{$id}}').select2({width: '100%', placeholder: 'Seçilməyib'});

    $('#listPositionNames{{$id}}').select2({width: '100%', placeholder: 'Seçilməyib'});

    $('#positionPayment{{$id}}').select2({width: '100%', placeholder: 'Seçilməyib'});

    /* trigger remote selects */

    $('#employee{{$id}}').selectObj('employee{{$id}}', 'appointment{{$id}}');

    $('#listStructures{{$id}}').selectObj('listStructures{{$id}}', 'appointment{{$id}}');

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

    /* when position names is choosen then select position payment */

    $('#listPositionNames{{$id}}').on('change', function () {

        let structure = $('#listStructures{{$id}}').val();

        $('#positionPayment{{$id}}').empty();

        let url = $('#positionPayment{{$id}}').attr('data-url') + '/' + $(this).val() + '/' + structure;

        $('#positionPayment{{$id}}').selectObj('positionPayment{{$id}}', 'appointment{{$id}}', url);

    });



    /* when civil service is selected contract types will be changed */
    $('#civilService{{$id}}').on('change', function () {

        var protocol = window.location.protocol == "https:" ? "https://" : "http://";

        var host = protocol + window.location.host;

        var url = "";

        /* civil service true or false sned to back */

        if ($(this).is(':checked')) {

            $('#lbl_civilService{{$id}}').text('Bəli');

            url = "/helper-lists/labor-contracts/select/true";

            $('#listContractTypes{{$id}}').data('url', host + url);

            $('#listContractTypes{{$id}}').selectObj('listContractTypes{{$id}}', 'ordersModal');

        } else {

            $('#lbl_civilService{{$id}}').text('Xeyr');

            url = "/helper-lists/labor-contracts/select/false";

            $('#listContractTypes{{$id}}').data('url', host + url);

            $('#listContractTypes{{$id}}').selectObj('listContractTypes{{$id}}', 'ordersModal');
        }
    });

    /* when contract type is choosen appointment month will be appended or deleted */

    $('#listContractTypes{{$id}}').on('change', function () {

        let slabel = $(this).select2('data')[0].slabel;

        if (slabel == 'LWC') {
            $('#duration{{$id}}').parent().show();
            $('#duration{{$id}}').prop('disabled', false);
        } else {
            $('#duration{{$id}}').parent().hide();
            $('#duration{{$id}}').prop('disabled', true);
        }

    });


    /* trigger datepicker */
    $('[data-plugin="datepicker"]').datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        autoclose: true,
        weekStart: 1
    });

    /*
     *
     * Additional payment to user
     * */

    $('body').on('click', '.isPercentClass', function () {

        $('.fillSum').html('<h4 id="paymentText">Ödəniş faizi:</h4><input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" max="100" required>');

    });

    $('body').on('click', '.isAmountClass', function () {

        $('.fillSum').html('<h4 id="paymentText">Ödəniş məbləği:</h4><input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" required>');

    });


    $('#isPaid{{$id}}').on('change', function () {


        if ($(this).is(':checked')) {

            $('#paymentMethod{{$id}}').html(   '<div class="col-md-12 mt-30">' +
                                                    '<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +
                                                        '<input type="radio" id="percent{{$id}}" name="isPercent[{{$id}}]" class="isPercentClass" value="true" checked/>' +
                                                        '<label for="percent">Faizlə</label>' +
                                                    '</div>' +
                                                    '<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +
                                                        '<input type="radio" id="cash{{$id}}" name="isPercent[{{$id}}]" class="isAmountClass" value="false" />' +
                                                        '<label for="cash">Məbləğ</label>' +
                                                    '</div>' +
                                                '</div>');

            $('#amount{{$id}}').html(  '<div class="col-md-12"><div class="fillSum">' +
                                            '<h4 id="paymentText">Ödəniş faizi:</h4>' +
                                            '<input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" max="100" required>' +
                                        '</div></div>');


            $('input[name="isPercent"]').on('click', function () {


                if ($(this).prop('id') === 'percent') {

                    $('#amount{{$id}}').html(  '<div class="col-md-12">' +
                                                    '<h4 id="paymentText">Ödəniş faizi:</h4>' +
                                                    '<input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" max="100" required>' +
                                                '</div>');

                } else {

                    $('#amount{{$id}}').html(  '<div class="col-md-12">' +
                                                    '<h4 id="paymentText">Ödəniş məbləği:</h4>' +
                                                    '<input type="number" step="any" name="valueSum[{{$id}}]" class="form-control" min="1" required>' +
                                                '</div>');
                }

            });

            /* change label text */
            $('#lblPayment{{$id}}').text('Bəli');

            /* append payment type id */
//            setPaymentTypeId();

            /* get user payment */
            getIndividualUserPayment();

        } else {

            /* change label text */
            $('#lblPayment{{$id}}').text('Xeyr');

            $('#paymentMethod{{$id}}').empty();
            $('#amount{{$id}}').empty();

        }

    });

    /* when is paid is choosen then add PaymentTypeId to hidden input */

    let setPaymentTypeId = function () {

        $.ajax({
            type: 'GET',
            url: '{{ route('payment-type-id-by-label.get', 'Individual') }}',
            success: function (response) {

                if (response.code == 200) {

                    $('#amount{{$id}}').append('<input type="hidden" name="paymentTypeId[{{$id}}]" value="' + response.data[0].id + '">');

                }

            }
        });

    };

    /* get user payment and append */
    let getIndividualUserPayment = () => {

        /* user */
        let userId = $('#employee{{$id}}').val();

        /* payment type */
        let paymentTypeLabel = 'Individual';

        $.ajax({
            url: '/staff-table/get-individual-user-payment/' + userId + '/' + paymentTypeLabel,
            type: 'GET',
            success: function(response) {

                if (response.code == 200)
                {
                    if (response.data[0].isPercent == false)
                    {
                        $('#cash{{$id}}').trigger('click');
                    }

                    $('input[name="valueSum[{{$id}}]"]').val(response.data[0].valus);

                } else
                {
                    throw new Error('Response is not OK');
                }

            },
            error: function(error){

                console.log(error);
            }
        });


    };

    /* trigger jquery switches */

    new Switchery(document.querySelector('#isPaid{{$id}}'), {
        color: '#3f51b5'
    });

    new Switchery(document.querySelector('#civilService{{$id}}'), {
        color: '#3f51b5'
    });

    /*
     *
     * When appointment type is changed options will be changed
     *
     * */
    $('#row5-{{$id}}').css("display","none");

    $('#appointmentType{{$id}}').on('change', function () {

        /* if appointment is hiring new employee then you need to note trialPeriod */
        if ($(this).val() == 1) {

            $('#row5-{{$id}}').css("display","none");
            $('#typo-dynamic{{$id}}').css("display","block");
            $('#row3-{{$id}}').css("display","block");
            $('#row2-{{$id}}').css("display","block");

            $('#typo-dynamic{{$id}}').html('<div class="row">' +
                                                '<div class="col-md-4">' +
                                                    '<h4>Sınaq müddəti (ay): </h4>' +
                                                    '<input type="number" step="1" name="trialPeriodMonth[{{$id}}]" class="form-control">' +
                                                '</div>' +
                                            '</div>');

        } else {

            /* if appointment is transfer then you need to see old positionId */

            let html =  '<div class="row">' +
                            '<div class="col-md-6">' +
                                '<h4>Cari struktur:</h4>' +
                                '<select class="form-control" id="listStructuresOld{{$id}}" readonly>' +

                                '</select>' +
                            '</div>' +
                            '<div class="col-md-6">' +
                                '<h4>Cari vəzifə:</h4>' +
                                '<select name="fromPositionId[{{$id}}]" class="form-control" id="listPositionNamesOld{{$id}}" readonly>' +

                                '</select>' +
                            '</div>' +
                        '</div>';

            /* append html */
            $('#typo-dynamic{{$id}}').html(html);

        }

    });

    /* when employee is selected find fromPositionId */

    $('#employee{{$id}}').on('change', function () {

        /* function depends on appointment type */
        let appointmentType = $('#appointmentType{{$id}}').val();
        let user = $(this).val();

        if (appointmentType == 2) {

            /* get user position */
            $.ajax({
                type: 'GET',
                url:  '/staff-table/get-position-by-user/' + user,
                success: function (response) {

                    if (response.code == 200) {

                        /* generate option for structure */
                        let structure = $('<option></option>')
                            .val(1)
                            .text(response.data[0].structureIdName)
                            .prop('selected', true);

                        /* generate option for position id */
                        let position  = $('<option></option>')
                            .val(response.data[0].positionIdId)
                            .text(response.data[0].posNameIdName)
                            .prop('selected', true);

                        /* append structure and position */
                        structure.appendTo($('#listStructuresOld{{$id}}'));
                        position.appendTo($('#listPositionNamesOld{{$id}}'));

                    }

                }
            });

        }

    });

</script>