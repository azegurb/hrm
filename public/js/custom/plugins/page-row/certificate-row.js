function certificate_pagination(data,num){

    let localRows = ['name','name','issueDate','orgName']
    var tr;

   tr = '<td>'+ num +'</td>' +
        '<td>'+ data.name +'</td>' +
        '<td>'+ data.value +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td>'+ data.orgName +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/certificates/'+ data.id +'/edit\' , \'certificates\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/certificates/'+ data.id +'  \' )" data-original-title="Sil">' +
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