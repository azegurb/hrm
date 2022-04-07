var empty = false;
function onformClick(){
    empty = true;
}
$(document).on('click' , '.close-modal-s' , function(){
    var close = $(this);
    if(empty != false){
        swal({
            type  : 'warning',
            title : 'Məlumatlar təsdiqlənmədi',
            text  : 'Təsdiqlənmədən bağlansın ?',
            showCancelButton : true,
            cancelButtonText : 'Bəli',
            confirmButtonText : 'Xeyr'
        },function(isConfirm){
            if(!isConfirm){
                close.closest('.modal').modal('hide');
                empty = false;
            }
        })
    }else{
        $(this).closest('.modal').modal('hide');
    }
});

$(document).on('hidden.bs.modal','.modal-on-close', function (e) {
    $('#'+$(this).attr('id')+'_form input').each(function () {
        if($(this).prop('name') != '_token'){
            if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox'){
            }else{
                if ($(this).attr('type') == 'hidden')
                {
                    $(this).remove();
                } else {
                    $(this).val('');
                }
            }
        }
    });

    $('.select').val('');
    $(this).find('input[type=checkbox]').not("#current").prop('checked', '');
    $(this).find('textarea').val('');
    if (typeof $(this).find('.select').val() != 'undefined') {
        $(this).find('.select').select2('val', '');
    }
    $(this).find('.modal_form').attr('data-id' , '');
    var formurl = document.getElementById($(this).attr('id')+'_form');
    var url     = formurl.getAttribute('data-url');
    $('input[type="radio"]').not('#current, #archive').prop('checked' , false);
    $('input[type="checkbox"]').prop('checked' , false);

    // $('input[type="radio"]').each(function () {
    //
    //     alert($(this).attr('id'))
    //     if($(this).attr('id')!='current'){
    //
    //         $(this).prop('checked' , false);
    //
    //     }
    // });

    $(this).find('.modal_form').attr('action' , url);
    $(this).find('.modal_form').find('input[name="_method"]').remove();
    $('#expand').html('');
});