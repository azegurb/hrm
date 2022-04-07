@php $uniqid = uniqid() @endphp
<div class="mt-20" id="dimissal_{{$uniqid}}" style="border-top:1px solid #efefef;">

    <div class="row">
        @if(isset($array))
            <input type="hidden" name="orderDismissalId" value="{{ $array->orderDismissalId }}">
            @for($i = 0; $i < count($array->relUserInOrderDismissalList); $i++)
                <input type="hidden"
                       name="relUserInOrderDismissalId[{{ $uniqid }}][{{ $array->relUserInOrderDismissalList[$i]['id'] }}]"
                       value="{{ $array->userInOrderDismissalId[$i] }}">
            @endfor
        @endif
        <div class="col-md-12">
            <input type="hidden" name="orderTypeLabel" value="dismissal">
            <input type="hidden" name="orderDismissalList[]" value="{{$uniqid}}">
            <button type="button" class="close" onclick="drop('dimissal_{{$uniqid}}')"><span
                        aria-hidden="true">&times;</span></button>
        </div>
        <div class="col-md-2">
            <h4>Xitamın verilmə tarixi:</h4>
            <input type="text" name="dismissalDate[]" class="form-control order-related-date"
                   value="@if(isset($array)) {{ $array->dismissalDate }} @endif" required>
        </div>
        <div class="col-md-2">
            <h4>Əməkdaşlar:</h4>
            <select class="form-control select" id="listEmployees_{{$uniqid}}" name="userId[{{$uniqid}}][]"
                    data-url="{{ route('users', 'select') }}">
                @if(isset($array))
                    @foreach($array->relUserInOrderDismissalList as $employee)
                        <option value="{{ $employee['id'] }}" selected>{{ $employee['text'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <h4>Struktur:</h4>
            <select disabled class="form-control" id="listStructures_{{$uniqid}}"
                    data-url="{{ route('structures.list') }}">
                @if(isset($array))
                    <option value="{{ $array->listStructures['id'] }}"
                            selected>{{ $array->listStructures['text'] }}</option>
                @endif
            </select>

        </div>
        {{--<div class="col-md-2 related-structure" style="display: {{ isset($array->relatedStructure['id']) && $array->relatedStructure['id'] != null ? 'block' : 'none'}};">--}}
            {{--<h4>Əlaqəli struktur:</h4>--}}
            {{--<select class="form-control" id="relatedStructure{{$uniqid}}" disabled>--}}
                {{--@if(isset($array))--}}
                    {{--<option value="{{ $array->relatedStructure['id'] }}"--}}
                            {{--selected>{{ $array->relatedStructure['text'] }}</option>--}}
                {{--@endif--}}
            {{--</select>--}}
        {{--</div>--}}
        <div class="col-md-2">
            <h4>Vəzifə:</h4>
            <select disabled class="form-control" name="positionId[]" id="listPositionNames_{{$uniqid}}"
                    data-url="{{ route('position-names.list') }}">
                @if(isset($array))
                    <option value="{{ $array->listPositionNames['id'] }}"
                            selected>{{ $array->listPositionNames['text'] }}</option>
                @endif
            </select>
            <input id="listPositionHidden_{{$uniqid}}" type="hidden" name="positionId[]"
                   value="@if(isset($array)){{ $array->listPositionNames['id'] }}@endif"/>
        </div>
        <div class="col-md-2">
            <h4>İşdən azadolunma səbəbi:</h4>
            <select name="listDismissalTypeId[]" id="listDismissalTypeId_{{$uniqid}}" class="form-control select"
                    data-url="{{ url('/orders/get-dismissal-types') }}">
                @if(isset($array))
                    <option value="{{ $array->listDismissalTypeId['id'] }}"
                            selected>{{ $array->listDismissalTypeId['text'] }}</option>
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <h4>Kompensasiya:</h4>
            <input type="text" name="compensation" class="form-control" readonly>
        </div>
        <div class="col-md-12 text-right mt-10">
            {{--<button class="btn btn-sm btn-floating btn-primary waves-effect" id="append-new-note" type="button" onclick="addNote()">--}}
            {{--<i class="icon md-plus" aria-hidden="true"></i>--}}
            {{--</button>--}}
        </div>
        <div class="col-md-12">
            <div class="row order-dismissal-note dynamic">
                <div class="col-md-12 mt-10">
                    {{--if edit array is set then iterate throuh each note and display--}}
                    @if(isset($array))
                        @foreach($array->orderDismissalNotes as $note)
                            <div class="row" id="data-dismissal-note-{{$uniqid}}">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 mb-5">
                                            <h4 style="margin-top: 5px;">Qeyd:</h4>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="button" class="close"
                                                    onclick="$('#data-dismissal-note-{{$uniqid}}').remove()"><span
                                                        aria-hidden="true">&times;</span></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" name="noteId[]" value="{{ $note['id'] }}">
                                        <textarea name="note[]" id="orderDismissalNote" cols="30"
                                                  rows="5" class="form-control">{{$note['note']}}</textarea>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    @else
                        <div class="row">
                            <div class="col-6 mb-5">
                                <h4 style="margin-top: 5px;">Qeyd:</h4>
                            </div>
                        </div>
                        <div class="row">
                                <textarea name="note[]" id="orderDismissalNote" cols="30" rows="5"
                                          class="form-control"></textarea>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>

        $('.select').select2({
            placeholder: 'Seçilməyib',
            width: '100%'
        });

        $('#listDismissalTypeId_{{$uniqid}}').selectObj('listDismissalTypeId_{{$uniqid}}', 'dimissal_{{$uniqid}}');

        $('#listEmployees_{{$uniqid}}').selectObj('listEmployees_{{$uniqid}}', 'dimissal_{{$uniqid}}');


        $('#listEmployees_{{$uniqid}}').on('select2:select', function () {
            var uId = $(this).val();
            var static = 'appointment';
            $.ajax({
                'type': 'get',
                'url': "{{route('getUserRelatedData')}}/?uId=" + uId + "&static=" + static,
                'success': function (data) {
                    $('#listStructures_{{$uniqid}}').html('');
                    $('#listPositionNames_{{$uniqid}}').html('');
                    $('#listPositionHidden_{{$uniqid}}').val('');
                    /*if (data.data.length != 0 && data.data[0].relatedStructureIdId != null) {
                        $('.related-structure').show();
                    } else {
                        $('.related-structure').hide();
                    }*/
                    if (data.data != null && data.data != undefined && data.data.length != 0) {
                        $('#listStructures_{{$uniqid}}').html('<option value="' + data.data[0].structureIdId + '" selected>' + data.data[0].structureIdName + '</option>');
                        $('#listPositionNames_{{$uniqid}}').html('<option value="' + data.data[0].posNameIdId + '" selected>' + data.data[0].posNameIdName + '</option>');
                        $('#listPositionHidden_{{$uniqid}}').val(data.data[0].positionIdId);
                        //$('#relatedStructure{{$uniqid}}').html(`<option value="${data.data[0].relatedStructureIdId}" selected>${data.data[0].relatedStructureIdName}</option>`);
                    }
                }
            });

        });
        /*
         *
         * Page date picker
         * */
        $(".order-related-date").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            autoclose: true,
            weekstart: 1
        });

        /*
        *
        * adding order note dynamically
        *
        * */

        /*
         * JS snipped for generating unique id
         * */

        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }

        var addNote = function () {


            let id = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();

            $('.order-dismissal-note').append('<div class="col-md-12 mt-10" id="dismissal-note-' + id + '">' +
                '<div class="row">' +
                '<div class="col-6 mb-5">' +
                '<h4 style="margin-top: 5px;">Qeyd:</h4>' +
                '</div>' +
                '<div class="col-6 text-right">' +
                '<button type="button" class="close" onclick="$(\'#dismissal-note-' + id + '\').remove()"><span aria-hidden="true">&times;</span></button>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<textarea name="note[]" id="orderDismissalNote" cols="30" rows="5" class="form-control"></textarea>' +
                '</div>' +
                '</div>');


        }

    </script>

</div>