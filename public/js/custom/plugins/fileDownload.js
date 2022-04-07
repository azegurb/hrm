function fileDownload(id){
    loader_start($('.loader_panel'));
    var url = 'personal-cards/filedownload/'+id;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            loader_stop($('.loader_panel'));
            $('#document-file').modal('show');
            var file = '';
            if(data.length > 0){
                data.forEach(function(item){
                    console.log(item);
                    file += '' +
                        '<tr>'+
                        '<td>'+item.fileId.name+'.'+item.fileId.ext+'</td>'+
                        '<td class="text-right">'+
                            `<button type="button" class="btn btn-primary p-5" onclick="download('${item.fileId.url}','${item.fileId.name}','${item.fileId.ext}')"><i style="font-size:18px" class="icon md-download" aria-hidden="true"></i></button>`+
                        '</td>'+
                        '</tr>';
                });
            }
            $('#document-file').find('tbody').html(file);
        }
    });
}

function download(urlData , name , ext){
    var url = 'personal-cards/download';
    loader_start($('#download-modal-body'));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });
    $.ajax({
        url: url,
        type: 'POST',
        data: {urlData,name,ext},
        success: function (data) {
            loader_stop($('#download-modal-body'));
            swal({
                title: "",
                text: '<button type="button" class="close" style="position: absolute;top: 1px;right: 10px;" onclick="swal.close()" aria-label="Close">'+
                '<span aria-hidden="true" onclick="swal.close()" style="font-size: 30px">×</span></button>' +
                '<p>Fayl komputerinizə yüklənəcək. Razısınız ?</p>'+
                '<a type="button" onclick="swal.close()" class="btn btn-lg btn-primary" tabindex="2" style="display: inline-block;">İmtina</a>' +
                '&ensp; <a type="button" href="data:'+data.mime+';base64,'+data.data[0].encodedFile+'" onclick="swal.close()" download class=" btn btn-lg btn-primary" data-con="true" tabindex="1" style="display: inline-block;">Təsdiq</a>',
                type: 'info',
                html: true,
                showCancelButton: false,
                allowEscapeKey:true,
                allowOutsideClick:false,
                showConfirmButton: false,
                closeOnConfirm: false,
                closeOnCancel: false,
                animation: "slide-from-top",
            });
        }
    });
}