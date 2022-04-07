/**
 * Created by Asan on 5/15/2017.
 */
function refresh(method,data, rowNumber, m, tbody,modal){
    modal.closest('.modal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    $('#side-navs').find('.list-group-item').each(function(){
        if ($(this).hasClass("active")) {
            $(this).click();
        }
    });
}
