function qualification_pagination(data,num){

    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listPositionClassificationId.name +'</td>' +
        '<td>'+ data.listQualificationTypeId.name +'</td>' +
        '<td>'+ data.requiredWorkExpInDQ +'</td>' +
        '<td>'+ data.requiredWorkExpInCurClasi +'</td>' +
        '<td>'+ data.sequence +'</td>' +
        '<td class="text-right">'+
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="editData(\'/helper-lists/qualification/'+ data.id +'/edit\' , \'qualification-modal\')" ' +
        '>' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="removeData($(this) , \'/helper-lists/qualification/'+ data.id +'  \' )" ' +
        '>' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}