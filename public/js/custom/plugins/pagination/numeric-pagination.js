(function(document, window, $) {
    $.fn.numeric = function(id,tbodyId){
        var container;
        var links;
        var limit = 10;
        var loadContainer = document.getElementById(id);
        // Configs
        container = $('#'+id);
        var total  = container.data('total');
        generator(container,limit);

        function browser(url, page){
            var counter   = limit * page - limit;
            var tbody     = typeof tbodyId == 'undefined' ? container.prev('table').find('tbody') : tbodyId;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : url+'?page='+page+'&limit='+ limit,
                type: 'GET',
                success: function (data) {
                    if(data.code == 200){
                        container.find('.pagination-loader').hide('fast');
                        loadContainer.setAttribute('data-page' , data.page);
                        // Prev Button
                        var lastNumber = tbody.find('tr').last().find('td').first().text();
                        lastNumber = lastNumber - limit;
                        if(lastNumber == limit){
                            $('.prev-page').addClass('disabled').addClass('disabled-hover');
                        }else{
                            $('.prev-page').removeClass('disabled').removeClass('disabled-hover');
                        }
                        // -----------
                        // Next Button
                        // -----------
                        lastNumber = lastNumber + 2*limit;

                        console.log(lastNumber,total);
                        if(lastNumber > total){
                            $('.next-page').addClass('disabled').addClass('disabled-hover');
                        }else{
                            $('.next-page').removeClass('disabled').removeClass('disabled-hover');
                        }
                        //

                        return eval('row_generator')(id,data,counter,true,tbody);
                    }
                }
            });
        };

        //Numeric pagination generator
        function generator(){
            var tbody     = typeof tbodyId == 'undefined' ? container.prev('table').find('tbody') : tbodyId;
            var url    = container.data('url');
            var number = total/limit;
            number = Math.ceil(number);
            var element = '';
            var paginationElement;
            var prevlink = '<li class="page-item pb-links prev-page disabled disabled-hover"><a class="page-link paginate-prev" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
            var nextlink = '<li class="page-item pb-links next-page "><a class="page-link next-prev" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
            for( var i = 1; i <= number; i++){
                element += '<li class="page-item pb-links"><a class="page-link paginate-link" data-i="'+i+'">'+i+'</a></li>';
            }
            paginationElement = '<ul class="pagination pagination-lg">'+prevlink+element+nextlink+'</ul>';

            container.html(paginationElement);

            $('.paginate-link').on('click' , function(){
                var page = $(this).data('i');
                return eval('browser')(url,page);
            })
            $('.paginate-prev').on('click' , function(){
                page = loadContainer.getAttribute('data-page');
                --page;
                console.log(page);
                return eval('browser')(url,page);
            })
            $('.next-prev').on('click' , function(){
                page = loadContainer.getAttribute('data-page');
                ++page;
                return eval('browser')(url,page);
            })
        }

    };
})(document, window, jQuery);
