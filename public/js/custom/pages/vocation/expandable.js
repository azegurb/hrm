function expandable(data , modalId){
    var tr = '';
    if(typeof data == 'undefined'){
        $('#expandable-head').show('fast');
        tr = '<tr>' +
            '<td>' +
            '<div class="input-daterange" data-plugin="datepicker">' +
            '<div class="input-group">' +
            '<span class="input-group-addon">' +
            '<i class="icon md-calendar" aria-hidden="true"></i>' +
            '</span>' +
            '<input type="text" class="form-control date date_id" name="start[]"/>' +
            '</div>' +
            '<div class="input-group">' +
            '<span class="input-group-addon">&mdash;</span>' +
            '<input type="text" class="form-control date_id" name="end[]"/>' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input class="form-control vac_start date_id" name="vac_start[]">'+
            '</td>'+
            '<td>'+
            '<input type="number" class="form-control trip_day" name="trip_day[]"/>'+
            '</td>'+
            '<td><input type="text" class="form-control vac_end date_id" disabled><input type="hidden" class="vac_end" name="vac_end[]"></td>'+
            '<td><button type="button" class="btn btn-delete removeRow">&times;</button></td>'+
            ''+
            ''+
            '</tr>';
        $('#expand').append(tr);
    }else{
        if(Array.isArray(data.fields.workYears.data)) {
            data.fields.workYears.data.forEach(function (value) {
                tr += '<tr>' +
                    '<td>' +
                    '<div class="input-daterange" data-plugin="datepicker">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">' +
                    '<i class="icon md-calendar" aria-hidden="true"></i>' +
                    '</span>' +
                    '<input type="text" class="form-control date date_id" name="start[]" value="' + value.startDate + '" />' +
                    '</div>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">&mdash;</span>' +
                    '<input type="text" class="form-control date_id" name="end[]" value="' + value.endDate + '" />' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<input class="form-control vac_start date_id" name="vac_start[]" value="' + value.vacationWorkPeriodFrom + '" >' +
                    '</td>' +
                    '<td>' +
                    '<input type="number" class="form-control trip_day" name="trip_day[]" value="' + value.vacationDay + '"/>' +
                    '</td>' +
                    '<td><input type="text" class="form-control vac_end date_id" value="' + value.vacationWorkPeriodTo + '" disabled><input type="hidden" class="vac_end" name="vac_end[]" ' + value.vacationWorkPeriodTo + '></td>' +
                    '<td><button type="button" class="btn btn-delete removeRow">&times;</button></td>' +
                    '</tr>';
            });

            $('#' + modalId).find('#expand').html('');
            $('#' + modalId).find('#expand').append(tr);
        }
    }
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy'
    });
    $('.trip_day').on('change',function(){
        var firstDate = $(this).closest('tr').find('.vac_start').val();
        if (firstDate != ''){
            var dayToAdd = $(this).val();
            var endDateVal = moment(firstDate , "DD-MM-YYYY").add(dayToAdd ,'days').format('DD.MM.YYYY');
            $(this).closest('tr').find('.vac_end').val(endDateVal);
        }
    });
    $('.removeRow').on('click' , function(){
        $(this).closest('tr').remove();
    });
}