<input type="hidden" name="orderTypeLabel" value="staffOpening">

{{--{{dd($data->fields['staffOpening'][0]->orderCommonId->id)}}--}}

<div class="mt-20" id="staff-add" style="border-top:1px solid #efefef;">
    <div class="col-12 appendRow">
        <div class="row">
            <div><button id="appendToRow" class="btn btn-floating btn-info waves-effect waves-effect" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        @if(isset($data->fields))
            @foreach($data->fields['staffOpening'][0] as $dataFields)
                <input type="hidden" name="orderCommonId[]" value="{{isset($dataFields->orderCommonId->id) ? $dataFields->orderCommonId->id : ''}}">
                <input type="hidden" name="positionId[]" value="{{isset($dataFields->id) ? $dataFields->id : ''}}">

                <div class="row">
                    <div class="col-3">
                        <h4>Struktur: </h4>
                        <select name="strId[]" id="struktureId" class="userId form-control select" data-url="{{ route('structures.list') }}" required>
                            <option value="{{ isset($dataFields->structureId->name) ? $dataFields->structureId->id : ''}}" selected> {{ isset($dataFields->structureId->name) ?  $dataFields->structureId->name : '' }} </option>
                        </select>
                    </div>
                    <div class="col-3">
                        <h4>Ştat vahidinin adı: </h4>
                        <select name="posNameId[]" id="listPosNameId" name="listPosNameId" class="userId form-control select" data-url="{{ route('position-names-search.list') }}" required>
                            <option value="{{ isset($dataFields->posNameId->id) ? $dataFields->posNameId->id : ''}}" selected> {{ isset($dataFields->posNameId->name) ?  $dataFields->posNameId->name : '' }} </option>
                        </select>
                    </div>

                    <div class="col-1">
                        <h4>Ştat sayı: </h4>
                        <input type="number" name="countStaff[]" min="1" id="countStaff" class="form-control" value="{{ isset($dataFields->count) ? $dataFields->count : ''}}">
                    </div>
                    <div class="col-2">
                        <h4>Əmək haqqı(AZN): </h4>
                        <input type="number" min="1" name="salary[]" id="salary" class="form-control" value="{{ isset($dataFields->value->value) ? $dataFields->value->value : ''}}">
                    </div>
                    <div class="col-2">
                        <h4>Məzuniyyət günü: </h4>
                        <input type="number" min="1" name="vacation[]" id="vacation" class="form-control" value="{{ isset($dataFields->vacationDay) ? $dataFields->vacationDay : ''}}">
                    </div>
                    <div class="col-1"></div>
                    <div class="col-1"></div>
                </div>
            @endforeach

        @else
            <input type="hidden" name="orderCommonId[]" value="">
            <input type="hidden" name="positionId[]" value="">

            <div class="row">
                <div class="col-3">
                    <h4>Struktur: </h4>
                    <select name="strId[]" id="struktureId" class="userId form-control select" data-url="{{ route('structures.list') }}" required>
                        <option value=""> </option>
                    </select>
                </div>
                <div class="col-3">
                    <h4>Ştat vahidinin adı: </h4>
                    <select name="posNameId[]" id="listPosNameId" name="listPosNameId" class="userId form-control select" data-url="{{ route('position-names-search.list') }}" required>
                        <option value="" selected> </option>
                    </select>
                </div>

                <div class="col-1">
                    <h4>Ştat sayı: </h4>
                    <input type="number" name="countStaff[]" min="1" id="countStaff" class="form-control" value="">
                </div>
                <div class="col-2">
                    <h4>Əmək haqqı(AZN): </h4>
                    <input type="number" min="1" name="salary[]" id="salary" class="form-control" value="">
                </div>
                <div class="col-2">
                    <h4>Məzuniyyət günü: </h4>
                    <input type="number" min="1" name="vacation[]" id="vacation" class="form-control" value="">
                </div>
                <div class="col-1"></div>
                <div class="col-1"></div>
            </div>
        @endif
    </div>
</div>

<script>
    $(document).ready(function () {

        $('body').on('click', '#appendToRow', function () {

            var str='<div class="row"><div class="col-3"><h4>Struktur: </h4><select name="strId[]" id="struktureId" class="structureId form-control select" data-url="{{ route('structures.list') }}" required><option value="{{ isset($data->fields['staffOpening'][0]->structureId->name) ? $data->fields['staffOpening'][0]->structureId->id : ''}}" selected> {{ isset($data->fields['staffOpening'][0]->structureId->name) ?  $data->fields['staffOpening'][0]->structureId->name : '' }} </option></select></div>' +
                '<div class="col-3"><h4>Ştat vahidinin adı: </h4><select name="posNameId[]" id="listPosNameId" class="listPosNameId form-control select" data-url="{{ route('position-names-search.list') }}" required><option value="{{ isset($data->fields['staffOpening'][0]->posNameId->id) ? $data->fields['staffOpening'][0]->posNameId->id : ''}}" selected> {{ isset($data->fields['staffOpening'][0]->posNameId->name) ?  $data->fields['staffOpening'][0]->posNameId->name : '' }} </option></select></div><div class="col-1"><h4>Ştat sayı: </h4><input type="number" name="countStaff[]" min="1" id="countStaff" class="form-control" value="{{ isset($data->fields['staffOpening'][0]->count) ? $data->fields['staffOpening'][0]->count : ''}}">' +
                '</div><div class="col-2"><h4>Əmək haqqı(AZN): </h4><input type="number" min="1" name="salary[]" id="salary" class="form-control" value="{{ isset($data->fields['staffOpening'][0]->value->value) ? $data->fields['staffOpening'][0]->value->value : ''}}"></div><div class="col-2">' +
                '<h4>Məzuniyyət günü: </h4><input type="number" min="1" name="vacation[]" id="vacation" class="form-control" value="{{ isset($data->fields['staffOpening'][0]->vacationDay) ? $data->fields['staffOpening'][0]->vacationDay : ''}}"></div>' +
                '<div class="col-1"><button class="removeBt btn btn-floating btn-danger btn-xs waves-effect" style="margin-top:35px"><i class="icon md-minus" aria-hidden="true"></i></button></div><div class="col-1"></div></div>';

            $('.appendRow').append(str);
            $('.structureId').selectObj2('structureId', 'ordersModal');

            var url='/helper-lists/list-position-names';

            $('.listPosNameId').selectObj2('listPosNameId', false, url);

        })

    });

    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });

    /* Structure > Position > Users select */

    $('.userId').selectObj('userId', 'ordersModal');

    $('#listPosNameId').on('select2:select', function () {

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

    var url='/helper-lists/list-position-names';

    $('#listPosNameId').selectObj('listPosNameId', false, url);

    var url2 = '{{ route('structures.list') }}';

    $('#struktureId').selectObj('struktureId', false, url2);

    $('[data-plugin="datepicker"]').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });
    $('#orderDate').on('dateChange', function () {

        var orderDate = $(this).val();
        console.log(orderDate);
    });
    $('body').on('click', '.removeBt', function () {

        $(this).parent().parent().remove();
    })

</script>