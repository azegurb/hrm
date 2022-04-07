function staff_table_paginate(data,num){
    var tr;

    for (var member in data) {
        if (data.hasOwnProperty(member) && data[member] === null) {

            data[member] = '';

        }
    }

    tr =    '<td>'+ num +'</td>' +
            '<td>'+ data.posNameId.name +'</td>' +
            '<td>'+ data.count + '</td>' +
            '<td>'+ data.salary +'</td>' +
            '<td class="text-right">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/staff-table/'+ data.id +'/edit\' , \'staffTableModal\')">' +
                    '<i class="icon md-edit" aria-hidden="true"></i>' +
                    '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                    '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/staff-table/'+ data.id +'  \' )">' +
                         '<i class="icon md-delete" aria-hidden="true"></i>' +
                    '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
            '</td>';

    return tr;
}

