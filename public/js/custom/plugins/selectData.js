// var elId = $()
(function(document, window, $) {
    $.fn.selectObj = function(id, modal , url , clear, containerClass){
        // Get options
        var selectId = $('#'+id);

        var placeholder = typeof selectId.attr('data-placeholder') != 'undefined' ? selectId.attr('data-placeholder') : 'Seçilməyib';

        var modalId;
        if(modal != false){
            if(typeof modal == 'undefined'){
                modalId  = selectId.closest('.modal').prop('id');
            }else if(typeof modal != 'undefined'){
                console.log('here');
                modalId = modal
            }else{
                modalId  = false;
            }
        }else{
            modalId = false;
        }

        var selectUrl= selectId.data('url');

        if (url) {
            console.log('urlled');
            selectUrl = url;
        }

        // Trigger Select2
        var options =
            {
                ajax: {
                    url: selectUrl,
                    dataType: 'json',
                    delay: 250,
                    // Get Remote Data
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                // Set Parent for modal if not in modal just leave it blank
                placeholder: placeholder,
                width: '100%',
                escapeMarkup: function (markup) {
                    return markup;
                }
            };
        if(clear){
            options.allowClear = true;
        }
        if(modalId != false){
            options.dropdownParent = $('#'+modalId);
        }
        if (containerClass)
        {
            options.containerCssClass = containerClass;
        }
        selectId.select2(options);

    }
})(document, window, jQuery);

(function(document, window, $) {
    $.fn.selectObj2 = function(id, modal , url , clear){
        // Get options
        var selectId = $('.'+id);
        var modalId;
        if(modal != false){
            if(typeof modal == 'undefined'){
                modalId  = selectId.closest('.modal').prop('id');
            }else if(typeof modal != 'undefined'){
                console.log('here');
                modalId = modal
            }else{
                modalId  = false;
            }
        }else{
            modalId = false;
        }

        var selectUrl= selectId.data('url');

        if (url) {
            console.log('urlled');
            selectUrl = url;
        }

        // Trigger Select2
        var options =
            {
                ajax: {
                    url: selectUrl,
                    dataType: 'json',
                    delay: 250,
                    // Get Remote Data
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                // Set Parent for modal if not in modal just leave it blank
                placeholder: 'Seçilməyib',
                width: '100%',
                escapeMarkup: function (markup) {
                    return markup;
                }
            };
        if(clear){
            options.allowClear = true;
        }
        if(modalId != false){
            options.dropdownParent = $('#'+modalId);
        }
        selectId.select2(options);

    }
})(document, window, jQuery);