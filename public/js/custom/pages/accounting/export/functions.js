
/**
 * Generates table for
 * @param {array} userPayments
 * @returns {string}
 * */
function getExcelTable()
{

}

/**
 * Downloads excel table
 * @returns {void}
 * */
function downloadExcel() {

    $.ajax({
        url: '/accounting/export-get-template',
        success: function(response) {

            let html      = response;

            let BOMString = '\uFEFF';
            let dataType  = 'data:application/vnd.ms-excel,';
            let content   =  html.replace(/ /g, '%20');

            let temp      = document.createElement('a');
            temp.href     = dataType + BOMString + content;
            temp.download = 'payments_' + moment().format('DD-MM-YYYY') + '.xls';

            temp.click();
            temp.remove();

        }
    });

}
