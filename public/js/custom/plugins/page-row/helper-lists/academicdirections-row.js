function academic_directions_pagination(data,num){
    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.name +'</td>' +
        '<td class="text-right">'+
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="editData(\'/helper-lists/academic-directions/'+ data.id +'/edit\' , \'academic-directions-modal\')" ' +
        '>' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="removeData($(this) , \'/helper-lists/academic-directions/'+ data.id +'  \' )" ' +
        '>' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}