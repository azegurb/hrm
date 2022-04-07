/**
 * Created by Heyder Shukurov on 5/5/2017.
 */
function trip_paginate(data,num){
    console.log(data,num);
    console.log(data);
    if( typeof data.orderBusinessTripIdStartDate == 'undefined'){
        data.orderBusinessTripIdStartDate = data.startDate;
    }
    if( typeof data.orderBusinessTripIdEndDate == 'undefined'){
        data.orderBusinessTripIdEndDate = data.endDate;
    }
    if( typeof data.orderBusinessTripIdTripDay == 'undefined'){
        data.orderBusinessTripIdTripDay = data.tripDay;
    }
    if( typeof data.listCountryIdName == 'undefined'){
        data.listCountryIdName = data.listCountryId.name;
    }
    if( typeof data.orderBusinessTripIdTripReason == 'undefined'){
        data.orderBusinessTripIdTripReason = data.tripReason;
    }
    if( typeof data.orderCommonIdOrderNum == 'undefined'){
        data.orderCommonIdOrderNum = data.orderCommonId.orderNum;
    }
    if( typeof data.orderCommonIdOrderDate == 'undefined'){
        data.orderCommonIdOrderDate = data.orderCommonId.orderDate;
    }
    let localRows = ['orderBusinessTripIdStartDate','orderBusinessTripIdEndDate','orderBusinessTripIdTripDay','listCountryIdName','orderBusinessTripIdTripReason','orderCommonIdOrderNum','orderCommonIdOrderDate']
    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.orderBusinessTripIdStartDate +'</td>' +
        '<td>'+ data.orderBusinessTripIdEndDate +'</td>' +
        '<td>'+ data.orderBusinessTripIdTripDay +'</td>' +
        '<td>'+ data.listCountryIdName +'</td>' +
        '<td>'+ data.orderBusinessTripIdTripReason +'</td>' +
        '<td>'+ data.orderCommonIdOrderNum +'</td>' +
        '<td>'+ data.orderCommonIdOrderDate +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/business-trip/'+ data.id +'/edit\' , \'trip-modal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/personal-cards/business-trip/'+ data.id +'  \' )" data-original-title="Sil">' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    let response = {
        html: tr,
        rows: localRows,
        nc: data.nc !== null ? true : false
    }
    return response;
}