function vocation_pagination(data,num){
    if( typeof data.listVacationTypeIdName == 'undefined'){
        data.listVacationTypeIdName = data.listVacationTypeId.name;
    }
    if( typeof data.orderCommonIdOrderNum == 'undefined'){
        data.orderCommonIdOrderNum = data.orderCommonId.orderNum;
    }
    if( typeof data.orderCommonIdOrderDate == 'undefined'){
        data.orderCommonIdOrderDate = data.orderCommonId.orderDate;
    }
    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.orderBusinessTripIdStartDate +'</td>' +
        '<td>'+ data.orderBusinessTripIdEndDate +'</td>' +
        '<td>'+ data.orderBusinessTripIdTripDay +'</td>' +
        '<td>'+ data.listCountryIdName +'</td>' +
        '<td>'+ data.orderBusinessTripIdTripReason +'</td>' +
        '<td>'+ data.orderCommonIdOrderNum +'</td>' +
        '<td>'+ data.orderCommonIdOrderDate +'</td>' +z
        '<td class="text-right"><div class="btn btn-pro btn-animate btn-animate-side btn-primary waves-effect"' +
        'onclick="editData(\'/personal-cards/vocation/'+ data.id +'/edit\' , \'trip-modal\')">' +
        '<span><i class="icon md-edit" aria-hidden="true"></i>Dəyiş</span></div> ' +
        ' <div class="btn btn-pro btn-animate btn-animate-side btn-primary waves-effect"' +
        'onclick="removeData($(this) , \'/personal-cards/vocation/'+ data.id +'  \' )">' +
        '<span><i class="icon md-delete" aria-hidden="true"></i>Sil</span></div>' +
        '</td>';
    return tr;
}

