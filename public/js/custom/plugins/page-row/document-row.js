function document_pagination(data,num){
    var tr;
    let localRows = ['listDocumentTypeId.name','issueDate']
    console.log(data)
    var file = '';
    if(data.file) {
        file = '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"'+
        'onclick="fileDownload(\''+data.id+'\' , \'document\')">'+
        '<i class="icon md-file" aria-hidden="true"></i>'+
        '<span class="tptext tpedit">Fayl</span>'+
        '</div>';
    }
    tr = '<td>'+ num +'</td>' +
        '<td>'+ data.listDocumentTypeId.name +'</td>' +
        '<td>'+ data.issueDate +'</td>' +
        '<td class="text-right">'+file+'<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData(\'/personal-cards/document/'+ data.id +'/edit\'  , \'document\')">'+
        '<i class="icon md-edit" aria-hidden="true"></i>'+
        '<span class="tptext tpedit">Düzəliş et</span>'+
        '</div>'+
        '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick="removeData($(this) , \'/personal-cards/document/'+ data.id+'\')">'+
        '<i class="icon md-delete" aria-hidden="true"></i>'+
        '<span class="tptext tpdel">Sil</span>'+
        '</div>'+
        '</td>';
    let response = {
        html: tr,
        rows: localRows,
        nc: data.nc !== null ? true : false
    }
    return response;

}