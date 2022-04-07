
// on calculate click
$('.container-advance').on('click', '.btn-calculate', function (event) {

    event.stopPropagation();

    event.preventDefault();

    let $input = $('.pickerdate').pickadate({

        onSet: function (context) {

            if (context.select) {

                let date = moment(context.select).format('YYYY-MM-DD');

                let calculation = Ladda.create(document.querySelector('.btn-calculate'));

                calculation.start();

                $('#btn-refresh').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: '/accounting/advance/calculate',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {date: date},
                    success: function(response) {

                        calculation.stop();

                        $('#btn-refresh').prop('disabled', false);

                        if (response.code == 200) {

                            success(response.message);

                            updateTable();

                        }
                        else {

                            error(response.message);

                        }

                    },
                    error: function(ex, code, message) {

                        calculation.stop();

                        error(message);

                    }
                });

            }

        }
    });

    let picker = $input.pickadate('picker');

    picker.open();

});

// on keyup search input
$('.container-advance').on('keyup', '#searchField', function () {

    updateTable();

});

// on export excel click
$('.container-advance').on('click', '.btn-close', function () {

    let reference = this;

    let closing = Ladda.create(reference);

    swal({
        title: "Əminsiniz?",
        text: "Cari ay üçün ödənişlər bağlanacaq.",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        confirmButtonText: "Bəli, davam et!",
        confirmButtonColor: "#ec6c62",
        cancelButtonText: "İmtina"
    }, function() {

        closing.start();
        $(reference).addClass('close-in-progress');

        $.ajax({
            type: 'PUT',
            url: '/accounting/advance/close',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {year: year, month: month},
            success: function(response) {
                closing.stop();
                $(reference).removeClass('close-in-progress');

                if (response.code == 200) {

                    getTab('/accounting/advance/index');

                } else {

                    error(response.message);

                }

            },
            error: function(exception, type, message){
                closing.stop();
                $(reference).removeClass('close-in-progress');
                error(message);
            }
        });

    });

});

$('.container-advance').on('click', '.btn-export-excel', function() {
    downloadExcel();
});

// on click user checkbox
$('.container-advance').on('click', '.checkbox-refresh', function (event) {

    event.stopPropagation();

    let userId = $(this).parent().parent().attr('id');

    let date = $(this).parent().parent().attr('data-payment-date');

    let input  = $(this).find('input[type="checkbox"]');

    if (input.is(':checked')) {

        userList.push({userId: userId, paymentDate: date});

    }
    else {

        userList = userList.filter(function (el) {
            return el.userId != userId;
        });

    }

    toggleSiteAction();

});

// on refresh button
$('.container-advance').on('click', '#btn-refresh', function() {

    let refreshLadda = Ladda.create(this);

    if (userList.length > 0) {

        refreshLadda.start();

        let data = '';

        userList.forEach(function(el, index) {

            data += el.userId;

            data += index != userList.length - 1 ? '|' : '';

        });

        $.ajax({
            type: 'POST',
            url: '/accounting/advance/refresh',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {users:data, date: userList[0].paymentDate},
            success: function(response) {

                refreshLadda.stop();

                if (response.code == 200) {

                    success(response.message);

                    updateTable();

                }
                else {

                    error(response.message);

                }

            },
            error: function(ex, code, message) {

                refreshLadda.stop();
                loader_stop($('#panel-accounting'));
                error(message);

            }
        });

    }
    else {

        return;

    }

});

// on year change
$('.container-advance').on('change', '#year', function() {

    year = $(this).val();

    updateTable();

});

// on month change
$('.container-advance').on('change', '#month', function() {

    month = $(this).val();

    updateTable();

});

