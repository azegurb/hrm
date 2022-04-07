@php($uniqid = uniqid())
<div class="mt-20" id="businessTrip_{{$uniqid}}" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="orderTypeLabel" value="businessTrip">
            <input type="hidden" name="orderBusinessTripList[]" value="{{$uniqid}}">
            <button type="button" class="close" onclick="drop('businessTrip_{{$uniqid}}')"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="col-md-6">
            @if(isset($array))
                <input type="hidden" name="orderBusinessTripId[]" value="{{ $array->id }}">
                @for($i = 0; $i < count($array->listEmployees); $i++)
                    <input type="hidden" name="relUserInOrderBusinessTripId[{{$uniqid}}][{{ $array->listEmployees[$i]['id'] }}]" value="{{ $array->userPositionId[$i] }}">
                @endfor
            @endif
            <div class="row">
                <div class="col-md-4">
                    <h4>Başlama tarixi:</h4>
                    <input style="font-size: 15px;" type="text" id="startDate" class="order-related-date form-control"
                           name="startDate[]" data-plugin="datepicker" value="@if(isset($array)) {{ $array->startDate }} @endif" required>
                </div>
                <div class="col-md-4">
                    <h4>Bitmə tarixi:</h4>
                    <input style="font-size: 15px;" type="text" id="endDate" class="order-related-date form-control"
                           name="endDate[]" data-plugin="datepicker" value="@if(isset($array)) {{ $array->endDate }} @endif" required>
                </div>
                <div class="col-md-4">
                    <h4>Müddət:</h4>
                    <input type="number" class="form-control" name="duration[]" id="duration" value="@if(isset($array)){{$array->duration}}@endif" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4>Ezamiyyətin səbəbi:</h4>
                    <textarea name="tripReason[]" cols="30" rows="8" class="form-control" id="tripReason" required>@if(isset($array)){{$array->tripReason}}@endif</textarea>
                </div>
                <div class="col-md-6">
                    <h4>Qeyd:</h4>
                    <textarea name="comment[]" id="comment" cols="30" rows="8" class="form-control" required>@if(isset($array)){{$array->comment}}@endif</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row" >
                <div class="col-md-6">
                    <h4>Struktur:</h4>
                    <select class="form-control select" id="listStructures_{{$uniqid}}" data-url="{{ route('structures.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->listStructures['id'] }}" selected>{{ $array->listStructures['text'] }}</option>
                        @endif
                    </select>
                    <h4>Vəzifə:</h4>
                    <select class="form-control select" name="positionId[]" id="listPositionNames_{{$uniqid}}" data-url="{{ route('position-names.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->listPositionNames['id'] }}" selected>{{ $array->listPositionNames['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <h4>Əməkdaşlar:</h4>
                    <select class="form-control select" id="listEmployees_{{$uniqid}}" name="userId[{{$uniqid}}][]" data-url="{{ route('employees.list') }}" multiple="multiple">
                        @if(isset($array))
                            @foreach($array->listEmployees as $employee)
                                <option value="{{ $employee['id'] }}" selected>{{ $employee['text'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4>Ölkə:</h4>
                    <select class="form-control select" id="listCountries_{{$uniqid}}" name="listCountryId[]" data-url="{{ route('countries.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->listCountries['id'] }}" selected>{{ $array->listCountries['text'] }}</option>
                        @endif
                    </select>
                    <h4>Şəhər:</h4>
                    <select class="form-control select" id="listCities_{{$uniqid}}" name="listCityId[]" data-url="{{ route('cities.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->listCities['id'] }}" selected>{{ $array->listCities['text'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <h4>Qəsəbə:</h4>
                    <select class="form-control select" id="listVillages_{{$uniqid}}" name="listVillageId[]" data-url="{{ route('villages.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->listVillages['id'] }}" selected>{{ $array->listVillages['text'] }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($array))

    <script>

        $('#listStructures_{{$uniqid}}').selectObj('listStructures_{{$uniqid}}');
        $('#listCountries_{{$uniqid}}').selectObj('listCountries_{{$uniqid}}');

        /*
        * position names by structure id
        * */
        var posNamesUrl = $('#listPositionNames_{{$uniqid}}').data('url') + '/' +  '{{ $array->listStructures['id'] }}';

        $('#listPositionNames_{{$uniqid}}').selectObj('listPositionNames_{{$uniqid}}' ,false, posNamesUrl);


        /*
        * employees by position id
        * */
        var employeeUrl = $('#listEmployees_{{$uniqid}}').data('url') + '/' +  '{{ $array->listPositionNames['id'] }}';

        $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}' , false, employeeUrl);

        /*
        * cities by country id
        * */
        var cityUrl = $('#listCities_{{$uniqid}}').data('url') + '/' +  '{{ $array->listCountries['id'] }}';

        $('#listCities_{{$uniqid}}').selectObj('listCities_{{$uniqid}}' , false, cityUrl);

        /*
        * villages by city
        * */
        var url = $('#listVillages_{{$uniqid}}').data('url') + '/' +  '{{ $array->listCities['id'] }}';

        $('#listVillages_{{$uniqid}}').selectObj('listVillages_{{$uniqid}}' , false, url);


        /* ---------------------------------------------------------------- */

        /*
         *
         * When structure is selected pass its id to position names url param
         * and trigger select2
         * */
        $('#listStructures_{{$uniqid}}').on('select2:select', function () {

            $('#listEmployees_{{$uniqid}}').empty();

            $('#listPositionNames_{{$uniqid}}').empty();

            var url = $('#listPositionNames_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listPositionNames_{{$uniqid}}').selectObj('listPositionNames_{{$uniqid}}' ,false, url);

        });

        /*
         *
         * When position name is chosen pass its id and get employees
         * trigger select2
         * */

        $('#listPositionNames_{{$uniqid}}').on('select2:select', function () {

            var url = $('#listEmployees_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}' , false, url);

        });


        /*
         * When countries is selected pass its id and get cities
         * */
        $('#listCountries_{{$uniqid}}').on('select2:select', function () {

            $('#listCities_{{$uniqid}}').empty();

            $('#listVillages_{{$uniqid}}').empty();

            var url = $('#listCities_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listCities_{{$uniqid}}').selectObj('listCities_{{$uniqid}}' , false, url);

        });

        /*
         *
         * When city is selected pass its id and get villages
         *
         * */

        $('#listCities_{{$uniqid}}').on('select2:select', function () {

            var url = $('#listVillages_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listVillages_{{$uniqid}}').selectObj('listVillages_{{$uniqid}}' , false, url);

        });

    </script>

@else

    <script>

        $('.select').select2({
            placeholder: 'Seçilməyib',
            width: '100%'
        });

        $('#listStructures_{{$uniqid}}').selectObj('listStructures_{{$uniqid}}');

        /*
         *
         * When structure is selected pass its id to position names url param
         * and trigger select2
         * */
        $('#listStructures_{{$uniqid}}').on('select2:select', function () {

            $('#listEmployees_{{$uniqid}}').empty();

            $('#listPositionNames_{{$uniqid}}').empty();

            var url = $('#listPositionNames_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listPositionNames_{{$uniqid}}').selectObj('listPositionNames_{{$uniqid}}' ,false, url);

        });

        /*
         *
         * When position name is chosen pass its id and get employees
         * trigger select2
         * */

        $('#listPositionNames_{{$uniqid}}').on('select2:select', function () {

            var url = $('#listEmployees_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}' , false, url);

        });


        $('#listCountries_{{$uniqid}}').selectObj('listCountries_{{$uniqid}}');


        /*
         * When countries is selected pass its id and get cities
         * */
        $('#listCountries_{{$uniqid}}').on('select2:select', function () {

            $('#listCities_{{$uniqid}}').empty();

            $('#listVillages_{{$uniqid}}').empty();

            var url = $('#listCities_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listCities_{{$uniqid}}').selectObj('listCities_{{$uniqid}}' , false, url);

        });

        /*
         *
         * When city is selected pass its id and get villages
         *
         * */

        $('#listCities_{{$uniqid}}').on('select2:select', function () {

            var url = $('#listVillages_{{$uniqid}}').data('url') + '/' +  $(this).val();

            $('#listVillages_{{$uniqid}}').selectObj('listVillages_{{$uniqid}}' , false, url);

        });

        /*
         *
         * Page date picker
         * */
        $(".order-related-date").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekstart: 1
        });
    </script>




@endif

