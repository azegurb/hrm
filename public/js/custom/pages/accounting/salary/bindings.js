// on calculate click
$('.container-salary').on('click', '.btn-calculate', function (event) {

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
                    url: '/accounting/salary/calculate',
                    data: {date: date},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

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
                    error: function (ex, code, message) {

                        calculation.stop();
                        loader_stop($('#panel-accounting'));
                        error(message);

                    }
                });

            }

        }
    });

    let picker = $input.pickadate('picker');

    picker.open();

});

// on export excel click
$('.container-salary').on('click', '.btn-close', function () {

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
            url: '/accounting/salary/close',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {year: year, month: month},
            success: function(response) {
                closing.stop();
                $(reference).removeClass('close-in-progress');

                if (response.code == 200) {

                    getTab('/accounting/salary/index');

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

$('.container-salary').on('click', '.btn-export-excel', function() {
    downloadExcel();
});

// on row click
$('.container-salary').on('click', '.data-user', function () {

    let userId = $(this).attr('id');

    let request = $.get(`/accounting/salary/get-detailed-payment-info?userId=${userId}&year=${year}&month=${month}`);

    request.done(function (html) {

        $('#payment-info-modal').find('.modal-body').html(html);
        $('#payment-info-modal').modal('show');

    });

    request.fail(function (exception, code, message) {

        error(message);

    });

});

// on keyup search input
$('.container-salary').on('keyup', '#searchField', function () {

    updateTable();

});

// on click user checkbox
$('.container-salary').on('click', '.checkbox-refresh', function (event) {

    event.stopPropagation();

    let userId = $(this).parent().parent().attr('id');

    let date = $(this).parent().parent().attr('data-payment-date');

    let input = $(this).find('input[type="checkbox"]');

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
$('.container-salary').on('click', '#btn-refresh', function () {

    let refreshLadda = Ladda.create(this);

    if (userList.length > 0) {

        refreshLadda.start();

        let data = '';

        userList.forEach(function (el, index) {

            data += el.userId;

            data += index != userList.length - 1 ? '|' : '';

        });

        $.ajax({
            type: 'POST',
            url: '/accounting/salary/refresh',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {users: data, date: userList[0].paymentDate},
            success: function (response) {

                refreshLadda.stop();

                if (response.code == 200) {

                    success(response.message);

                    updateTable();

                }
                else {

                    error(response.message);

                }

            },
            error: function (ex, code, message) {

                refreshLadda.stop();

                error(message);

            }
        });

    }
    else {

        return;

    }

});

// on year change
$('.container-salary').on('change', '#year', function () {

    year = $(this).val();

    updateTable();

});

// on month change
$('.container-salary').on('change', '#month', function () {

    month = $(this).val();

    updateTable();

});

