function removeData(obj , url){
    // Warn for deleting object
    console.log(url);
    swal({
        title: "Bu faylı silməyə razısınız ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Təsdiq",
        cancelButtonText: "İmtina",
        closeOnConfirm: false
    }, function(){
        // Route for Controllers Destroy method
        loader_start($('.loader_panel'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function (data) {
                // Check response if server status code is ok
                if(data == 200){
                    loader_stop($('.loader_panel'));
                    // Remove on the go
                    obj.closest('tr').hide('fast');

                    swal("Silindi","", "success");
                }else if(data == 999){
                    swal("Silinmədi.","Bu məlumat digər bölmələrdə istifadə edilir.", "error");
                    loader_stop($('.loader_panel'));
                }else{
                    swal("", "Əməliyyatı sona çatdırmaq mümkün olmadı! Xahiş olunur bir daha cəhd edin", "error");
                    loader_stop($('.loader_panel'));
                }
            },
            error: function (msg) {
                swal("", "Əməliyyatı sona çatdırmaq mümkün olmadı! Xahiş olunur bir daha cəhd edin", "error");
                loader_stop($('.loader_panel'));
            }
        });

    });

}