$('#append-new-row').on('click' , function(){

    if ($('#listOrderTypes').val() != null){

        var url = getUrl($('#listOrderTypes').select2('data')[0].sLabel);

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
            type: 'GET',
            success: function (data) {
                if(data != ''){
                    $('#appendArea').append(data);
                }
            },
            error:   function (msg){

            }
        });
    }
});