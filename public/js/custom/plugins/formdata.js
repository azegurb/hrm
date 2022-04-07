function postForm(form,custom,file){
    if(form.valid()) {
        var id = form.closest('.modal');
        var method = form.attr('method');
        var url = form.attr('action');
        var ajaxFile;
        var formData;
        //construction

        if(file == true) {
            var formEl = form[0];
                formdata = new FormData(formEl);
        }else{
            formdata = form.serialize();
        }
        //construction
        var tbody;
        if(form.data('tb') != ''){
            tbody = $('tbody#'+form.data('tb'));
        }else{
            tbody = form.closest('.modal').prev().find('tbody');
        }

        var genRow = form.closest('.modal').prev().find('.load-more-container');
        var appender = typeof custom != 'undefined' ? custom : 'row_generator';
        loader_start($('.loader_panel'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var request = {
            // Get Remote data
            url: url,
            type: method,
                data: formdata,
            success: function (data) {
                if(typeof data.headers != 'undefined' && typeof data.headers[0] != 'undefined' && data.headers['hasConfirm'][0]=='true'){
                    swal('', 'Təsdiqə göndərildi', 'info');
                }
                if (data.code == 201) {
                    loader_stop($('.loader_panel'));
                    id.modal('hide');
                    var method = form.data('pid') != '' ? form.data('pid') : genRow.attr('id');

                    var rowNumber = tbody.find('tr').last().find('td').first().text();
                    rowNumber = parseInt(rowNumber);
                    if(isNaN(rowNumber)){
                        rowNumber = 0;
                        tbody.find('tr').last().remove();
                    }
                    return eval(appender)(method,data, rowNumber, 'add', tbody,form);
                } else if (data.code == 200) {
                    loader_stop($('.loader_panel'));
                    id.modal('hide');
                    var method = form.data('pid') != '' ? form.data('pid') : genRow.attr('id');
                    if(typeof data.headers != 'undefined' && typeof data.headers[0] != 'undefined' && data.headers['hasConfirm'][0]=='true'){
                        tbody = $('tr#' + data.data.mainId.id);
                    }else{
                        tbody = $('tr#' + data.data.id);
                    }

                    var rowNumber = tbody.find('td').first().text();
                    return eval(appender)(method,data, rowNumber, 'edit', tbody, form);
                }else{
                    if(data.code == 500){
                        swal("500", "Əməliyyat zamanı xəta baş verdi. \n "+data.message, "error");
                        loader_stop($('.loader_panel'));
                    }else{
                        if(data.notselected){

                            swal(""+data.code+"", data.notselected, "error");
                            loader_stop($('.loader_panel'));
                        }
                        else {

                            swal(""+data.code+"", "Əməliyyatı sona çatdırmaq mümkün olmadı! Xahiş olunur bir daha cəhd edin", "error");
                            loader_stop($('.loader_panel'));
                        }

                    }
                }
            },
            error: function (msg) {
                if(msg.code == 500){
                    swal("500", "Əməliyyat zamanı xəta baş verdi. \n "+msg.message, "error");
                    loader_stop($('.loader_panel'));
                }
                var status = typeof msg.status != 'undefined' ?  msg.status : '';
                if(status == 422){
                    swal(""+status+"", "Xahiş olunur xanaların düzgün doldurulduğuna əmin olun", "error");
                }else{
                    swal(""+status+"", "Əməliyyatı sona çatdırmaq mümkün olmadı! Xahiş olunur bir daha cəhd edin", "error");
                }
                loader_stop($('.loader_panel'));
            }
        };

        if(file == true) {
            request.dataType = 'json';
            request.processData = false;
            request.contentType = false;
        }
        $.ajax(request);
    }
};