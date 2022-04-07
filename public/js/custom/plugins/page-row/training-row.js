function training_pagination(data,num){
    var tr;
    let localRows = ['listTrainingNameIdName','listTrainingFormIdName','trainingStartDate','trainingEndDate']

    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listTrainingNameIdName +'</td>' +
        '<td>'+ data.listTrainingFormIdName +'</td>' +
        '<td>'+ data.trainingStartDate +'</td>' +
        '<td>'+ data.trainingEndDate +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/training/'+ data.id +'/edit\' , \'training-modal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/training/'+ data.id +'  \' )" data-original-title="Sil">' +
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

