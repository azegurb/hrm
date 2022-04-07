/**
 * Created by Asan on 5/17/2017.
 */
$(document).on('change' , '.select' , function(){
    if (typeof $(this).select2('data')[0] != 'undefined'){
        $(this).prev('input.append').val($(this).select2('data')[0].text);
    }
});
