function other_info_paginate(data,num){
    var tr;
    let localRows = ['electionActivitiesNotes','civilServiceNotes','scientificWorksNotes','professionalActivitiesNotes']

    for (member in data) {
        if (data[member]==null){
            data[member] = '';
        }
    }

    tr = '<td>'+ ++num +'</td>' +
        '<td>'+ data.electionActivitiesNotes +'</td>' +
        '<td>'+ data.civilServiceNotes +'</td>' +
        '<td>'+ data.scientificWorksNotes +'</td>' +
        '<td>'+ data.professionalActivitiesNotes +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/other-info/'+ data.id +'/edit\' , \'other-info-modal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/personal-cards/other-info/'+ data.id +'  \' )" data-original-title="Sil">' +
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