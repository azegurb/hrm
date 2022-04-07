function nonworking_days_pagination(data,num){
        console.log(data);
    var tr;
    //
    // var sDay, sMonth, sYear;
    // var eDay, eMonth, eYear;
    //
    // var startDate = new Date(data.startDate);
    // var endDate   = new Date(data.endDate);
    //
    // sDay   = startDate.getDate() < 10 ? '0' + startDate.getDate() : startDate.getDate();
    // sMonth = (startDate.getMonth() + 1) < 10 ? '0' + (startDate.getMonth() + 1) :  startDate.getMonth() + 1;
    // sYear  = startDate.getFullYear();
    //
    // eDay   = endDate.getDate() < 10 ? '0' + endDate.getDate() : endDate.getDate();
    // eMonth = (endDate.getMonth() + 1) < 10 ? '0' + (endDate.getMonth() + 1) : endDate.getMonth() + 1;
    // eYear  = endDate.getFullYear();

    tr =    '<td>'+num+'</td>' +
            '<td>'+data.name+'</td>' +
            '<td>'+ data.startDate +'</td>' +
            '<td>'+ data.endDate +'</td>' +
            '<td class="text-nowrap">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" ' +
                            ' onclick="editData(\'/helper-lists/non-work-days/'+data.id+'/edit\', \'non-work-days-modal\')">' +
                    '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" ' +
                            ' data-original-title="Sil" onclick="removeData($(this), \'/helper-lists/non-work-days/'+data.id+'\')">' +
                    '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
            '</td>';

    return tr;
}