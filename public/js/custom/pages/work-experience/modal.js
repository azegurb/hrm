function openModal(url , id) {
    var modal = $('#'+id);
    var url = url;
    loader_start($('.loader_panel'));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });
    console.log(url)
    $.ajax({
        // Get Remote data
        url: url,
        type: 'GET',
        success: function (data) {
            if (data != '') {
                loader_stop($('.loader_panel'));
                modal.find('.modal-body').html(data);
                $('#'+id).modal('show');
            } else {
                swal('', 'İstənilən məlumatı əldə etmək mümkün olmadı xahiş olunur yenidən yoxlayın', 'warning');
                loader_stop($('.loader_panel'));
            }
        },
        error: function (msg) {
            swal('', 'İstənilən məlumatı əldə etmək mümkün olmadı xahiş olunur yenidən yoxlayın', 'warning');
            loader_stop($('.loader_panel'));
        }
    });
}