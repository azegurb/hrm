
function list_shift_pagination(item, index) {


    for (var member in item) {

        if (item[member] == null)
            item[member] = '';

    }

    var periodic = '';

    if (item.periodic == true) {
        periodic = '<span class="badge badge-success">Mütəmadi</span>';
    } else {
        periodic = '<span class="badge badge-default">Qeyri-mütəmadi</span>';
    }

    /* return single instance of table row */

    return  '<td>' + index + '</td>' +
            '<td>' + item.name + '</td>' +
            '<td>' + periodic + '</td>' +
            '<td>' + item.workDay + '</td>' +
            '<td>' + item.restDay + '</td>' +
            '<td class="text-right">' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/helper-lists/list-shift/' + item.id + '  \' )">' +
                    '<i class="icon md-delete" aria-hidden="true"></i>' +
                    '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
            '</td>';

}