<input type="hidden" name="orderTypeLabel" value="staffCancellation">
<input type="hidden" name="id" value="{{isset($array) ? $array->id : ''}}">
<div class="mt-20 multi" id="financialAid" style="border-top:1px solid #efefef;">

    <div class="row">
        <div class="col-1"></div>
        <div class="col-3">
            <h4>Struktur: </h4>
            <select id="structureId" class="form-control select" data-url="{{ route('structures.list') }}" required>
                <option value="{{ isset($array->strId) ? $array->strId : '' }}" {{ isset($array->strId) ? 'selected' : '' }} >{{ isset($array->strName) ? $array->strName : ''}}</option>
            </select>
        </div>
        <div class="col-3">
            <h4>Ştat vahidinin adı: </h4>
            <select name="positionId[]" id="positionId" class="form-control select posId" data-url="{{ route('position-names.list') }}" required>
                <option value="{{ isset($array->posId) ? $array->posId : '' }}" {{ isset($array->posId) ? 'selected' : '' }} >{{isset($array->posName) ? $array->posName : ''}}</option>
            </select>
        </div>
        <div class="col-2">
            <h4>Ştat sayı: </h4>
            <input type="number" name="" value="{{isset($array->count) ? $array->count : '' }}" disabled min="0.5" id="count" class="form-control">
        </div>
        <div class="col-2">
            <h4>Əmək haqqı(AZN): </h4>
            <input type="number" min="1" value="{{isset($array->salary) ? $array->salary : '' }}" name="" disabled id="salary" class="form-control">
        </div>
        {{--<div class="col-1">--}}
        {{--<h4> </h4>--}}
        {{--<button type="button" class="btn btn-floating btn-info btn-sm waves-effect waves-float waves-light" style="top:-3px;" onclick="addNote()"><i class="icon md-plus" aria-hidden="true"></i></button>--}}
        {{--</div>--}}
        <div class="col-1"></div>
    </div>
</div>

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

</script>

<script>

    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    var addNote = function() {


        let id = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();

        $('.multi').append(     '<div class="row" id="row-'+ id +'">'+
            '<div class="col-3">'+
            '<h4>Struktur: </h4>'+
            '<select id="structureId'+id+'" class="form-control select" data-url="{{ route('structures.list') }}" required>'+
            '<option></option>'+
            '</select>'+
            '</div>'+
            '<div class="col-3">'+
            '<h4>Vəzifə: </h4>'+
            '<select name="positionId[]" id="positionId'+id+'" class="form-control select" data-url="{{ route('position-names.list') }}" required>'+
            '<option></option>'+
            '</select>'+
            '</div>'+
            '<div class="col-2">'+
            '<h4>Ştat sayı: </h4>'+
            '<input type="number" class="form-control" disabled id="structureName'+id+'" >'+
            '</div>'+
            '<div class="col-2">'+
            '<h4>Əmək haqqı(AZN): </h4>'+
            '<input type="number" class="form-control" disabled id="positionName'+id+'">'+
            '</div>'+
            '<div class="col-1">'+
            '<h4> &nbsp</h4>'+
            '<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  onclick="$(\'#row-'+id+'\').remove()" style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>'+
            '</div>'+
            '</div>');

        $('#structureId'+id).selectObj('structureId'+id, 'ordersModal');

        $('#structureId'+id).on('select2:select', function () {

            $('#positionId'+id).empty();

            let url = $('#positionId'+id).data('url') + '/' +  $(this).val();

            $('#positionId'+id).selectObj('positionId'+id ,false, url);

        });


    }

    $("#positionId").on('select2:select', function () {
        $("#count").val('');
        $("#salary").val('');

        var posId =  $(this).val();
        var url    =  'staff-table/get-pos-data/' + posId;


        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {

                write(response.count,response.salary);

            },
            error: function(error){

                console.log('error yarandi');
            }
        });


        function write(count,salary){
            var posSalary = salary;
            var posCount = count;

            $('#count').val(posCount);
            $('#salary').val(posSalary);

        }
    });

</script>

<script>

    $('#structureId').selectObj('structureId', 'ordersModal');

    $('#structureId').on('select2:select', function () {

        $('#positionId').empty();

        let url = $('#positionId').data('url') + '/' +  $(this).val();
        console.log(url);
        $('#positionId').selectObj('positionId' ,false, url);

    });

</script>

