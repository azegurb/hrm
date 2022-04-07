(function(document, window, $) {
    $.fn.search = function(id,pagination,arrayOfFields,change,tbodyId,custom){

        var action = true;
        var search;
        var limit;
        var limitId;
        var isarchived='';
        var url = $('#'+pagination).data('url');
        var loadContainer = document.getElementById(pagination);
        var appender = typeof custom != 'undefined' ? custom : 'row_generator';

        if(typeof change == 'object' && change != ''){
            var change = change;
            var tbodyId = tbodyId;
        }else if(typeof change == 'string' && change != ''){
            var tbodyId = change;
            var change  = null;
        }
        var tbody     = typeof tbodyId == 'undefined' ? $('#'+pagination).prev('table').find('tbody') : $('#'+tbodyId);
        var fieldFilter = false;
        var field;
        if(typeof arrayOfFields == 'object' || typeof arrayOfFields == 'string' && arrayOfFields.search('http:') != -1 && arrayOfFields != ''){
            $.getScript( "/js/custom/plugins/field.js" )
                .done(function() {
                    fields(id,arrayOfFields,change,pagination,url,tbody);
                    fieldFilter = true;
                })
                .fail(function( jqxhr, settings, exception ) {
                    throw new Error('Error in loading Javascript file. Error Message : '+exception);
                });
        }

        $('#'+id).on('keyup' , function(e){

            if($('#currentA').length>0){

                if($("#currentA option").filter(":selected").val()=='3'){

                    isarchived='&isArchived=true';

                }
                else if($("#currentA option").filter(":selected").val()=='2') {

                    isarchived='&isArchived=false';

                }
                else {

                    isarchived='';
                }

            }

            delay(function(){
                var structureId = '';
                if(typeof $('#user-search').attr('data-id') != 'undefined'){
                    structureId = $('#user-search').attr('data-id');
                }

                limitId = pagination+'_filter';
                limit   = $('#'+limitId).val();
                search  = $('#'+id).val();
                if(fieldFilter == true){
                    field = $('select#'+id+'_search').val();
                }

                if(action == true){
                    action = false;
                    $('.search-loader').show();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url+'?page=1&search='+search+'&field='+field+'&limit='+ limit+'&structureId='+structureId+isarchived,
                        type: 'GET',
                        success: function (data) {
                            var count = data.totalCount;
                            var rowNumber = tbody.find('tr').last().find('td').first().text();

                            if(data.code == 200 && !Array.isArray(data.data.entities)) {
                                loadContainer.setAttribute('data-page', 1);

                                eval(appender)(pagination,data, 0, true, tbody , 'search');
                                if(rowNumber < count) {
                                    $('#' + pagination).find('.btn-load-more').show();
                                }else{
                                    $('#' + pagination).find('.btn-load-more').hide();
                                }
                            }else{
                                var colspan = tbody.prev().find('tr').find('th').length;
                                tbody.html('<td colspan="'+colspan+'"><div class="alert alert-warning text-center" role="alert"><strong>"'+ search +'" </strong> &mdash; uyğun məlumat tapılmadı !</div></td>');
                                $('#' + pagination).find('.btn-load-more').hide();
                            }
                        }
                    });
                    $( document ).ajaxComplete(function() {
                        action = true;
                        $('.search-loader').hide();
                    });
                }
            },250);
        });
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

    };
})(document, window, jQuery);
(function(document, window, $) {
    $.fn.search2 = function(id,pagination,arrayOfFields,change,tbodyId,custom){

        var action = true;
        var search;
        var limit;
        var limitId;
        var url = $('#'+pagination).data('url');
        var loadContainer = document.getElementById(pagination);
        var appender = typeof custom != 'undefined' ? custom : 'row_generator';

        if(typeof change == 'object' && change != ''){
            var change = change;
            var tbodyId = tbodyId;
        }else if(typeof change == 'string' && change != ''){
            var tbodyId = change;
            var change  = null;
        }
        var tbody     = typeof tbodyId == 'undefined' ? $('#'+pagination).prev('table').find('tbody') : $('#'+tbodyId);
        var fieldFilter = false;
        var field;
        var isarchived='';




        if(typeof arrayOfFields == 'object' || typeof arrayOfFields == 'string' && arrayOfFields.search('http:') != -1 && arrayOfFields != ''){
            $.getScript( "/js/custom/plugins/field.js" )
                .done(function() {
                    fields(id,arrayOfFields,change,pagination,url,tbody);
                    fieldFilter = true;
                })
                .fail(function( jqxhr, settings, exception ) {
                    throw new Error('Error in loading Javascript file. Error Message : '+exception);
                });
        }

        $('#'+id).on('keyup' , function(e){

            if($('#currentA').length>0){


                if($("#currentA option").filter(":selected").val()=='3'){

                    isarchived='&isArchived=true';

                }
                else if($("#currentA option").filter(":selected").val()=='2') {

                    isarchived='&isArchived=false';

                }
                else {
                    isarchived='';
                }

            }

            delay(function(){
                var structureId = '';
                if(typeof $('#user-search').attr('data-id') != 'undefined'){
                    structureId = $('#user-search').attr('data-id');
                }

                limitId = pagination+'_filter';
                limit   = $('#'+limitId).val();
                search  = $('#'+id).val();
                if(fieldFilter == true){
                    field = $('select#'+id+'_search').val();
                }

                if(action == true){
                    action = false;
                    $('.search-loader').show();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url+'?page=1&search='+search+'&field='+field+'&limit='+ limit+'&structureId='+structureId+isarchived,
                        type: 'GET',
                        success: function (data) {
                            if(typeof data.hasError != 'udnefined' && data.hasError){
                                return eH(data);
                            }
                            var count = data.totalCount;
                            var rowNumber = tbody.find('tr').last().find('td').first().text();

                            if(data.code == 200 && !Array.isArray(data.data.entities)) {
                                loadContainer.setAttribute('data-page', 1);
                                eval(appender)(pagination,data, 0, true, tbody , 'search');
                                if(rowNumber < count) {
                                    $('#' + pagination).find('.btn-load-more').show();
                                }else{
                                    $('#' + pagination).find('.btn-load-more').hide();
                                }
                            }else{
                                var colspan = tbody.prev().find('tr').find('th').length;
                                tbody.html('<td colspan="'+colspan+'"><div class="alert alert-warning text-center" role="alert"><strong>"'+ search +'" </strong> &mdash; uyğun məlumat tapılmadı !</div></td>');
                                $('#' + pagination).find('.btn-load-more').hide();
                            }
                        }
                    });
                    $( document ).ajaxComplete(function() {
                        action = true;
                        $('.search-loader').hide();
                    });
                }
            },250);
        });
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

    };
})(document, window, jQuery);

