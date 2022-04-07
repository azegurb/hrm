function rowGen(method,value, rowNumber, from, tbody,searchMethod){
    console.log(value);
    var tr = '';
    if(from == 'add'){
        if(typeof value.listVacationTypeIdName == 'undefined'){
            value.listVacationTypeIdName = value.listVacationTypeId.name;
        }
        if(typeof value.orderCommonIdOrderNum == 'undefined'){
            value.orderCommonIdOrderNum = value.orderCommonId.orderNum;
        }
        if(typeof value.orderCommonIdOrderDate == 'undefined'){
            value.orderCommonIdOrderDate = value.orderCommonId.orderDate
        }

         var datee = moment(value.orderCommonIdOrderDate).format('YYYY-MM-DD');
       console.log(datee);

        //
        // var o_date = new Date(value.orderCommonIdOrderDate);
        //
        // o_date.toDateString();
        // console.log(o_date);
        tr =
            '<tr id="'+value.id+'" onclick="toggletree(\''+value.id+'\')" data-expanded="false">'+
            '<td></td>'+
            '<td>'+value.listVacationTypeIdName+'</td>'+
            '<td>'+ value.orderCommonIdOrderNum +'</td>'+
            '<td>'+ datee +'</td>'+
            '<td class="text-nowrap text-right">' +
            '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/vocation/'+ value.id +'/edit\' , \'vocation-modal\',\'expandable\')">' +
            '<i class="icon md-edit" aria-hidden="true"></i>' +
            '<span class="tptext tpedit">Düzəliş et</span>' +
            '</div>' +
            '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/vocation/'+ value.id +'  \' )" data-original-title="Sil">' +
            '<i class="icon md-delete" aria-hidden="true"></i>' +
            '<span class="tptext tpdel">Sil</span>' +
            '</div>' +
            '</td>'+
            '</tr>'+
            '<tr class="footable-detail-row ml-20" style="display: none" id="'+ value.id+'_hidden">'+
            '<td colspan="4">'+
            '<div class="row table tree-div">'+
            '<div class="col-md-12 head-div mt-10 mb-10 ml-20">'+
            '<div class="col-md-3 float-left">&mdash; İş ili</div>'+
            '<div class="col-md-3 float-left">Başlama tarixi</div>'+
            '<div class="col-md-3 float-left">Bitmə tarixi</div>'+
            '<div class="col-md-3 float-left">Müddət</div>'+
            '</div>'+
            '<div id="tree-body" style="width: 100%;">'+
            '</div>'+
            '</div>'+
            '</td>'+
            '</tr>';

        tbody.append(tr);
    }else if(from == 'edit'){
        if(typeof value.listVacationTypeIdName == 'undefined'){
            value.listVacationTypeIdName = value.listVacationTypeId.name;
        }
        if(typeof value.orderCommonIdOrderNum == 'undefined'){
            value.orderCommonIdOrderNum = value.orderCommonId.orderNum;
        }
        if(typeof value.orderCommonIdOrderDate == 'undefined'){
            value.orderCommonIdOrderDate = value.orderCommonId.orderDate
        }
        var datee = moment(value.dateCreated).format('YYYY-MM-DD');
        console.log(value.dateCreated);
        tr =
            '<td></td>'+
            '<td>'+value.listVacationTypeIdName+'</td>'+
            '<td>'+ value.orderCommonIdOrderNum +'</td>'+
            '<td>'+ datee +'</td>'+
            '<td class="text-nowrap text-right">' +
            '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData(\'/personal-cards/vocation/'+ value.id +'/edit\' , \'vocation-modal\',\'expandable\')">' +
            '<i class="icon md-edit" aria-hidden="true"></i>' +
            '<span class="tptext tpedit">Düzəliş et</span>' +
            '</div>' +
            '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="removeData($(this) , \'/personal-cards/vocation/'+ value.id +'  \' )" data-original-title="Sil">' +
            '<i class="icon md-delete" aria-hidden="true"></i>' +
            '<span class="tptext tpdel">Sil</span>' +
            '</div>' +
            '</td>';
        tbody.html(tr);
    }
    if(searchMethod == 'search'){
        value.data.forEach(function(item){
            if(typeof item.listVacationTypeIdName == 'undefined'){
                item.listVacationTypeIdName = item.listVacationTypeId.name;
            }
            if(typeof item.orderCommonIdOrderNum == 'undefined'){
                item.orderCommonIdOrderNum = item.orderCommonId.orderNum;
            }
            if(typeof item.orderCommonIdOrderDate == 'undefined'){
                item.orderCommonIdOrderDate = item.orderCommonId.orderDate
            }


            tr += '<tr id="'+item.id+'" onclick="toggletree(\''+item.id+'\')" data-expanded="false">'+
                '<td>'+item.listVacationTypeIdName+'</td>'+
                '<td>'+ item.orderCommonIdOrderNum +'</td>'+
                '<td>'+ item.orderCommonIdOrderDate +'</td>'+
                '<td class="text-right">'+
                '<button  type="button"'+
                'class="btn  btn-pro btn-animate btn-animate-side btn-primary waves-effect"'+
                'onclick="editData(\'/personal-cards/vocation/'+ item.id +'/edit\' , \'vocation-modal\',\'expandable\')">'+
                '<span><i class="icon md-edit" aria-hidden="true"></i>Dəyiş</span>'+
                '</button> '+
                ' <button type="button"'+
                'class="btn  btn-pro btn-animate btn-animate-side btn-primary waves-effect"'+
                'onclick="removeData($(this) , \'/personal-cards/vocation/'+ item.id +'  \' )">'+
                '<span><i class="icon md-delete" aria-hidden="true"></i>Sil</span>'+
                '</button>'+
                '</td>'+
                '</tr>'+
                '<tr class="footable-detail-row ml-20" style="display: none" id="'+ item.id+'_hidden">'+
                '<td colspan="4">'+
                '<div class="row table tree-div">'+
                '<div class="col-md-12 head-div mt-10 mb-10 ml-20">'+
                '<div class="col-md-3 float-left">&mdash; İş ili</div>'+
                '<div class="col-md-3 float-left">Başlama tarixi</div>'+
                '<div class="col-md-3 float-left">Bitmə tarixi</div>'+
                '<div class="col-md-3 float-left">Müddət</div>'+
                '</div>'+
                '<div id="tree-body" style="width: 100%;">'+
                '</div>'+
                '</div>'+
                '</td>'+
                '</tr>';
        });

        tbody.html(tr);
    }
}