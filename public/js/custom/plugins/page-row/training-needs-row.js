function training_needs_paginate(data,num){
    var tr;

    var status = 'Ödənilməyib';

    if (data.isclosed==true) {
        status = 'Ödənilib';
    }

    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listTrainingNameId.name +'</td>' +
        '<td>'+ data.note +'</td>' +
        '<td class="text-center">'+ status +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/training-needs/'+ data.id +'/edit\' , \'trainingModal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/personal-cards/training-needs/'+ data.id +'  \' )" data-original-title="Sil">' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;

}