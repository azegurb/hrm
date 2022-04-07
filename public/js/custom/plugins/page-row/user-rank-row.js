function military_pagination(data,num){
    console.log(data);
     var ranktype;
    // if(typeof data.listSpecialRankId.listSpecialRankTypeId.name !== undefined){
    //     ranktype = data.listSpecialRankId.listSpecialRankTypeId.name;
    // }else if(typeof )

        if(typeof data.listSpecialRankId.listSpecialRankTypeId.name != 'undefined'){
            ranktype = data.listSpecialRankId.listSpecialRankTypeId.name;
            console.log(typeof data.listSpecialRankId.listSpecialRankTypeId.name);

        }else if(typeof data.listSpecialRankId.listSpecialRankTypeId != 'undefined'){
            console.log('namesiz');
            ranktype = data.listSpecialRankId.listSpecialRankTypeId;

        }else {
            console.log('asdafaf');
        }




    if(data.docInfo == null){
        data.docInfo = '';
    }
    if(data.docDate == null){
        data.docDate = '';
    }
    var tr;
     tr     =   '<td>'+ num +'</td>' +
                '<td>'+ data.startDate +'</td>' +
                '<td>'+ ranktype +'</td>' +
                '<td>'+ data.listSpecialRankId.name +'</td>' +
                '<td>'+ data.docInfo +'</td>' +
                '<td>'+ data.docDate +'</td>' +
                 '<td class="text-nowrap text-right">' +
                 '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal(\'/personal-cards/user-rank/'+ data.id +'/edit\' , \'military\')">' +
                 '<i class="icon md-edit" aria-hidden="true"></i>' +
                 '<span class="tptext tpedit">Düzəliş et</span>' +
                 '</div>' +
                 '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/personal-cards/user-rank/'+ data.id +'  \' )" data-original-title="Sil">' +
                 '<i class="icon md-delete" aria-hidden="true"></i>' +
                 '<span class="tptext tpdel">Sil</span>' +
                 '</div>' +
                 '</td>';
        return tr;
}