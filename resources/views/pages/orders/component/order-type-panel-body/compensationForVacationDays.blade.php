<input type="hidden" name="orderTypeLabel" value="compensationForVacationDays">
<div class="mt-20" id="compensationForVacationDays" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-4">
            <h4>Əməkdaş: </h4>
            <select name="userId" id="userId" class="form-control select" data-url="{{ route('users','select') }}" required>
                <option></option>
            </select>
        </div>
        <div class="col-3">
            <h4>Struktur: </h4>
            <input type="text" id="structureName" class="form-control" disabled="disabled">
        </div>
        <div class="col-3">
            <h4>Vəzifə: </h4>
            <input type="text" id="positionName" class="form-control" disabled="disabled">
        </div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="form-group col-4">
            <h4>İş ili dövrü:</h4>
            <div class="input-daterange" data-plugin="datepicker">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="icon md-calendar" aria-hidden="true"></i>
                        </span>
                    <input type="text" class="form-control" name="input_startDate" value="12.05.2017" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control" name="input_endDate" value="19.06.2017" disabled>
                </div>
            </div>
        </div>
        <div class="col-2">
            <h4>Əsas məzuniyyət:</h4>
            <input type="text" class="form-control" name="input_name" id="input_name" value="30 gün" disabled>
        </div>
        <div class="col-2">
            <h4>Staja görə əlavə:</h4>
            <input type="text" class="form-control" name="input_name" id="input_name" value="14 gün" disabled>
        </div>
        <div class="col-2">
            <h4>Əmək şəraitinə görə əlavə:</h4>
            <input type="text" class="form-control" name="input_name" id="input_name" value="4 gün" disabled>
        </div>
    </div>
</div>

<script>

    /* load select2 and datapicker */

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


    /* Strucutre -> position -> user select */

    $('#structureId').selectObj('structureId', 'ordersModal');

    $('#structureId').on('select2:select', function () {

        $('#userId').empty();

        $('#positionId').empty();

        let url = $('#positionId').data('url') + '/' +  $(this).val();

        $('#positionId').selectObj('positionId' ,false, url);

    });


    $('#positionId').on('select2:select', function () {

        $('#userId').empty();

        let url = $('#userId').data('url') + '/' +  $(this).val();

        $('#userId').selectObj('userId' , false, url);

    });

    $('#userId').selectObj('userId', 'ordersModal');

</script>
