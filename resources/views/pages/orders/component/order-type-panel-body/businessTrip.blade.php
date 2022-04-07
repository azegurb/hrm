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
                        <textarea name="comment[]" id="comment" cols="30" rows="8" class="form-control">@if(isset($array)){{$array->comment}}@endif</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row" >
                    <div class="col-md-12">
                        <h4>Əməkdaş:</h4>
                        <select class="form-control select" id="listEmployees_{{$uniqid}}" name="userId[{{$uniqid}}][]" data-url="{{ route('users','select') }}">
                            @if(isset($array))
                                @foreach($array->listEmployees as $employee)
                                    <option value="{{ $employee['id'] }}" selected>{{ $employee['text'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <h4>Struktur: </h4>
                        <input type="text" name="" id="structureName_{{$uniqid}}" disabled="" class="form-control" value="@if(isset($array)) {{ $array->listStructures['text'] }} @endif">
                    </div>
                    <div class="col-md-6">
                        <h4>Vəzifə: </h4>
                        <input type="text" name="" id="positionName_{{$uniqid}}" disabled="" class="form-control" value="@if(isset($array)) {{ $array->listPositionNames['text'] }} @endif">
                        <input type="hidden" name="positionId[]" id="positionId_{{$uniqid}}"   value="{{ isset($array->positionId) ? $array->positionId : '' }}">
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height: 100px; overflow-y: scroll;">
                        <div id="regions-tree-{{$uniqid}}"></div>
                        <input type="hidden" name="regionId[]" value="{{ isset($array->regionId) ? $array->regionId : '' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        /**
         * @param {array} structures
         * @param {string} selector
         * @returns {void}
         * */
        function initTree(regions = [], selector = '#regions-tree-{{$uniqid}}') {

            let tree = $(selector);

            tree.jstree({
                core: {
                    data: regions,
                    multiple: false
                },
                checkbox: {
                    three_state: false
                },
                plugins: [
                    "checkbox", "wholerow"
                ]
            });

            tree.on('select_node.jstree', function(e, data){

                let region = data.node.id;

                $('input[name="regionId[]"]').val(region);

            });
        }

        let regionId = '{{ isset($array->regionId) ? $array->regionId : 'undefined' }}';

        // get tree content
        $.ajax({
            url: '/helper-lists/regions',
            success: function(response) {
                response.forEach(function(item, index){

                    if (item.id == regionId) {

                        item.state.selected = true;
                    }

                });
                initTree(response);
            },
            error: function() {

            }
        });

    </script>

    @if(isset($array))
        <script>

            $('#listStructures_{{$uniqid}}').selectObj('listStructures_{{$uniqid}}');
            $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}');


            $('#listEmployees_{{$uniqid}}').on('select2:select', function () {

                $('#structureName_{{$uniqid}}').val('');

                $('#positionName_{{$uniqid}}').val('');

                var userId =  $(this).val();
                var url    =  'orders/get-position-by-userId/' + userId;

                // Send AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {

                        write(response.positionId.posNameId.name,response.positionId.structureId.name,response.positionId.id);

                    },
                    error: function(error){

                        console.log('error yarandi');
                    }
                });

                function write(posName,strName, posId){

                    $("#structureName_{{$uniqid}}").val(strName);
                    $("#positionName_{{$uniqid}}").val(posName);
                    $("#positionId_{{$uniqid}}").val(posId);

                }

            });

        </script>


    @else


        <script>

            $('.select').select2({
                placeholder: 'Seçilməyib',
                width: '100%'
            });

            $('#listEmployees_{{$uniqid}}').on('select2:select', function () {

                $('#structureName_{{$uniqid}}').val('');

                $('#positionName_{{$uniqid}}').val('');

                var userId =  $(this).val();
                var url    =  'orders/get-position-by-userId/' + userId;

                // Send AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {

                        write(response.positionId.posNameId.name,response.positionId.structureId.name,response.positionId.id);

                    },
                    error: function(error){

                        console.log('error yarandi');
                    }
                });

                function write(posName,strName,posId){

                    $("#structureName_{{$uniqid}}").val(strName);
                    $("#positionName_{{$uniqid}}").val(posName);
                    $("#positionId_{{$uniqid}}").val(posId);

                }

            });


            {{--$('#listStructures_{{$uniqid}}').selectObj('listStructures_{{$uniqid}}');--}}

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
            $('#listStructures_{{$uniqid}}').selectObj('listStructures_{{$uniqid}}');
            $('#listPositionNames_{{$uniqid}}').on('select2:select', function () {

                var url = $('#listEmployees_{{$uniqid}}').data('url') + '/' +  $(this).val();

                $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}' , false, url);

            });


            $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}');

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

