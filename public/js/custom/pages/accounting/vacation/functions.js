
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

                        <td>${++index}</td>
                        
                        <td>${payment.userIdLastName} ${payment.userIdFirstName} ${payment.userIdPatronymic}</td>
                        
                        <td>${payment.workDayFact        ? payment.workDayFact        : 0 }</td>
                        
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
                        
                        <td></td>
    
                    </tr>`;

        });

    }
    else {

        rows += `<tr>
                    <td colspan="14" class="text-center">İstəyiniz üzrə məlumat tapılmadı</td>
                 </tr>`;

    }

    return rows;
}

/**
 * Updates the given table with userPayment data
 * @param {string} selector
 * @returns {void}
 * */
function updateTable(selector = '.table-payments') {

    let tbody   = $(selector).find('tbody');

    let q       = $('#searchField').val();

    let request = $.get(`/accounting/vacation/index?q=${q}&limit=${limit}&page=${page}&async=true&year=${year}&month=${month}`);

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