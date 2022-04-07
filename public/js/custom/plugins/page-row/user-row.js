/**
 * Created by Asan on 5/23/2017.
 */
function users_paginate(data,num){
    var tr;
    var photo = '/media/noavatar.png';
    var str = '';
    var pos = '';
    if(data.photo != null){
        photo = 'data:image/png;base64,'+data.photo;
    }
    if(data.structureName != null){
        str = data.structureName;
    }
    if(data.positionName != null){
        pos = data.positionName;
    }

    tr = '<td onclick="getUser(\''+data.id+'\')" data-toggle="tab" href="#panelTab2"'+
        'aria-controls="panelTab2" role="tab">'+ num +'</td>' +
        '<td onclick="getUser(\''+data.id+'\')" data-toggle="tab" href="#panelTab2"'+
        'aria-controls="panelTab2" role="tab">'+
        '<span class="avatar">'+
        '<img class="img-rounded img-bordered img-bordered-primary personal-img"'+
        'src="'+photo+'" alt="">'+
        '</span>'+
        '</td>'+
        '<td onclick="getUser(\''+data.id+'\')" data-toggle="tab" href="#panelTab2"'+
        'aria-controls="panelTab2" role="tab">'+ data.lastName +'</td>' +
        '<td onclick="getUser(\''+data.id+'\')" data-toggle="tab" href="#panelTab2"'+
        'aria-controls="panelTab2" role="tab">'+ data.firstName +'</td>' +
        '<td onclick="getUser(\''+data.id+'\')" data-toggle="tab" href="#panelTab2"'+
        'aria-controls="panelTab2" role="tab">'+ data.patronymic +'</td>' +
        '<td onclick="getUser(\''+data.id+'\')" data-toggle="tab" href="#panelTab2"'+
        'aria-controls="panelTab2" role="tab">'+ str+' '+pos +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal(\'/get-user-by-id/'+ data.id +'/responseHttp\' , \'usersModal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/users/destroy/'+ data.id +'  \' )" data-original-title="Sil">' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}