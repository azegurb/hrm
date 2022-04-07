
var total = $('.salary-vacation').attr('data-total') || 0;
total = parseInt(total);

var limit = $('.salary-vacation').attr('data-limit') || 0;
limit = parseInt(limit);

var page  = $('.salary-vacation').attr('data-page')  || 0;
page  = parseInt(page);

// users to refresh
var userList = [];

// current year
var year  = moment().format('YYYY');
// current month
var month = moment().format('MM');

// set current year
$(`#year option[value="${year}"]`).prop('selected', true);

// set current month
$(`#month option[value="${month}"]`).prop('selected', true);
/**
 * Hides or shows site action btn
 * @returns {void}
 * */
function toggleSiteAction() {

    if (userList.length > 0){
        $('.site-action').show();
    }
    else {
        $('.site-action').hide();
    }

}

// hide tree container
$('.tree-container-custom').hide();

/**
 * @param {string} selector
 * @returns {void}
 * */
function initPagination(selector = '.vacation-pagination') {

    let list = $(selector);

    let numberOfPages = Math.ceil(total / limit);

    if (numberOfPages > 1) {

        list.show();

        list.pagination({
            pages: numberOfPages,
            currentPage: page,
            prevText: '«',
            nextText: '»',
            hrefTextPrefix: '#',
            onPageClick: function(pageNumber) {

                page = pageNumber;

                updateTable();

            }
        });

    } else {

        list.hide();

    }

}

// init pagination
initPagination();