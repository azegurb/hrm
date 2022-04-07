function toggletree(id) {
    var tr = '';
    if($('#'+id).attr('data-expanded') == 'false'){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            // Get Remote data
            url: '/personal-cards/order-vocation-detail/'+id,
            type: 'GET',
            success: function (data) {
                if(data.code == 200){
                    if(Array.isArray(data.data)) {
                        data.data.forEach(function (item) {
                            tr += '<div class="col-md-12 body-div mt-10 ml-20">' +
                                '<div class="col-md-3 float-left mb-10 mt-10">' + item.vacationWorkPeriodFrom + ' - ' + item.vacationWorkPeriodTo + '</div>' +
                                '<div class="col-md-3 float-left mb-10 mt-10">' + item.startDate + '</div>' +
                                '<div class="col-md-3 float-left mb-10 mt-10">' + item.endDate + '</div>' +
                                '<div class="col-md-3 float-left mb-10 mt-10">' + item.vacationDay + '</div>' +
                                '</div>';
                        });

                        $('#' + id + '_hidden').find('#tree-body').html(tr);
                        $('#' + id + '_hidden').show('fast');
                        $('#' + id).attr('data-expanded', 'true')
                    }
                }
            }
        });
    }else if($('#'+id).attr('data-expanded') == 'true'){
        $('#'+id+'_hidden').hide('fast');
        $('#'+id).attr('data-expanded', 'false')
    }
}
