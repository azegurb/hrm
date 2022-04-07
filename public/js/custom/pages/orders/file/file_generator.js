function showAFile(jobj, label){

    /* send an optional param label to the function  */

    var url = 'orders/gen-file';
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
        type: 'POST',
        data: {obj: jobj, label: label},
        success: function (data) {
            $('#fileShow').find('.modal-body').html(data);
            $('#fileShow').find('input[type="hidden"]#data').val(data);
            $('#fileShow').modal('show');
        }

    });

}