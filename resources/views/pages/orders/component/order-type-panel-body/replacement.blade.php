<input type="hidden" name="orderTypeLabel" value="replacement">
<div class="mt-20" id="assignment" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-md-12">
            @if(isset($array))
                <input type="hidden" name="userPositionId[{{ $array->employees['id'] }}]" value="{{ $array->userPositionId }}">
                <input type="hidden" name="userReplacementId[{{ $array->replacedUserId['id'] }}]" value="{{ $array->userReplacementId }}">
                <input type="hidden" name="orderAppointmentId" value="{{ $array->orderAppointmentId }}">
            @endif
            <div class="row" >
                <div class="col-md-2">
                    <h4>Əməkdaş:</h4>
                    <select name="replacedUserId" id="replacedUserId" class="form-control select" data-url="{{ route('users','select') }}">
                        @if(isset($array))
                            <option value="{{ $array->employees['id'] }}" selected>{{ $array->employees['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <h4>Struktur:</h4>
                    <select name="structure" class="form-control select" id="listStructures" data-url="{{ route('structures.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->structure['id'] }}" selected>{{ $array->structure['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <h4>Vəzifə:</h4>
                    <select name="position_name" class="form-control select" id="listPositionNames" data-url="{{ route('position-names.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->position_name['id'] }}" selected>{{ $array->position_name['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="mt-30 pl-15 pr-20">
                    <h4> </h4>
                    <input type="checkbox" id="isPaid" name="isFree" class="js-switch"
                    @if(isset($array)) @if($array->isFree == false){{ 'value=false checked' }} @else {{ 'value=true' }}@endif @else {{ 'value=true' }} @endif />
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
                        <div class="col-md-12 mt-30">
                            <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                                <input type="radio" id="percent" name="isPercent" value="true" @if($array->isPercent == true){{ 'checked' }}@endif/>
                                <label for="percent">Faizlə</label>
                            </div>
                            <div class="col-md-6 radio-custom radio-primary float-left inline-block">
                                <input type="radio" id="cash"    name="isPercent" value="false" @if($array->isPercent == false){{ 'checked' }}@endif/>
                                <label for="cash">Nəğd</label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h4>Əvəz edən şəxs:</h4>
                    <select name="employee" id="employee" class="form-control select" data-url="{{ route('users','select') }}">
                        @if(isset($array))
                            <option value="{{ $array->replacedUserId['id'] }}" selected>{{ $array->replacedUserId['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <h4>Başlama tarixi:</h4>
                    <input style="font-size: 15px;" type="text" value="@if(isset($array)) {{ $array->startDate }} @endif" id="startDate" class="order-related-date date_id form-control" name="startDate" data-plugin="datepicker">
                </div>
                <div class="col-md-2">
                    <h4>Bitmə tarixi:</h4>
                    <input style="font-size: 15px;" type="text" id="endDate" value="@if(isset($array)) {{ $array->endDate }} @endif" class="order-related-date date_id form-control" name="endDate" data-plugin="datepicker">
                </div>
                <div class="col-md-2">
                    <div class="row" id="amount">
                        @if(isset($array) && $array->isFree == false)
                            @if ($array->isPercent == true)
                                <div class="col-md-12">
                                    <h4 id="paymentText">Ödəniş faizi:</h4>
                                    <input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" value="{{ $array->valueSum }}">
                                </div>
                            @else
                                <div class="col-md-12">
                                    <h4 id="paymentText">Ödəniş məbləği:</h4>
                                    <input type="number" step="any" name="valueSum" class="form-control" min="1" value="{{ $array->valueSum }}">
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

        $('#employee').selectObj('employee' , 'ordersModal');

        $('#replacedUserId').selectObj('replacedUserId' , 'ordersModal');

        $('#listStructures').selectObj('listStructures');

        var url = $('#listPositionNames').data('url') + '/' +  '{{ $array->structure['id'] }}';

        $('#listPositionNames').selectObj('listPositionNames' ,false, url);

    /*
     *
     * When structure is selected pass its id to position names url param
     * and trigger select2
     * */
    $('#listStructures').on('select2:select', function () {

        $('#listPositionNames').empty();

        var url = $('#listPositionNames').data('url') + '/' +  $(this).val();

        $('#listPositionNames').selectObj('listPositionNames' ,false, url);

    });

    @else

        $('.select').select2({
            placeholder: 'Seçilməyib',
            width: '100%'
        });

        $('#listStructures').selectObj('listStructures');
        $('#employee').selectObj('employee' , 'ordersModal');
        $('#replacedUserId').selectObj('replacedUserId' , 'ordersModal');

        /*
         *
         * When structure is selected pass its id to position names url param
         * and trigger select2
         * */
        $('#listStructures').on('select2:select', function () {

            $('#listPositionNames').empty();

            var url = $('#listPositionNames').data('url') + '/' +  $(this).val();

            $('#listPositionNames').selectObj('listPositionNames' ,false, url);

        });

    @endif

    $('#btnCloneForm').hide();

    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekStart: 1
    });


    $('#isPaid').on('change', function () {

        if($(this).is(':checked')) {

            $('#paymentMethod').html(   '<div class="col-md-12 mt-30">' +
                                            '<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +
                                                '<input type="radio" id="percent" name="isPercent" value="true" checked/>' +
                                                '<label for="percent">Faizlə</label>' +
                                            '</div>' +
                                            '<div class="col-md-6 radio-custom radio-primary float-left inline-block">' +
                                                '<input type="radio" id="cash" name="isPercent" value="false" />' +
                                                '<label for="cash">Məbləğ</label>' +
                                            '</div>' +
                                        '</div>');

            $('#amount').html(  '<div class="col-md-12">' +
                                    '<h4 id="paymentText">Ödəniş faizi:</h4>' +
                                    '<input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" required>' +
                                '</div>');

            $('input[name="isPercent"]').on('click', function () {

                if ($(this).prop('id') === 'percent') {

                    $('#amount').html(  '<div class="col-md-12">' +
                                            '<h4 id="paymentText">Ödəniş faizi:</h4>' +
                                            '<input type="number" step="any" name="valueSum" class="form-control" min="1" max="100" required>' +
                                        '</div>');

                } else {

                    $('#amount').html(  '<div class="col-md-12">' +
                                            '<h4 id="paymentText">Ödəniş məbləği:</h4>' +
                                            '<input type="number" step="any" name="valueSum" class="form-control" min="1" required>' +
                                        '</div>');
                }

            });

        } else {

            $('#paymentMethod').empty();
            $('#amount').empty();

        }

    });

    new Switchery(document.querySelector('#isPaid'), {
        color: '#3f51b5'
    });

</script>