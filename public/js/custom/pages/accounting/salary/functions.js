
/**
 * Generates table body from given entities
 * @param {array} userPayments
 * @returns {string}
 * */
function generateTableBody(userPayments = []) {

    let rows = '';

    if (userPayments.length > 0) {

        monthIsClosed = userPayments[0].userPaymentsIdIsPaid != null ? userPayments[0].userPaymentsIdIsPaid : true;

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
                        
                        <td>${payment.userPaymentsIdWorkDayNorm     ? payment.userPaymentsIdWorkDayNorm : 0 } gün / ${payment.userPaymentsIdWorkDayHourNorm ? payment.userPaymentsIdWorkDayHourNorm : 0 } saat</td>
                        
                        <td>${payment.userPaymentsIdWorkDayFact     ? payment.userPaymentsIdWorkDayFact : 0 } gün / ${payment.userPaymentsIdWorkHourFact   ? payment.userPaymentsIdWorkHourFact   : 0 } saat</td>
                        
                        <td>${payment.salary             ? payment.salary             : 0 } AZN</td>
                        
                        <td>${payment.salary             ? payment.advanceSum         : 0 } AZN</td>
                        
                        <td>${payment.addPaymentSum      ? payment.addPaymentSum      : 0 } AZN</td>
                        
                        <td>${payment.laborConditionsSum ? payment.laborConditionsSum : 0 } AZN</td>
                        
                        <td>${payment.endCalcSum         ? payment.endCalcSum         : 0 } AZN</td>
                        
                        <td>${payment.privilegeSum       ? payment.privilegeSum       : 0 } AZN</td>
                        
                        <td>${payment.taxSum             ? payment.taxSum             : 0 } AZN</td>
                        
                        <td>${payment.spfSum             ? payment.spfSum             : 0 } AZN</td>
                        
                        <td>${payment.tradeUnionSum      ? payment.tradeUnionSum      : 0 } AZN</td>
                        
                        <td>${payment.totalDeductSum     ? payment.totalDeductSum     : 0 } AZN</td>
                        
                        <td>${payment.totalPaymentSum    ? payment.totalPaymentSum    : 0 } AZN</td>
                        
                        <td>
                            <span class="badge badge-outline badge-${payment.userPaymentsIdIsPaid ? 'success' : 'danger' }">
                                    ${payment.userPaymentsIdIsPaid ? 'Ödənilib' : 'Ödənilməyib' }
                            </span>
                        </td>
    
                    </tr>`;

        });

    }
    else {

        rows += `<tr>
                    <td colspan="22" class="text-center">İstəyiniz üzrə məlumat tapılmadı</td>
                 </tr>`;

    }

    return rows;
}

/**
 * Downloads excel table
 * @returns {void}
 * */
function downloadExcel() {

    let request = $.get(`/accounting/export/get-salary-template?year=${year}&month=${month}`);

    loader_start($('.tab-pane'));

    request.done(function(response) {

        loader_stop($('.tab-pane'));

        let table     = response;

        let BOMString = '\uFEFF';
        let dataType  = 'data:application/vnd.ms-excel,';
        let content   =  table.replace(/ /g, '%20');

        let temp      = document.createElement('a');
        temp.href     = dataType + BOMString + content;
        temp.download = 'salary_' + moment().format('DD-MM-YYYY') + '.xls';

        temp.click();
        temp.remove();

    });

    request.fail(function(ex, code, message) {

        loader_stop($('.tab-pane'));

        error(message);

    });

}

/**
 * Updates the given table with userPayment data
 * @param {string} selector
 * @returns {void}
 * */
function updateTable(selector = '.table-payments') {

    let tbody   = $(selector).find('tbody');

    let q       = $('#searchField').val();

    let request = $.get(`/accounting/salary/index?q=${q}&limit=${limit}&page=${page}&async=true&year=${year}&month=${month}`);

    loader_start($('.tab-pane'));

    userList    = [];

    toggleSiteAction();

    request.done(function(response) {

        loader_stop($('.tab-pane'));

        if (response.code == 200) {

            total = response.total;

            tbody.html(generateTableBody(response.data.entities));

            if (monthIsClosed) {
                $('.btn-payment-op').hide();
            } else {
                $('.btn-payment-op').show();
            }

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
 * Toggles buttons
 */
function togglePaymentButtons() {

    if (monthIsClosed) {
        $('.btn-payment-op').hide();
    } else {
        $('.btn-payment-op').show();
    }

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