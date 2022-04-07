<div id="hiddens">
    <input type="hidden" name="orderTypeLabel" value="warning">
    <input type="hidden" value="{{ isset($data->fields['warning'][0]['orderCommonId']) ? $data->fields['warning'][0]['orderCommonId'] : '' }}" name="orderCommonId">
</div>
<div class="mt-20" id="mai" style="border-top:1px solid #efefef;">
    <div id="contain" class="col-12">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-6 float-left">
                <h4>Əsas: </h4>
                <div class="checkbox-custom checkbox-primary text-left float-left">
                    <input type="checkbox" id="" value="true" class="check-provision" name="status" checked="" disabled>
                    <label>Struktur bölmə rəhbərinin təqdimatı</label>
                </div>
                <div class="ml-40 checkbox-custom checkbox-primary text-left float-left">
                    <input type="checkbox" id="WorkerS" value="true" class="check-provision" {{ isset($data->fields['warning'][0]['isExplanation']) ? $data->fields['warning'][0]['isExplanation'] == true ? 'checked' : '' : '' }} name="WorkerS">
                    <label for="WorkerS">İşçilərin izahatı</label>
                </div>
            </div>
            <div class="col-4 float-left">
                <h4>Təqdimatı təqdim edən əməkdaş: </h4>
                <select id="userId2" class="form-control select" name="userId2" data-url="{{ route('users','select') }}" required>
                    <option value="{{ isset($data->fields['warning'][0]['executorUserId']->id) ? $data->fields['warning'][0]['executorUserId']->id : ''}}" selected> {{ isset($data->fields['warning'][0]['executorUserId']->firstName) && isset($data->fields['warning'][0]['executorUserId']->lastName) ? $data->fields['warning'][0]['executorUserId']->firstName .' '. $data->fields['warning'][0]['executorUserId']->lastName . ' ' . $data->fields['warning'][0]['executorUserId']->patronymic : '' }} </option>
                </select>
            </div>
        </div>
    </div>

</div>

<div class="mt-20" id="main_container" style="border-top:1px solid #efefef;">
    <div class="row mt-20">
        <div class="col-2"></div>
        <div class="col-9 text-right">
            <button type="button" class="btn btn-floating btn-info waves-effect waves-float waves-light" onclick="addNote()"><i class="icon md-plus" aria-hidden="true"></i></button>
        </div>
    </div>
    @if(isset($data->fields['warning']))
        @foreach($data->fields['warning'][0]['userId'] as $single)
        <div id="{{$single['id']}}" class="col-12">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-4">
                    <h4>Əməkdaş: </h4>
                    <select id="userId" class="form-control select" name="userId[]" data-url="{{ route('users','select') }}" required>
                        <option value="{{ isset($single['id']) ? $single['id'] : ''}}" selected> {{ isset($single['name']) ?  $single['name'] : '' }} </option>
                    </select>
                </div>
                <div class="col-3">
                    <h4>Struktur: </h4>
                    <input type="text" disabled="" id="structureName" class="form-control" value="{{ isset($single['strName']) ? $single['strName'] : '' }}">
                </div>
                <div class="col-3">
                    <h4>Vəzifə: </h4>
                    <input type="text" disabled="" id="positionName" class="form-control" value="{{ isset($single['posName']) ? $single['posName'] : '' }}">
                </div>
                <div class="col-1 float-left">
                    <h4> &nbsp</h4>
                    <button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  onclick="deleteStrOld('{{$single['id']}}');" style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
         @endforeach
    @endif
</div>

<script>

    /* load select2 and datapicker */

    $('.select').select2({
        width: '100%',
        placeholder: 'Seçilməyib'
    });


    /* Strucutre -> position -> user select */

    $('#userId').selectObj('userId', 'ordersModal');
    $('#userId2').selectObj('userId2', 'ordersModal');

    $('#userId').on('select2:select', function () {


        // Define variables
        var userId =  $(this).val();
        var url    =  'orders/get-position-by-userId/' + userId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {

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

<script>

    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    var addNote = function() {


        let id = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();

        $('#main_container').append(    '<div class="col-lg-12 float-left" id="row-'+ id +'">'+

                                        '<div class="row"> ' +
                                            '<div class="col-1 float-left"></div> ' +
                                            '<div class="col-4 float-left"> ' +
                                                '<h4>Əməkdaş: </h4> ' +
                                                '<select name="userId[]" id="userId'+id+'" class="form-control select userIdClass" data-url="{{ route('users','select') }}" required> ' +
                                                '<option></option> '+
                                                '</select> ' +
                                            '</div>' +
                                        '<div class="col-3 float-left">'+
                                        '<h4>Struktur: </h4>'+
                                        '<input type="text" class="form-control" id="structureName'+id+'" disabled="">'+
                                        '</div>'+
                                        '<div class="col-3 float-left">'+
                                        '<h4>Vəzifə: </h4>'+
                                        '<input type="text" class="form-control" id="positionName'+id+'"disabled="">'+
                                        '</div>'+
                                        '<div class="col-1 float-left">'+
                                        '<h4> &nbsp</h4>'+
                                        '<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  onclick="deleteStr(\'row-'+id+'\');" style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>');

        $('#userId'+id).selectObj('userId'+id, 'ordersModal');


        $('#userId'+id).on('select2:select', function () {


            // Define variables
            var userId =  $(this).val();
            var url    =  'orders/get-position-by-userId/' + userId;


            // Send AJAX request
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {

                    write(response.positionId.posNameId.name,response.positionId.structureId.name);


                },
                error: function(error){

                    console.log('error yarandi');
                }
            });


            function write(posName,strName){
                var posName = posName;
                var strName = strName;

                $('#structureName'+id).val(strName);
                $('#positionName'+id).val(posName);

            }
        });


    }

</script>

<script>
    function deleteStr(id){
        $('#'+ id).remove();


    }

    function deleteStrOld(id){
        $('#'+ id).remove();

        $('#hiddens').append('<input type="hidden" name="delete[]" value="'+id+'">');


    }
</script>