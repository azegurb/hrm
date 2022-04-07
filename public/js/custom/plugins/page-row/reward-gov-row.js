function government_rewards_pagination(data,num){
    var tr;
    let localRows = ['listRewardGovNameIdName','cardNumber','orderNum','issueDate']
    if (typeof data.listRewardGovNameIdName == 'undefined'){
        data.listRewardGovNameIdName = data.listRewardGovNameId.name;
    }

    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listRewardGovNameIdName +'</td>' +
        '<td>'+ data.cardNumber +'</td>' +
        '<td>'+ data.orderNum +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/reward-gov/'+ data.id +'/edit\' , \'gov-reward\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/reward-gov/'+ data.id +'  \' )" data-original-title="Sil">' +
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