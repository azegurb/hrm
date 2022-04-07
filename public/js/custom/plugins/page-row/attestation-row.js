function attestation_pagination(data,num){
    let localRows = ['listAttestationTypeId.name', 'organName','dateOff','listAttestationResultId.name','notes']
    var tr;

    if(typeof data.listAttestationTypeId == "undefined"){
        data.listAttestationTypeId = {};
        data.listAttestationTypeId.name = data.listAttestationTypeIdName;
    }

    if(typeof data.listAttestationResultId == "undefined"){
        data.listAttestationResultId = {};
        data.listAttestationResultId.name = data.listAttestationResultIdName;
    }

    tr =        '<td>'+ num +'</td>' +
                '<td>'+ data.listAttestationTypeId.name +'</td>' +
                '<td>'+ data.organName +'</td>' +
                '<td>'+ data.dateOff +'</td>' +
                '<td>'+ data.listAttestationResultId.name +'</td>' +
                '<td>'+ data.notes +'</td>' +
                '<td class="text-nowrap text-right">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/attestation/'+ data.id +'/edit\' , \'attestation-modal\')">' +
                '<i class="icon md-edit" aria-hidden="true"></i>' +
                '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/attestation/'+ data.id +'  \' )" data-original-title="Sil">' +
                '<i class="icon md-delete" aria-hidden="true"></i>' +
                '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
                '</td>' +
                '</tr>';
    let response = {
        html: tr,
        rows: localRows,
        nc: data.nc !== null ? true : false
    }
    return response;

}

