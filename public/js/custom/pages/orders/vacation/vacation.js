$(function () {

    /*  function for generating fake UUID */
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    window.appendDateForVacation = function newDateForVacation() {

        /*  fake random UUID */
        var id = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();

        /* generate html  */
        // var vacation_date = ' <div class="vacation-date-'+id+' col-md-12" id="vacationDate'+id+'"><div>' +
        var vacation_date = '<div class="row"><div class="col-md-3"> <h4>Məzuniyyətin növü:</h4> <div class="checkbox-custom checkbox-primary"> ' +
            '<input type="checkbox" name="isMainVacation[]" id="isMainVacation'+id+'" checked> <label for="isMainVacation'+id+'">Əsas məzuniyyət</label> </div> ' +
            '</div> <div class="col-md-4"> <div class="row"> <div class="col-md-6"> ' +
            '<h4>Başlama tarixi:</h4><div class="input-group"> <span class="input-group-addon">' +
            '<i class="icon md-calendar" aria-hidden="true"></i> </span> ' +
            '<input type="text" id="vacationStartDate'+id+'" class="start-date form-control" name="startDate[]" required="required" data-plugin="datepicker"/> ' +
            '</div>' +
            '</div><div class="col-md-6"><h4>Bitmə tarixi:</h4>' +
            '<div class="input-group"> <span class="input-group-addon"> <i class="icon md-calendar" aria-hidden="true"></i> ' +
            '</span> <input type="text" id="vacationEndDate'+id+'" class="end-date form-control" name="endDate[]" required="required" data-plugin="datepicker"/> ' +
            '</div> </div> </div> </div>  ' +
            '<div class="col-md-2"> <h4> Gün </h4> ' +
            '<input type="number" id="difference_time_'+id+'" name="difference_time[]" class="days form-control end-date" data-count="'+id+'"> </div>' +
            '<div class="col-md-1">'+
            '<h4> </h4>'+
            '<button class="btn btn-sm btn-floating btn-danger waves-effect float-left remove-vacation" type="button">'+
            '<i class="icon md-minus" aria-hidden="true"></i>'+
            '</button>'+
            '</div>'+
            '</div>';
        /* append html */
        $('.vacation-dates').append(vacation_date);


        /* datepicker */
        $('[data-plugin="datepicker"]').datepicker({
            orientation: "top",
            format: 'dd.mm.yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        /* calculate number of days between start and end dates */
        $(document).on('changeDate', '#vacationEndDate'+id, function () {

            /* get start date */
            let vacationStartDate = $('#vacationStartDate'+id).val();
            /* vacation end date */
            let vacationEndDate   = $(this).val();

            /* get days diff between dates */
            /* moment.js */
            let daysDiff = moment(vacationEndDate, 'DD.MM.YYYY').diff(moment(vacationStartDate, 'DD.MM.YYYY'), 'days');

            /* append days to closest input[type="number"] */
            $('#difference_time_'+id).val(daysDiff);

        });

        /* check if  main vacation days are drained before using additional vacation */
        $(document).on('change', '#isMainVacation'+id, function () {

            /* main vacation days */
            let mainVacationDays = $('#mainVacation').val();

            /* if vacation is the main */
            if (!$(this).is(':checked') && mainVacationDays > 0)
            {
                /* give info message */
                swal('Diqqət!', 'Əsas məzuniyyət günləri tam istifadə olunmamış işçi əlavə məzuniyyətə göndərilə bilməz.', 'info');
                /* trigger click to change value */
                $(this).trigger('click');
            }

        });

        /* remove appended html */
        $('body').on('click', '.remove-vacation', function () {

            /* remove 'ənkə' parent */
            $(this).parent().parent().remove();
        });
    };

    /* remove appended */
    window.removeAppended = function (id) {

        $('#'+id).remove();
    };

});