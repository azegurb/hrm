function orders_paginate(data,num){
    console.log(data);
    var tr;

    var orderType;

    if(typeof data.orderDate === "string" ){
        var date = data.orderDate;
    }else{
        var date = moment(data.orderDate).format("DD.MM.YYYY");
    }

    if (data.listOrderTypeId.name !== null) {
        orderType = data.listOrderTypeId.name;
    }

    tr =    '<td>' + num + '</td>' +
            '<td>' + orderType + '</td>' +
            '<td>' + data.orderNum + '</td>' +
            '<td>' + date + '</td>' +
            '<td class="text-nowrap text-right">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" ' +
                        'onclick="openModal(\'/orders/' + data.id + '/edit\', \'ordersModal\')" title="Düzəliş et">' +
                    '<i class="icon md-edit" aria-hidden="true"></i>' +
                    '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                // '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" ' +
                //     'onclick="removeData($(this), \'/orders/'+data.id+'\')" title="Sil">' +
                //     '<i class="icon md-delete" aria-hidden="true"></i>' +
                //     '<span class="tptext tpdel">Sil</span>' +
                // '</div>' +
            '</td>';

    return tr;
}
