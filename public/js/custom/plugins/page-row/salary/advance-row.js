function advance_pagination(data, num) {

    for (var member in data) {
        if (data[member] == null) {
            data[member] = '';
        }
    }
    let fullName = typeof data.fullName != 'undefined' ? data.fullName : data.fullName;
    let firstName = typeof data.userId != 'undefined' ? data.userId.firstName : data.userIdFirstName;
    let lastName = typeof data.userId != 'undefined' ? data.userId.lastName : data.userIdLastName;
    let patronymic = data.userId != undefined ? data.userId.patronymic : data.userIdPatronymic;
    let advance = typeof data.value != 'undefined' ? data.value : data.value;

    var name = null;

    if (firstName != null) {
        name = lastName + ' ' + firstName + ' '  +patronymic;
    } else {
        name = fullName;
    }

    var tr;
    tr = '<td>' + num + '</td>' +

        '<td>' + name + '</td>' +

        `<td> ${advance} ${data.isPercent ? '%' : 'AZN'} </td>` +

        `<td><span class="badge badge-${data.isClosed ? 'danger' : 'success'}">${data.isClosed ? 'Deaktiv' : 'Aktiv'}</span></td>` +

        '<td class="text-nowrap text-right">' +

        `<button id="${data.id}" class="btn btn-md btn-icon btn-flat btn-default waves-effect edit-button">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                            </button>` +

        '</td>';
    return tr;
}