(function(document, window, $) {
    $.fn.loginate = function(id,limit,search,custom,tbodyId){
        // Configs
        var container = $('#'+id);
        var url       = container.data('url');
        var total     = container.data('total');
        var loadContainer = document.getElementById(id);
        var page;
        var tbody     = typeof tbodyId == 'undefined' ? container.prev('table').find('tbody') : tbodyId;
        var appender = typeof custom != 'undefined' ? custom : 'row_generator';
        var rowNumber;
        var action = false;
        var searching;
        var structure;
        //

        //
        // Find last number of table row for comparing and counting while attaching data to table
        //
        rowNumber = tbody.find('tr').last().find('td').first().text();
        //
        // First Time on click
        //
        if(isNaN(rowNumber)){
            rowNumber = 0;
        }
        if(rowNumber < total) {
            $('#' + id).find('.btn-load-more').on('click', function () {
                $(this).hide('hide');
                action = true;
                $('html,body').animate({
                        scrollTop: $(".site-footer").offset().top},
                    'slow');
            });
        }else{
            $('#' + id).find('.btn-load-more').hide();
        }

        $(window).scroll(function(){
            if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
                //
                // Find last number of table row for comparing and counting while attaching data to table
                //
                rowNumber = tbody.find('tr').last().find('td').first().text();
                //
                // Check if searchbar data is exists
                //
                if($('#'+search).val() != 'undefined' || typeof $('#'+search).val() != 'undefined'){
                    searching = $('#'+search).val();
                }else{
                    searching = '';
                }
                // Check if searchbar data-id is exists
                //
                if(typeof $('#'+search).data('id') != 'undefined'){
                    structure = $('#'+search).data('id');
                }else{
                    structure = '';
                }

                // ----------------------------FILTER PARAMS---

                var urlParams = window.getQueryString();

                //-------------------------------------------

                var isarchive='';

                if($("#currentA option").filter(":selected").val()=='3'){

                    isarchive='&isArchived=true';

                }
                else if($("#currentA option").filter(":selected").val()=='2'){

                    isarchive='&isArchived=false';
                }

                //
                // Compare the last number of row and total count
                //
                if(rowNumber < total && action == true){
                    page = loadContainer.getAttribute('data-page');
                    action = false;
                    rowNumber = tbody.find('tr').last().find('td').first().text();
                    container.find('.pagination-loader').show('fast');
                    //
                    //Get Remote Data from Database
                    //
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        //
                        // Make query
                        url: url+'?page='+ (++page) +'&search='+searching+'&limit='+limit+'&structureId='+structure+isarchive
                        +'&'+urlParams,
                        type: 'GET',
                        success: function (data) {
                            // Check Response code if OK then create new rows
                            if(data.code == 200 && Array.isArray(data.data)){
                                container.find('.pagination-loader').hide('fast');
                                loadContainer.setAttribute('data-page' , data.page);
                                action = true;
                                return eval(appender)(id,data,rowNumber,false,tbody);
                            }else{
                                container.find('.pagination-loader').hide();
                                action = false;
                            }
                        }
                    });
                    // $( document ).ajaxComplete(function() {
                    //     action = true;
                    // });
                }
            }
        });

        //
        // Works if limit filter changed
        //
        $('#'+id+'_filter').on('change' , function(){
            rowNumber = 0;
            //
            // Check if searchbar data is exists
            //
            if($('#'+search).val() != 'undefined' || typeof $('#'+search).val() != 'undefined'){
                searching = $('#'+search).val();
            }else{
                searching = '';
            }

            // ----------------------------FILTER PARAMS---

            var urlParams = window.getQueryString();

            //-------------------------------------------

            //
            limit = $(this).val();
            container.find('.pagination-loader').show('fast');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                //
                // Make query
                url: url+'?page=1&search='+searching+'&limit='+ limit  + '&' + urlParams,
                type: 'GET',
                success: function (data) {
                    // Check Response code if OK then create new rows
                    if(data.code == 200){
                        container.find('.pagination-loader').hide('fast');
                        loadContainer.setAttribute('data-page' , 1);
                        return eval(appender)(id,data,rowNumber,true,tbody);
                    }
                }
            });
        });
    };
})(document, window, jQuery);