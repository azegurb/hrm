
/**
 * Generates table body from given entities
 * @param {array} userPayments
 * @returns {string}
 * */
function generateTableBody(userPayments = []) {

    let rows = '';

    if (userPayments.length > 0) {

        userPayments.forEach(function(payment, index) {

            for (let prop in payment) {
                payment[prop] = payment[prop] || '';
            }

            rows += `<tr id="${payment.userIdId}" data-payment-date="${payment.paymentDate}" class="data-user">

                        <td>
                            <div class="checkbox-custom checkbox-refresh checkbox-primary" style="margin-top: 0 !important;">
                                 <input type="checkbox" id="check-${index}">
                                 <label for="check-${index}"></label>
                            </div>
                        </td>
                        
                        <td>${payment.userIdLastName} ${payment.userIdFirstName} ${payment.userIdPatronymic}</td>
                        
                        <td>${payment.workDayFact        ? payment.workDayNorm        : 0 }</td>
                        
                        <td>${payment.workDayFact        ? payment.workDayFact        : 0 }</td>
                        
                        <td>${payment.workDayHourFact    ? payment.workDayHourNorm    : 0 }</td>
                        
                        <td>${payment.workDayHourFact    ? payment.workDayHourFact    : 0 }</td>
                        
                        <td>${payment.salary             ? payment.salary             : 0 } AZN</td>
                        
                        <td>${payment.percentSum         ? payment.percentSum : 0 }  ${ payment.isPercent ? '%' : 'AZN' } </td>
                        
                        <td>${payment.totalPaymentSum    ? payment.totalPaymentSum    : 0 } AZN</td>
                        
                        <td></td>
    
                    </tr>`;

        });

    }
    else {

        rows += `<tr>
                    <td colspan="11" class="text-center">İstəyiniz üzrə məlumat tapılmadı</td>
                 </tr>`;

    }

    return rows;
}

/**
 * Updates the given table with userPayment data
 * @param {string} selector
 * @returns {void}
 * */
function updateTable(selector = '.table-advance') {

    let tbody   = $(selector).find('tbody');

    let q       = $('#searchField').val();

    let request = $.get(`/accounting/advance/index?q=${q}&limit=${limit}&page=${page}&async=true&year=${year}&month=${month}`);

    loader_start($('.tab-pane'));

    userList    = [];

    toggleSiteAction();

    request.done(function(response) {

        loader_stop($('.tab-pane'));

        if (response.code == 200) {

            total = response.total;

            tbody.html(generateTableBody(response.data.entities));

            initPagination();

        }
        else {

            error(response.message);

        }

    });

    request.fail(function(exception, code, message) {

        error(message);

        loader_stop($('.tab-pane'));

    });

}

/**
 * Downloads excel table
 * @returns {void}
 * */
function downloadExcel() {

    let request = $.get(`/accounting/export/get-advance-template?year=${year}&month=${month}`);

    loader_start($('.tab-pane'));

    request.done(function(response) {

        loader_stop($('.tab-pane'));

        let table     = response;

        let BOMString = '\uFEFF';
        let dataType  = 'data:application/vnd.ms-excel,';
        let content   =  table.replace(/ /g, '%20');

        let temp      = document.createElement('a');
        temp.href     = dataType + BOMString + content;
        temp.download = 'advance_' + moment().format('DD-MM-YYYY') + '.xls';

        temp.click();
        temp.remove();

    });

    request.fail(function(ex, code, message) {

        loader_stop($('.tab-pane'));

        error(message);

    });

}

/**
 * Notifies the user with error message
 * @param {string} message
 * @returns {void}
 * */
function error(message) {

    toastr.error(
        `Müraciət zamanı xəta baş verdi <br><small>${message}</small>`,
        `<b>Diqqət!</b>`
    );

}

/**
 * Notifies the user with success message
 * @param {string} message
 * @returns {void}
 * */
function success(message) {

    toastr.success(message, `<b>Uğurlu!</b>`);

}