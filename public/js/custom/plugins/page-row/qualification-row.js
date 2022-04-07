var tr;
function qualification_pagination(data,num){


    var pos_clas_name, list_qual_name;

    if(typeof data.qualificationIdListPositionClassificationId !== 'undefined'){
        pos_clas_name = data.qualificationIdListPositionClassificationId.name;
    }else if(typeof data.qualificationId !== 'undefined' ){
        if(data.qualificationId.listPositionClassificationId.name){
            pos_clas_name = data.qualificationId.listPositionClassificationId.name;
        }else {
            pos_clas_name = data.qualificationId.listPositionClassificationId;
        }
    }else{
        pos_clas_name = ' ';
    }

    if(typeof data.qualificationIdListQualificationTypeId !== 'undefined'){
        list_qual_name = data.qualificationIdListQualificationTypeId.name;
    }else if(typeof data.qualificationId !== 'undefined'){
        if(data.qualificationId.listQualificationTypeId.name){
            list_qual_name = data.qualificationId.listQualificationTypeId.name;
        }else {
            list_qual_name = data.qualificationId.listQualificationTypeId;
        }
    }else{
        list_qual_name = ' ';
    }

         tr =   '<td>'+ num +'</td>' +
                '<td>'+ data.startDate +'</td>' +
                '<td>'+ pos_clas_name +'</td>' +
                '<td>'+ list_qual_name +'</td>' +
                '<td>'+ data.docInfo +'</td>' +
                '<td>'+ data.docDate +'</td>' +
                '<td class="text-nowrap text-right">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/qualification-degree/'+ data.id +'/edit\' , \'qualification-modal\')">' +
                '<i class="icon md-edit" aria-hidden="true"></i>' +
                '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/qualification-degree/'+ data.id +'  \' )" data-original-title="Sil">' +
                '<i class="icon md-delete" aria-hidden="true"></i>' +
                '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
                '</td>';
    return tr;

}

