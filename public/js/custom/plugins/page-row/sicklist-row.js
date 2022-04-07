/**
 * Created by Asan on 5/11/2017.
 */
function sicklist_pagination(data,num){
    var tr;
    let localRows = ['organizationName','sickStartDate','sickEndDate','sickNote']
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.organizationName +'</td>' +
        '<td>'+ data.sickStartDate +'</td>' +
        '<td>'+ data.sickEndDate +'</td>' +
        '<td>'+ data.sickNote +'</td>' +
        '<td class="text-nowrap text-right">' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/sicklist/'+ data.id +'/edit\' , \'sicklist-modal\')">' +
        '<i class="icon md-edit" aria-hidden="true"> </i>' +
        '<span class="tptext tpedit">Düzəliş et</span>' +
        '</div>' +
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/personal-cards/sicklist/'+ data.id +'  \' )">' +
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
