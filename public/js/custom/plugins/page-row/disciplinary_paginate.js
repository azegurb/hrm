function disciplinary_paginate(data,num){
    var tr;
    let localRows = ['listDisciplinaryActionTypeIdName','reason','issueDate']
    if (typeof data.listDisciplinaryActionTypeIdName == 'undefined'){
        data.listDisciplinaryActionTypeIdName = data.listDisciplinaryActionTypeId.name;
    }
    data.reason = data.reason != null ? data.reason : '';
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listDisciplinaryActionTypeIdName +'</td>' +
        '<td>'+ data.reason +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/disciplinary/'+ data.id +'/edit\' , \'disciplinary-responsibility\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/disciplinary/'+ data.id +'  \' )" data-original-title="Sil">' +
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