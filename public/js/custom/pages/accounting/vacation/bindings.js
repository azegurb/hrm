
// on year change
$('.container-vacation').on('change', '#year', function () {

    year = $(this).val();

    updateTable();

});

// on month change
$('.container-vacation').on('change', '#month', function () {

    month = $(this).val();

    updateTable();

});

// on keyup search input
$('.container-vacation').on('keyup', '#searchField', function () {

    updateTable();

});