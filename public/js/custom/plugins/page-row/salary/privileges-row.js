function privileges_pagination(data,num){

    // if(typeof data !== undefined){
    //
    //         if(typeof data.userId.firstName !== undefined){
    //             console.log('data.userId tapdi');
    //         }
    //
    //     else {
    //         console.log('tapmadi');
    //     }
    //
    // }else{
    //     console.log('undefined deyill');
    // }
console.log(data);
    for (var member in data) {

        if (data[member] == null) {
            data[member] = '';
        }
    }

    let firstName = typeof data.userId      != 'undefined' ? data.userId.firstName  : data.userIdFirstName;
    let lastName  = typeof data.userId      != 'undefined' ? data.userId.lastName   : data.userIdLastName;
    let privilege = typeof data.privilegeId != 'undefined' ? data.privilegeId.value : data.privilegeIdValue;


    var tr;
    tr = '<td>'+ num +'</td>' +
        '<td>'+ firstName + ' ' + lastName + '</td>' +
        '<td>'+ privilege +' AZN</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal(\'/salary/privileges/'+ data.id +'/edit\' , \'privileges-modal\')">' +
        '<i class="icon md-edit" aria-hidden="true"></i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/salary/privileges/'+ data.id +'  \' )" data-original-title="Sil">' +
        '<i class="icon md-delete" aria-hidden="true"></i>' +
        '<span class="tptext tpdel">Sil</span>' +
        '</div>' +
        '</td>';
    return tr;
}