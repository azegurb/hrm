/**
 * Created by Asan on 6/3/2017.
 */
function userByTree(id){
    var count;
    var rowNumber;
    $('#user-search').attr('data-id' , id);
    var search = $('#user-search').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });
    $(document).ready(function(){
        $.ajax({
            // Get Remote data
            url: '/get-users/json?structureId='+id+'&search='+search,
            type: 'GET',
            success: function (data) {
                console.log(data);
                if(data.code == 200 && Array.isArray(data.data)){
                    var loadContainer = document.getElementById('users_paginate');
                    loadContainer.setAttribute('data-page' , 1);
                    loadContainer.setAttribute('data-total' , data.totalCount);
                    var num = 0;
                    tr = '';
                    method = 'users_paginate';
                    data.data.forEach(function(item){
                        ++num;
                        tr += '<tr id="'+item.id+'">'+ eval(method)(item,num) +'</tr>';
                    });
                    $('#users-tbody').html(tr);
                    count = data.totalCount;
                    rowNumber = $('#users-tbody').find('tr').last().find('td').first().text();
                    console.log(rowNumber,count);
                    console.log(rowNumber < count);
                    if(rowNumber < count) {
                        $('#users_paginate').find('.btn-load-more').show();
                    }else{
                        $('#users_paginate').find('.btn-load-more').hide();
                    }
                }else{
                    $('#users-tbody').html('<td colspan="6"><div class="alert alert-warning text-center" role="alert"><strong>"'+ search +'" </strong> &mdash; uyğun əməkdaş tapılmadı !</div></td>');
                    $('#users_paginate').find('.btn-load-more').hide();
                }
            },
            error:   function (msg){}
        });
    });
}
