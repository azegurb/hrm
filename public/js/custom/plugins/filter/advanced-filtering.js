/*
 Plugin for advanced searching

 example of use:


    let fields = [
        {
            selector: '#orderType',
            type: 'select',
            filterType: '='
        },
        {
            selector: '#orderNumberFilter',
            type: 'text',
            filterType: '='

        },
        {
             type: 'date-range',
             selectors: {
                start: '#id1',
                end:   '#id2'
            }
        }
    ];

     let config = {
         tableBody: '',
         rowGenerator: '',
         indexUrl: '',
         fields: ''
     };

    new Filter(config).init();

*/


/* filter init function */


window.initFilters = function (config) {

    /* clear local storage  */
    localStorage.clear();

    /* set parameters */
    let tableBody    = config.tableBody;
    let rowGenerator = config.rowGenerator;
    let indexUrl     = config.indexUrl;
    let fields       = config.fields;

    /* apply functions for each type of fields */
    fields.forEach(function (item, index) {

        switch (item.type) {

            case 'select':

                selectFilter(item.selector, item.filterType, indexUrl, rowGenerator, tableBody);

                break;

            case 'date-range':

                dateRange(item.selectors, indexUrl, rowGenerator, tableBody);

                break;

            default:

                textFilter(item.selector, item.filterType, indexUrl, rowGenerator, tableBody);

                break;

        }

    });

};

/* --------------------------

    select filter function

    ------------------------*/

function selectFilter(selector, filterType, url, rowGenerator, tableBody)
{
    /* select function will be triggered on change */

    $(selector).on('select2:select', function () {

        let column = $(this).attr('name');
        let value  = $(this).val();


        /* generate filter array and put it into local storage  */
        let filterArray = [
            {
                column     : column,
                value      : value,
                filterType : filterType
            }
        ];

        /* save array in local storage */
        localStorage.setItem('filterArray', JSON.stringify(filterArray));

        getDataBy(url, rowGenerator, tableBody);


    });
}

/*  --------------------------------

    date range filtering function

    -------------------------------*/

function dateRange(selectors, url, rowGenerator, tableBody) {

    let start = $(selectors.start);
    let end   = $(selectors.end);

    /* when start date is sleected */
    start.on('changeDate', function () {

        /* get start date and column name */
        let startDate = $(this).val();
        let column    = $(this).attr('name');

        let date = startDate.split('.');

        /* put filters to local storage */
        let filters = {
            column     : column,
            value      : date[2] + '-' + date[1] + '-' + date[0],
            filterType : '>='
        };

        localStorage.setItem('rangeStartFilters', JSON.stringify(filters));

        getDataBy(url, rowGenerator, tableBody);

    });
    
    end.on('changeDate', function () {

        /* get end date and column name */
        let endDate = $(this).val();
        let column    = $(this).attr('name');

        let date = endDate.split('.');

        /* generate filters  */
        let filters = {
            column     : column,
            value      : date[2] + '-' + date[1] + '-' + date[0],
            filterType : '<='
        };

        /* put it to storage */
        localStorage.setItem('rangeEndFilters', JSON.stringify(filters));

        getDataBy(url, rowGenerator, tableBody);

    });

}

/*  ---------------

    text filtering

  -----------------*/

function textFilter(selector, filterType, url, rowGenerator, tableBody)
{
    /* text filter will be triggered on keyup */

    $(selector).on('keyup', function () {

        let column = $(this).attr('name');
        let value  = $(this).val();

        /* generate filters for this fields */
        let filters = {
            column     : column,
            value      : value,
            filterType : filterType
        };

        /* update array in locala storage */
        localStorage.setItem('filterKeyUp', JSON.stringify(filters));

        getDataBy(url, rowGenerator, tableBody);

    });
}

/* -----------------------

    load remote data

    --------------------*/

function getDataBy(url, rowGenerator, tableBody)
{

    let urlParams = window.getQueryString();

    /* make an ajax call */

    $.ajax({

        type: 'GET',
        url: url + '?' + urlParams,
        success: function (response) {

            if (response.code == 200)
            {
                tableBody.empty();
                row_generator(rowGenerator, response, 0, false, tableBody);
            }

        }

    });
}

/* get query string  */

window.getQueryString = function() {

    let urlParams = '';

    /* get param arrays from local storage if there are any */

    let params = localStorage.getItem('filterArray') != null ? JSON.parse(localStorage.getItem('filterArray')) : [];


    /* merge if there are any */
    if (localStorage.getItem('filterKeyUp') != null)
    {
        let keyupFiled = JSON.parse(localStorage.getItem('filterKeyUp'));

        params.push(keyupFiled);

    }

    /* merge if there are any  start range date filters */
    if (localStorage.getItem('rangeStartFilters') != null)
    {
        let start = JSON.parse(localStorage.getItem('rangeStartFilters'));

        params.push(start);

    }

    /* merge if there are any  end range date filters */
    if (localStorage.getItem('rangeEndFilters') != null)
    {
        let end = JSON.parse(localStorage.getItem('rangeEndFilters'));

        params.push(end);

    }

    /* generat query sting to filer */

    params.forEach(function (object, index) {

        for (let property in object) {

            urlParams += property + '[]=' + object[property];
            urlParams += '&';

        }

    });

    return urlParams;

}