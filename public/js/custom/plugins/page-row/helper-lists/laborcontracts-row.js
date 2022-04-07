function labor_pagination(data,num){
    console.log(data);

    if( data.civilService == true){
        data.civilService1 = '';
        data.civilService2 = 'hidden';
    }else if(data.civilService == false){
        data.civilService1 = 'hidden';
        data.civilService2 = '';
    }else{
        data.civilService1 = '';
    }

    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.name +'</td>' +
        '<td>'+ '<i class="icon md-check"'+ data.civilService1 + '></i><i class="icon md-close" '+ data.civilService2 + '></i>' +'</td>' +
        '<td class="text-right">'+
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="editData(\'/helper-lists/labor-contracts/'+ data.id +'/edit\' , \'labor-contracts-modal\')" ' +
        '>' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="removeData($(this) , \'/helper-lists/labor-contracts/'+ data.id +'  \' )" ' +
        '>' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}
