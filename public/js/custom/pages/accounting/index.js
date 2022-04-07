
/**
 * Gets and loads tab data
 * @param {string} url
 * */
function getTab(url) {

    let loader = $('.tab-pane');

    loader_start(loader);

    $.ajax({
        url: url,
        success: function(html) {

            $('.tab-pane').html(html);

            loader_stop(loader);

        },
        error: function(ex, code, message) {

            loader_stop(loader);
            toastr.error(message, 'Diqqət!');
        }
    });

}

// get first tab
getTab('/accounting/salary/index');

// hide tree container
$('.tree-container-custom').hide();

// Extend the default picker options for all instances.
$.extend($.fn.pickadate.defaults, {
    monthsFull: ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktryabr', 'Noyabr', 'Dekabr'],
    monthsShort: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'İyun', 'İyul', 'Avq', 'Sen', 'Okt', 'Noy', 'Dek'],
    weekdaysFull: ['Bazar', 'Bazar ertəsi', 'Çərşənbə aşxamı', 'Çərşənbə', 'Cümə axşamı', 'Cümə', 'Şənbə'],
    weekdaysShort: ['Bazar', 'Bazar ertəsi', 'Çərşənbə aşxamı', 'Çərşənbə', 'Cümə axşamı', 'Cümə', 'Şənbə'],

    today: 'Bu gün',
    clear: 'Təmizlə',
    close: 'İmtina',

    labelMonthNext: 'Növbəti ay',
    labelMonthPrev: 'Əvvəlki ay',
    labelMonthSelect: 'Ay seçin',
    labelYearSelect: 'İl seçin',
});