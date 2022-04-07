function academicdegree_paginate(data,num){
    var tr;
    let localRows = ['listAcademicDegreeId.name','listAcademicAreaId.name','issueDate','orgName','docInfo']
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listAcademicDegreeId.name +'</td>' +
        '<td>'+ data.listAcademicAreaId.name +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td>'+ data.orgName +'</td>' +
        '<td>'+ data.docInfo +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/academic-degree/'+ data.id +'/edit\' , \'qualificationmodal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/academic-degree/'+ data.id +'  \' )">' +
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

