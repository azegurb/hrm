function honor_rewards_pagination(data,num){
    var tr;
    let localRows = ['listRewardHonorNameIdName','cardNumber','orderNum','issueDate']
    if (typeof data.listRewardHonorNameIdName == 'undefined'){
        data.listRewardHonorNameIdName = data.listRewardHonorNameId.name;
    }
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listRewardHonorNameIdName +'</td>' +
        '<td>'+ data.cardNumber +'</td>' +
        '<td>'+ data.orderNum +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/reward-honor/'+ data.id +'/edit\' , \'honor-reward\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/reward-honor/'+ data.id +'  \' )" data-original-title="Sil">' +
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