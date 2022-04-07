function position_provisions_pagination(data,num){

    var tr;
    var provisions = '';

    data.forEach(function(item, index){
        provisions += '<span class="badge badge-default">' + item.provisionName + '</span><br>';
    });

    tr = '<td>'+ num +'</td>' +
            '<td>'+ data[0].structureName +'</td>' +
            '<td>'+ data[0].positionName +'</td>' +
            '<td>'+ provisions +'</td>' +
            '<td class="text-right">'+
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
                ' onclick="editData(\'/helper-lists/position-provisions/'+ data[0].positionId +'/edit\' , \'position-provisions-modal\')" ' +
                '>' +
                    '<i class="icon md-edit" aria-hidden="true"></i>' +
                    '<span class="tptext tpedit">Düzəliş et</span>' +
                '</div>' +
                '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"' +
                ' onclick="removeData($(this) , \'/helper-lists/position-provisions/'+ data[0].positionId +'  \' )" ' +
                '>' +
                    '<i class="icon md-delete" aria-hidden="true"></i>' +
                    '<span class="tptext tpdel">Sil</span>' +
                '</div>' +
           '</td>';

    return tr;
}
