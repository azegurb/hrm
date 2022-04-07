function permission_pagination(data,num){

    switch (data.isApprowed){
        case 1:
            data.isApprowed = 'Baxılmayıb';
            break;
        case 2:
            data.isApprowed = 'Təsdiqlənib';
            break;
        case 3:
            data.isApprowed = 'İmtina edilib';
    }

    var f_name, l_name, reason_name;

    if(typeof data.allowerUserIdFirstName != 'undefined'){
        f_name = data.allowerUserIdFirstName;
    }else if(typeof data.allowerUserId.firstName != 'undefined'){
        f_name = data.allowerUserId.firstName;
    }else{
        f_name = ' ';
    }

    if(typeof data.allowerUserIdLastName != 'undefined'){
        l_name = data.allowerUserIdLastName;
    }else if(typeof data.allowerUserId.lastName != 'undefined'){
        l_name = data.allowerUserId.lastName;
    }else{
        l_name = ' ';
    }
    if(typeof data.listRequestForPermissionReasonIdName != 'undefined'){
        reason_name = data.listRequestForPermissionReasonIdName;
    }else if(typeof data.listRequestForPermissionReasonId.name != 'undefined'){
        reason_name = data.listRequestForPermissionReasonId.name;
    }else{
        reason_name = ' ';
    }

    var tr;
    tr     =    '<td>'+ num +'</td>' +
                '<td>'+ reason_name +'</td>' +
                '<td>'+ f_name +' '+  l_name + '</td>' +
                '<td>'+ data.startDate +'</td>' +
                '<td>'+ data.endDate +'</td>' +
                '<td>'+ data.isApprowed +'</td>' +
                '<td class="text-nowrap text-right">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/permission/'+ data.id +'/edit\' , \'permissions-modal\')">' +
                '<i class="icon md-edit" aria-hidden="true"></i>' +
                '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/permission/'+ data.id +'  \' )" data-original-title="Sil">' +
                '<i class="icon md-delete" aria-hidden="true"></i>' +
                '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
                '</td>';


    return tr;
}