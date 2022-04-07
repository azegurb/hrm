$('.load-link').on('click' , function(){
    loader_start($('.loader_panel'));
    var url = $(this).data('url');
    var tabId = $(this).attr('aria-controls');
    if(typeof url != 'undefined'){
        $('#'+tabId).load( url+'?load=true', function(){
            loader_stop($('.loader_panel'));
            $('.date-picker').datepicker({
                format: 'dd.mm.yyyy',
                language: 'az',
                clearBtn: true,
                todayHighlight: true,
                weekStart: 1,
                autoclose: true
            });
            $('.close-modal').on('click' , function(){
                $('.modal').modal('hide');
            })
        });
    }
});