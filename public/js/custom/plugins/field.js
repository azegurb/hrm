function fields(id , fields , change , pagination , url ,tbody){
    var option = null;
    var loadContainer = document.getElementById(pagination);
    if(typeof fields == 'object'){
        var keys = Object.keys(fields);
        for (var index in keys) {
            option += '<option value="'+keys[index]+'">'+fields[keys[index]]+'</option>';
        }
        $('#searchField').html('<select class="form-control" id="'+id+'_search">'+option+'</select>');
    }else if(typeof fields == 'string'){
        $('#searchField').html('<select class="form-control" data-url="'+fields+'" id="'+id+'_search"></select>');
        $('#searchField').find('select#'+id+'_search').selectObj(id+'_search' , 'dis-res-search');
    }

    // If Change set true will change all data in table based on selected value
    if(typeof change == 'object' && change.change == true){
        $('#searchField').find('select#'+id+'_search').on('change' , function(){
            var selectedField = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url+'?page=1&search='+''+'&field='+selectedField+'&limit='+ 10,
                type: 'GET',
                success: function (data) {
                    if(data.code == 200 && !Array.isArray(data.data.entities)) {
                        loadContainer.setAttribute('data-page', 1);
                        $('#' + pagination).find('.btn-load-more').show();
                        return eval('row_generator')(pagination,data, 0, true, tbody);
                    }else{
                        var colspan = tbody.prev().find('tr').find('th').length;
                        tbody.html('<td colspan="'+colspan+'"><div class="alert alert-warning text-center" role="alert">Heç bir məlumat daxil edilməmişdir !</div></td>');
                        $('#' + pagination).find('.btn-load-more').hide();
                    }
                }
            });
        })

    }
}