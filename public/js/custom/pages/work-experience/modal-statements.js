// Delay Function execution
var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();
// If Different Org Checked
$(document).on('click' , '#differentOrg' ,function () {
    if($(this).is(':checked')){
            var url = '/personal-cards/checkedStatement';
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
                    if (data != '') {
                        $('#appendonchange').html(data);
                    } else {
                        swal('', 'İstənilən məlumatı əldə etmək mümkün olmadı xahiş olunur yenidən yoxlayın', 'warning');
                    }
                },
                error: function (msg) {
                    swal('', 'İstənilən məlumatı əldə etmək mümkün olmadı xahiş olunur yenidən yoxlayın', 'warning');
                }
            });
    }else{
        var url = '/personal-cards/uncheckedStatement';
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
                if (data != '') {
                    $('#appendonchange').html(data);
                } else {
                    swal('', 'İstənilən məlumatı əldə etmək mümkün olmadı xahiş olunur yenidən yoxlayın', 'warning');
                }
            },
            error: function (msg) {
                swal('', 'İstənilən məlumatı əldə etmək mümkün olmadı xahiş olunur yenidən yoxlayın', 'warning');
            }
        });
    }
});
// EndIf Diff Checked
// If Civil Work Checked
$(document).on('click' , '#differentOrgIsCivilService' ,function () {
    if($(this).is(':checked')){
    $('#differentOrgListContractTypeIdContainer').html('' +
        '<h4>Əmək müqaviləsi:</h4>' +
        '<select name="differentOrgListContractTypeId" id="differentOrgListContractTypeId" data-url="/helper-lists/labor-contracts/select/true"></select>'+
        '');
    }else{
        $('#differentOrgListContractTypeIdContainer').html('' +
            '<h4>Əmək müqaviləsi:</h4>' +
            '<select name="differentOrgListContractTypeId" id="differentOrgListContractTypeId" data-url="/helper-lists/labor-contracts/select/false"></select>'+
            '');
    }
    $('#differentOrgListContractTypeId').selectObj('differentOrgListContractTypeId');
});
// EndIf Civil Work Checked
// If Order Num Changed
function getCommon(elem){
    //Clear OrderNum Id Field
    $('#orderNumId').val('');
    // End Clear Inside of orderNum field
    delay(function(){
        var text = elem.val();
        if(text != ''){
            var orderTypeId = $('#order-type').val();
            var orderId;
            // If typed and order type not selected will add label
            if(orderTypeId != null){
                orderId = $('#order-type').val();
                var url  = '/personal-cards/orderAppointments/'+text+'?orderTypeId='+orderId;
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
                        if (data != 404){
                            var resultArr = '';
                            data.forEach(function(item){
                                resultArr += '<li class="searchResults" onclick="selectedOrderNum($(this))" data-id="'+item.id+'">'+item.orderNum+'</li>';
                            });
                            $('#search-results').html('' +
                                '<div class="searchBar-input">'+
                                '<ul>'+ resultArr +'</ul>'+
                                '</div>');
                        }else{
                            $('#search-results').html('');
                        }
                    }
                });
            }else{
                orderId = null;
                $('#order-type').closest('div').find('#ordertypelabel').html('<label class="error" for="orderNum"><small>İlkin bu sahə doldurulmalıdır.</small></label>')
                elem.val('');
            }
        }else{
            $('#search-results').html('');
        }
    },250);
    // if clicked to select remove added label
    $('#order-type').closest('div').find('.select2-selection').on('click',function(){
        $('#order-type').closest('div').find('#ordertypelabel').html('');
    });
    // if clicked to modal body close search field
// endif clicked to modal body close search field
}
// EndIf Order Num Changed
// When selected OrderNum
function selectedOrderNum(obj){
    // Close the result field
    $('#search-results').html('');
    //  Write selected data into Input
    $('#orderNum').val(obj.text());
    $('#orderNumId').val(obj.data('id'));
    $('#appointmentField').val('');
    //Prepare for getting remote data from WS
    var url = 'orderAppointments/'+obj.data('id')+'/get/data';
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
            console.log(data);
            if(data != 404){
                var response = data[0];
                $('#appointmentField').val(response.id);
                if(response.civilService){
                    $('#differentOrgIsCivilService').attr('checked' , true);
                }else{
                    $('#differentOrgIsCivilService').attr('checked' , false);
                }
                // Select Structure
                var selectParent = $('#structureId');
                var optionselectParentID = $('<option></option>').attr('selected', true).text(response.positionId.structureId.parentId.name+' '+response.positionId.structureId.name).val(response.positionId.structureId.id);
                /* insert the option (which is already 'selected'!) into the select */
                optionselectParentID.appendTo(selectParent);
                /* Let select2 do whatever it likes with this */
                selectParent.trigger('change');

                // Select Position
                var selectParent = $('#positionId');
                var optionselectParentID = $('<option></option>').attr('selected', true).text(response.positionId.posNameId.name).val(response.positionId.id);
                /* insert the option (which is already 'selected'!) into the select */
                optionselectParentID.appendTo(selectParent);
                /* Let select2 do whatever it likes with this */
                selectParent.trigger('change');

                // Select ContractType
                var selectParent = $('#differentOrgListContractTypeId');
                var optionselectParentID = $('<option></option>').attr('selected', true).text(response.listContractTypeId.name).val(response.listContractTypeId.id);
                /* insert the option (which is already 'selected'!) into the select */
                optionselectParentID.appendTo(selectParent);
                /* Let select2 do whatever it likes with this */
                selectParent.trigger('change');

                // Write Value of StartDate
                $('#startDate').val(response.startDate);
                // Write Value of appointmentMonth
                $('#appointmentMonth').val(response.appointmentMonth);
            }
        }
    });

}
//endOrderNum Selected
// Civil Checkbox if checked get civil positions else non civil
$(document).on('change' , '#structureId' , function(){
    var structureId = $(this).val();
        $('#civilContainer').html('<select name="positionId" required id="positionId" data-url="/helper-lists/position-select/'+structureId+'">');
        $('#positionId').selectObj('positionId');
});
// Civil Checkbox if checked get civil positions else non civil
$(document).on('click',function(e)
{
    var container = $("#order-type-container");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        $('#search-results').html('');
    }
});


//Set Url
function modalFormUrl(url){
    if(typeof url != 'undefined'){
        $('#work-experiance-modal_form').attr('action' , url);
        $('#work-experiance-modal_form').attr('method' , 'PUT');
    }else{
        $('#work-experiance-modal_form').attr('method' , 'POST');
    }
};