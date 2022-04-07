$(document).on('shown.bs.modal','.modal', function () {
    $(this).find('form').validate();
});