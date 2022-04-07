function individual_rewards_pagination(data,num){
    var tr;
    let localRows = ['listRewardIndividualNameIdName','reason','orderNum','issueDate']
    if (typeof data.listRewardIndividualNameIdName == 'undefined'){
        data.listRewardIndividualNameIdName = data.listRewardIndividualNameId.name;
    }

    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listRewardIndividualNameIdName +'</td>' +
        '<td>'+ data.reason +'</td>' +
        '<td>'+ data.orderNum +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/reward-individual/'+ data.id +'/edit\' , \'individual-reward\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/reward-individual/'+ data.id +'  \' )" data-original-title="Sil">' +
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