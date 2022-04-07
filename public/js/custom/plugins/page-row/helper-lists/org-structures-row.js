function org_structures_pagination(data,num){


    if( typeof data.organizationId != 'undefined' && typeof data.structuresNameId != 'undefined'){

        console.log('noqteli')
        var orgName =  data.organizationId.name;
        var strName =  data.structuresNameId.name;


    }else {

        var orgName = data.organizationIdName;
        var strName = data.structuresNameIdName;
    }


    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ orgName +'</td>' +
        '<td>'+ strName +'</td>' +
        '<td class="text-right">'+
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="editData(\'/helper-lists/organizationstructures/'+ data.id +'/edit\' , \'org-structures-modal\')" ' +
        '>' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
        ' onclick="removeData($(this) , \'/helper-lists/organizationstructures/'+ data.id +'  \' )" ' +
        '>' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}