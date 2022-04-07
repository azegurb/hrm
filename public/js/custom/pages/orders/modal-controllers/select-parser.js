/**
 * Created by Asan on 5/19/2017.
 */
var option;

function getUrl(value) {
    var url = null;
    var btnClone = $('#btnCloneForm');
    option = value;

    switch (value) {

        /* Ezamiyyə seçimi */
        case 'businessTrip':
            url = "/orders/business-trip";
            btnClone.hide();

            break;

        /* Təyinat seçimi */
        case 'appointment':

            url = "/orders/appointment";
            btnClone.show();

            break;
        /* Məzuniyyət seçimi */
        case 'vacation':
            url = "/orders/vacation";
            btnClone.hide();

            break;

        /* Həvalə seçimi */
        case 'assignment':
            url = "/orders/assignment";
            btnClone.hide();

            break;
        /* Əvəzetmə seçimi */
        case 'replacement':
            url = "/orders/replacement";
            btnClone.hide();

            break;
        /* Xitam seçimi */
        case 'dismissal':

            url = "/orders/dismissal";
            btnClone.show();

            break;

        /* Dəyən zərərin ödənilməsi seçimi */
        case 'damageCompensation' :

            url = '/orders/damage-compensation';
            btnClone.hide();

            break;

        /* Dəyən zərərin ödənilməsi seçimi */
        case 'damage' :

            url = '/orders/damage';
            btnClone.hide();

            break;

        /* Xəbərdarlıq seçimi */
        case 'warning':

            url = '/orders/warning';
            btnClone.hide();

            break;

        /* Maddi yardım seçimi */
        case  'financialAid':

            url = "/orders/financialAid";
            btnClone.hide();

            break;

        case 'additionalWorkTime':

            url = '/orders/additionalWorkTime';
            btnClone.hide();

            break;

        case 'nonWorkingDaysSelection':

            url = '/orders/nonWorkingDaysSelection';
            btnClone.hide();

            break;

        case 'compensationForVacationDays':

            url = '/orders/compensationForVacationDays';
            btnClone.hide();

            break;

        case 'discipline':

            url = '/orders/discipline';
            btnClone.hide();

            break;
        case 'staffOpening':
            url = '/orders/addState';
            btnClone.hide();

            break;

        case 'staffCancellation':
            url = '/orders/staffCancellation';
            btnClone.hide();

            break;

        case 'salaryAddition':
            url = '/orders/salary-addition';
            btnClone.hide();

            break;

        case 'salaryDeduction':
            url = '/orders/salary-deduction';
            btnClone.hide();

            break;

        case 'orderTransfer':
            url = '/orders/orderTransfer';
            btnClone.hide();

            break;

        case 'vacationRecall':
            url = '/orders/vacationRecall';
            btnClone.hide();

            break;

        /* Mükafat seçimi */
        case 'QualificationDegree':
            url = '/orders/QualificationDegree';
            btnClone.hide();

            break;

        case 'Reward':

            url = '/orders/reward';
            btnClone.show();

            break;
    }

    return url;

}

$(document).on('change', '#listOrderTypes', function () {

    var url = getUrl($(this).select2('data')[0].sLabel);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });

    $.ajax({
        // Get Remote data
        url: url,
        type: 'GET',
        success: function (data) {
            if (data != '') {

                $('#appendArea').html(data);

            }
        }
    });
});
