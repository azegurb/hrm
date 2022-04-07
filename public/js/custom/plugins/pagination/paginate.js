(function(document, window, $) {
    $.fn.pagination = function(type,id,search,custom,tbodyId){
        var limit   = $('#'+id+'_filter').val();
        if(type == 'load'){
            $.getScript( "/js/custom/plugins/pagination/load-pagination.js" )
                .done(function( script, textStatus ) {
                    $('#'+id).loginate(id,limit,search,custom,tbodyId);
                })
                .fail(function( jqxhr, settings, exception ) {
                    throw new Error('Error in loading Javascript file. Error - exception : '+exception);
                });
        }else if(type == 'numeric'){
            $.getScript( "/js/custom/plugins/pagination/numeric-pagination.js" )
                .done(function( script, textStatus ) {
                    $('#'+id).numeric(id,limit,custom,tbodyId);
                })
                .fail(function( jqxhr, settings, exception ) {
                    throw new Error('Error in loading Javascript file. Error - exception : '+exception);
                });
        }
    };
})(document, window, jQuery);