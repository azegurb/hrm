<input type="hidden" name="orderTypeLabel" value="assignment">
<div class="mt-20" id="assignment" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                @if(isset($array))
                    <input type="hidden" name="userPositionId[{{ $array->employees['id'] }}]"
                           value="{{ $array->userPositionId[0] }}">
                    <input type="hidden" name="orderAppointmentId" value="{{ $array->orderAppointmentId }}">
                @endif

                <div class="col-md-2">
                    <h4>Struktur:</h4>
                    <select name="structure" class="form-control select" id="listStructures"
                            data-url="{{ route('structures.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->structure['id'] }}"
                                    selected>{{ $array->structure['text'] }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <h4>Vəzifə:</h4>
                    <select name="position_name" class="form-control select" id="listPositionNames"
                            data-url="{{ route('position-names.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->position_name['id'] }}"
                                    selected>{{ $array->position_name['text'] }}</option>
                        @endif
                    </select>
                </div>

                {{--<div class="col-md-2">--}}
                {{--<h4>Əməkdaş:</h4>--}}
                {{--<select name="employee" id="employee" class="form-control select"--}}
                {{--data-url="{{ route('employees.list') }}">--}}
                {{--@if(isset($array))--}}
                {{--<option value="{{ $array->employees['id'] }}"--}}
                {{--selected>{{ $array->employees['text'] }}</option>--}}
                {{--@endif--}}
                {{--</select>--}}
                {{--</div>--}}
                <div class="col-md-2">
                    <h4>Həvalə edilən şəxs:</h4>
                    <select name="replacer" id="replacer" class="form-control select"
                            data-url="{{ route('users','select') }}">
                        @if(isset($array) && isset($array->replacedUserId))
                            <option value="{{ $array->replacedUserId['id'] }}"
                                    selected>{{ $array->replacedUserId['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="mt-30 pl-15 pr-20">
                    <h4></h4>
                    <input type="checkbox" id="isPaid" name="isFree" class="js-switch"
                           @if(isset($array)) @if($array->isFree == false){{ 'value=false checked' }} @else {{ 'value=true' }}@endif @else {{ 'value=true' }} @endif required/>
                    <label for="isPaid" id="lblPayment">
                        @if(isset($array))
                            @if($array->isFree == false)
                                {{ 'Ödənişli' }}
                            @else
                                {{ 'Ödənişsiz' }}
                            @endif
                        @else
                            {{ 'Ödənişsiz' }}
                        @endif
                    </label>

                </div>
                <div id="paymentMethod">
                    @if(isset($array) && $array->isFree == false)
                        <div class="col-md-12 mt-40">
                            <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                                <input type="radio" id="percent" name="isPercent" value="true"
                                       @if($array->isPercent == true){{ 'checked' }}@endif required/>
                                <label for="percent">Faizlə</label>
                            </div>
                            <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                                <input type="radio" id="cash" name="isPercent" value="false"
                                       @if($array->isPercent == false){{ 'checked' }}@endif required/>
                                <label for="cash">Məbləğ</label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">

                <div class="col-md-2">
                    <h4>Başlama tarixi:</h4>
                    <input style="font-size: 15px;" type="text"
                           value="@if(isset($array)) {{ $array->startDate }} @endif" id="startDate"
                           class="order-related-date form-control" name="startDate" data-plugin="datepicker"
                           required>
                </div>
                <div class="col-md-2">
                    <h4>Bitmə tarixi:</h4>
                    <input style="font-size: 15px;" type="text" id="endDate"
                           value="@if(isset($array)) {{ $array->endDate }} @endif"
                           class="order-related-date form-control" name="endDate" data-plugin="datepicker"
                           required>
                </div>

                <div class="col-md-2">
                    <div class="row" id="amount">
                        @if(isset($array) && $array->isFree == false)
                            @if ($array->isPercent == true)
                                <div class="col-md-12">
                                    <h4 id="paymentText">Ödəniş faizi:</h4>
                                    <input type="number" step="any" name="valueSum" class="form-control" min="1"
                                           max="100" value="{{ $array->valueSum }}" required>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <h4 id="paymentText">Ödəniş məbləği:</h4>
                                    <input type="number" step="any" name="valueSum" class="form-control" min="1"
                                           value="{{ $array->valueSum }}" required>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    @if(isset($array))

    $('.select').select2({
        placeholder: 'Seçilməyib',
        width: '100%'
    });

    $('#listStructures').selectObj('listStructures');

    var url = $('#listPositionNames').data('url') + '/' + '{{ $array->structure['id'] }}';

    $('#listPositionNames').selectObj('listPositionNames', 'ordersModal', url);

    /*
     *
     * When structure is selected pass its id to position names url param
     * and trigger select2
     * */
    $('#listStructures').on('select2:select', function () {

        $('#listPositionNames').empty();

        var url = $('#listPositionNames').data('url') + '/' + $(this).val();

        $('#listPositionNames').selectObj('listPositionNames', 'ordersModal', url);

    });

    @endif

    $('#replacer').selectObj('replacer');


    $('#listStructures').selectObj('listStructures');

    /*
     *
     * When structure is selected pass its id to position names url param
     * and trigger select2
     * */
    $('#listStructures').on('select2:select', function () {

        $('#listPositionNames').empty();

        var url = $('#listPositionNames').data('url') + '/' + $(this).val();

        $('#listPositionNames').selectObj('listPositionNames', 'ordersModal', url);

    });

    $('#listPositionNames').on('select2:select', function () {

        $('#employee').empty();

        var url = $('#employee').data('url') + '/' + $(this).val();

        console.log($(this).val());

        $('#employee').selectObj('employee', 'ordersModal', url);

    });

    $('#btnCloneForm').hide();

    $('[data-plugin="datepicker"]').datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        todayHighlight: true,
        autoclose: true
    });


    $('#isPaid').on('change', function () {

        if ($(this).is(':checked')) {

            $('#lblPayment').text('Ödənişli');

            $('#paymentMethod').html('<div class="col-md-12 mt-40">' +
                '<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +
                '<input type="radio" id="percent" name="isPercent" value="true" checked/>' +
                '<label for="percent">Faizlə</label>' +
                '</div>' +
                '<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +
                '<input type="radio" id="cash" name="isPercent" value="false" />' +
                '<label for="cash">Məbləğ</label>' +
                '</div>' +
                '</div>');

            $('#amount').html('<div class="col-md-12">' +
                '<h4 id="paymentText">Ödəniş faizi:</h4>' +
                '<input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" required>' +
                '</div>');

            $('input[name="isPercent"]').on('click', function () {

                if ($(this).prop('id') === 'percent') {

                    $('#amount').html('<div class="col-md-12">' +
                        '<h4 id="paymentText">Ödəniş faizi:</h4>' +
                        '<input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" required>' +
                        '</div>');

                } else {

                    $('#amount').html('<div class="col-md-12">' +
                        '<h4 id="paymentText">Ödəniş məbləği:</h4>' +
                        '<input type="number" step="any" name="valueSum" class="form-control" min="1" required>' +
                        '</div>');
                }

            });

        } else {

            $('#lblPayment').text('Ödənişsiz');

            $('#paymentMethod').empty();
            $('#amount').empty();

        }

    });

    new Switchery(document.querySelector('#isPaid'), {
        color: '#3f51b5'
    });
</script>