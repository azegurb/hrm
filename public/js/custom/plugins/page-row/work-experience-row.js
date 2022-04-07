/**
 * Created by Asan on 5/13/2017.
 */
function work_experience_paginate(value,num){
    var tr;
    var startDate = '';
    var endDate = '';
    if(value.startDate != '' || value.startDate != null){
        startDate = value.startDate;
    }
    if(value.endDate != '' || value.endDate != null){
        endDate = value.endDate;
    }
    if(value.differentOrg){
        diffOrg = 'Fərqli Struktur';
    }else{
        diffOrg = 'Cari Struktur';
    }

    tr = '<td>'+num+'</td>'+
        '<td>'+value.positionName+'</td>'+
        '<td>'+value.organizationName+'</td>'+
        '<td>'+value.orderTypeName+'</td>'+
        '<td>'+value.orderNum+'</td>'+
        '<td>'+value.orderDate+'</td>'+
        '<td>'+value.contractTypeName+'</td>'+
        '<td>'+startDate+'</td>'+
        '<td>'+endDate+'</td>'+
        '<td>'+diffOrg+'</td>'+
        '<td class="text-nowrap text-right">'+
        '<div class="btn btn-sm btn-icon btn-flat btn-default waves-effect" ' +
        'onclick="editData(\'/personal-cards/work-experience/'+ value.id +'/edit\' , \'work-experience-modal\')" title="Düzəliş et">'+
            '<i class="icon md-edit" aria-hidden="true"></i>'+
        '</div>'+
        '<div class="btn btn-sm btn-icon btn-flat btn-default waves-effect"  onclick="removeData($(this) , \'/personal-cards/work-experience/'+ value.id +')" title="Sil">'+
        '<i class="icon md-delete" aria-hidden="true"></i>'+
        '</div>'+
        '</td>';

    return tr;
}
