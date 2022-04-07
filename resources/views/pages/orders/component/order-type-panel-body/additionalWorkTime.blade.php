<input type="hidden" name="orderTypeLabel" value="additionalWorkTime">
<input type="hidden" name="mainId"
<div class="mt-20" id="additionalWorkTime" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-3">
            <h4>İşə cəlb edilmə növü: </h4>
            <select id="additionalWorkTimeType" name="additionalWorkTimeType" class="form-control select" required>
                <option></option>
                <option value="1" {{ isset($array->listExcessWorkTypeId) ? $array->listExcessWorkTypeId == 1 ? 'selected' : '' : ''}}>İş vaxtından artıq işə cəlb edilmə</option>
                <option value="2" {{ isset($array->listExcessWorkTypeId) ? $array->listExcessWorkTypeId == 2 ? 'selected' : '' : ''}}>İstirahət və ya bayram günündə işə cəlb edilmə</option>
            </select>
        </div>
        <div class="col-2">
            <h4>İş günü: </h4>
            <input type="text" class="form-control" data-plugin="datepicker" name="input_startDate" value="{{ isset($array->date) ? $array->date : '' }}" >
        </div>
    </div>
    <hr class="mt-20 mb-20">
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2">
            <button type="button" class="btn btn-floating btn-info waves-effect waves-float waves-light" onclick="addNote()"><i class="icon md-plus" aria-hidden="true"></i></button>
            {{--<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>--}}
        </div>
    </div>
    @php($no = 0)
    <div id="qweisempty" class="row multi">
        @if(isset($array->workers[0]))
            @foreach($array->workers as $key=>$single)
                <div class="col-lg-12" id="div_{{$no}}">
                    <input type="hidden" id="id_{{$no}}" name="mainId[]" value="{{$single['relId']}}">
                    <input type="hidden" id="id_{{$no}}" name="listExcessWorkId[]" value="{{$single['listExcessWorkId']}}">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <hr class="mt-20">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1 float-left"></div>
                        <div class="col-4 float-left">
                            <h4>Əməkdaş: </h4>
                            <select name="userId[]" id="userId" class="form-control select" data-url="{{ route('users','select') }}" required>
                                <option value="{{ isset($single['userId']) ? $single['userId'] : ''}}" selected>{{ isset($single['userName']) ? $single['userName'] : '' }}</option>
                            </select>
                        </div>
                        <div class="col-3 float-left">
                            <h4>Struktur: </h4>
                            <input type="text" disabled="" id="strName" class="form-control" value="@if(isset($single['structureName'])){{$single['structureName']}} @endif">
                        </div>
                        <div class="col-3 float-left">
                            <h4>Vəzifə: </h4>
                            <input type="text" disabled="" id="posName" value="@if(isset($single['positionName'])){{$single['positionName']}} @endif" class="form-control">
                        </div>
                        <div class="col- float-left">
                            <h4> &nbsp</h4>
                            <button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  onclick="deleteStr('div_{{$no}}')" style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>
                        </div>
                        <div class="col-1 float-left"></div>
                    </div>
                    <div class="row">
                        <div class="col-1 float-left"></div>
                        <div class="col-3 float-left">
                            <h4>Saat aralığı: </h4>
                            <div class="input-group">
                            <span class="input-group-addon">
                            <i class="icon md-time" aria-hidden="true"></i>
                            </span>
                                <input required type="text" id="additionalWorkDate" name="additionalWorkDateStart[]" class="form-control" data-plugin="clockpicker" value="{{isset($single['startTime']) ? $single['startTime'] : ''}}" required>
                                <span class="input-group-addon">—</span>
                                <input required type="text" id="additionalWorkDate" name="additionalWorkDateEnd[]" class="form-control" data-plugin="clockpicker" value="{{isset($single['endTime']) ? $single['endTime'] : ''}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                @php($no++)
            @endforeach
        @endif
    </div>

    <script>

        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }

        var addNote = function() {

            let id = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();

            $('.multi').append(     '<div class="col-lg-12 float-left" id="row-'+ id +'">'+
                '<div class="row">' +
                '<div class="col-lg-1"></div>'+
                '<div class="col-lg-10">' +
                '<hr class="mt-20">' +
                '</div>' +
                '</div>'+
                '<div class="row">'+
                '<div class="col-1 float-left"></div>'+
                '<div class="col-4 float-left">'+
                '<h4>Əməkdaş: </h4>'+
                '<select required name="userId[]" id="userId'+id+'" class="form-control select" data-url="{{ route('users','select') }}" required>'+
                '<option></option>'+
                '</select>'+
                '<input type="hidden" id="" name="listExcessWorkId[]" value="">'+
                '</div>'+
                '<div class="col-3 float-left">'+
                '<h4>Struktur: </h4>'+
                '<input type="text" disabled id="strName'+id+'" class="form-control">'+
                '</div>'+
                '<div class="col-3 float-left">'+
                '<h4>Vəzifə: </h4>'+
                '<input type="text" disabled id="posName'+id+'" class="form-control">'+
                '</div>'+
                '<div class="col- float-left">'+
                '<h4> &nbsp</h4>'+
                '<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  onclick="deleteStr(\'row-'+id+'\')" style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>'+
                '</div>'+
                '<div class="col-1 float-left"></div>'+
                '<div class="col-3 float-left">'+
                '<h4>Saat aralığı: </h4>'+
                '<div class="input-group">'+
                '<span class="input-group-addon">'+
                '<i class="icon md-time" aria-hidden="true"></i>'+
                '</span>'+
                '<input  type="text" id="additionalWorkDateStart'+id+'" name="additionalWorkDateStart[]" class="form-control" data-plugin="clockpicker" required />'+
                '<span class="input-group-addon">—</span>'+
                '<input  type="text" id="additionalWorkDateEnd'+id+'" name="additionalWorkDateEnd[]" class="form-control" data-plugin="clockpicker" required  />'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>');

            $('#userId'+id).selectObj('userId'+id, 'ordersModal');

            $('#additionalWorkDateStart'+id).clockpicker({
                placement: 'top',
                align: 'left',
                autoclose: true
            });

            $('#additionalWorkDateEnd'+id).clockpicker({
                placement: 'top',
                align: 'left',
                autoclose: true
            });
            $('#userId'+id).on('select2:select', function () {

                $('#strName'+id).val('');
                $('#posName'+id).val('');

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

                    $('#strName'+id).val(strName);
                    $('#posName'+id).val(posName);

                }


                $('#positionId').selectObj('positionId' ,false, url);

            });
        }

    </script>


    <script>

        $('.select').select2({
            width: '100%',
            placeholder: 'Seçilməyib'
        });
        $('[data-plugin="datepicker"]').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            orientation: 'top',
            weekstart: 1
        });

        $('[data-plugin="clockpicker"]').clockpicker({
            placement: 'top',
            align: 'left',
            autoclose: true
//        donetext: 'Təsdiq'
        });

        /* Structure > Position > Users select */




        /* adding users  */

    </script>
    <script>
        $('.select').select2({
            width: '100%',
            placeholder: 'Seçilməyib'
        });

        /* Structure > Position > Users select */

        $('#structureId').selectObj('structureId', 'ordersModal');

        $('#userId').selectObj('userId', 'ordersModal');

    </script>

    <script>
        function deleteStr(id) {
            console.log(id);

            $("#"+id).remove();

        }
    </script>