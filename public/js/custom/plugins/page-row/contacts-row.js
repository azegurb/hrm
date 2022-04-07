function contacts_paginate(data,num){
    let localRows = ['listContactTypeId.name','contactInfo']
    let tr;
    tr = '<td>'+ num +'</td>' +
         '<td>'+ data.listContactTypeId.name +'</td>' +
         '<td>'+ data.contactInfo +'</td>' +
         '<td class="text-nowrap text-right">' +
         '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/contacts/'+ data.id +'/edit\' , \'contact-modal\')">' +
         '<i class="icon md-edit" aria-hidden="true"></i>' +
         '<span class="tptext tpedit">Düzəliş et</span>' +
         '</div>' +
         '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/contacts/'+ data.id +'  \' )" data-original-title="Sil">' +
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