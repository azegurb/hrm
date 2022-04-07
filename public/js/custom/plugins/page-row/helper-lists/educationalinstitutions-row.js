function education_pagination(data,num){
    var instype;
    if(data.listEducationalInstitutionTypeId == null) {
        instype = ' ';
    }else if (typeof data.listEducationalInstitutionTypeId.name !== undefined ){
        instype = data.listEducationalInstitutionTypeId.name;
    }
    // }else if(data.listEducationalInstitutionTypeId !== null){
    //
    // }
    console.log(data);
    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.name +'</td>' +
        '<td>'+ instype +'</td>' +
        '<td class="text-right">'+
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="editData(\'/helper-lists/educational-institutions/'+ data.id +'/edit\' , \'educational-institutions-modal\')" ' +
        '>' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="removeData($(this) , \'/helper-lists/educational-institutions/'+ data.id +'  \' )" ' +
        '>' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}