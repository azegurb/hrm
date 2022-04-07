setTimeout(function(){
    $('[user-search-input]').on('focusin',function(){
        $(this).closest('.material-shadow-input').addClass('active');
    });
    $('[user-search-input]').on('focusout',function(){
        $(this).closest('.material-shadow-input').removeClass('active');
    });
    $('[expander-button]').on('click' , function(){

    });

    $('[expander-button]').on('click',function(){
        if($(this).find('i').hasClass('md-chevron-up')){
            $(this).find('i').removeClass('md-chevron-up').addClass('md-chevron-down')
            $('#complete-search-area').slideUp('fast');
        }else{
            $(this).find('i').removeClass('md-chevron-down').addClass('md-chevron-up')
            $('#complete-search-area').slideDown('fast');
        }
    });
    var htmlData;
    var value;
    var trigger = true;
},1000)
function userS(elem,e){
    console.log(elem.context.value);
    if(e.keyCode == 13){
        var valueData = elem;
        var value = valueData.val();
        if(value != ''){
            $('#search-results-area').slideDown();
            var request = new XMLHttpRequest();
            request.open('GET', usersUrl+'&q='+value,false);
            request.onreadystatechange = function () {
                if (request.readyState == 4){
                    var htmlData = '';
                    if(request.response != '' || typeof request.response != 'undefined' || request.response.length > 0){
                        var responseData = JSON.parse(request.response);
                        if(responseData.length > 0 ) {
                            responseData.forEach(function (data) {
                                htmlData += '<li class="list-group-item select-user" onclick="getUserCV(`'+ data.id +'`)">' + data.text + '</li>';
                            });
                        }else{
                            htmlData = '<li class="list-group-item"><div class="alert alert-warning list-groupt-item text-center"> <strong>Nəticə tapılmadı </strong> </div></li>';
                        }
                    }else{
                        htmlData = '<li class="list-group-item"><div class="alert alert-warning list-groupt-item text-center"> <strong>Nəticə tapılmadı </strong> </div></li>';
                    }
                    $('[search-content]').html(htmlData);
                }
            };
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send();
        }else{
            $('#search-results-area').slideUp();
            $('[search-content]').html('');
        }

    }

}
setTimeout(function(){
    $('.input-daterange').datepicker({
        format: 'dd.mm.yyyy',
//            clearBtn: true,
        todayHighlight: true,
        weekStart: 1,
        autoclose: true,
        language:'az'
    });

    var request = new XMLHttpRequest();
    request.open('GET', familyStatus, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = JSON.parse(request.response);
            var options = '<option value="" disabled selected>Ailə vəziyyəti</option>';
            for(var i = 0;i < response.length;i++){
                options += '<option value="' + response[i].id + '">' + response[i].text + '</option>'
            }
            $('[name="marital"]').html(options);
        }
    };
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send();


},2200)

function clearFilters(){
    $('#user-search-input').val('');
    $('#search-results-area').slideUp();
    $('[search-content]').html('');
    $('[name="name"]').val('');
    $('[name="last"]').val('');
    $('[name="patronymic"]').val('');
    $('[name="gender"]').val('');
    $('[name="marital"]').val('');
    $('[name="startDate"]').val('');
    $('[name="endDate"]').val('');
}

function filterByUser(){
    var url = filterByUserUrl;
    $('#search-results-area').slideDown();
//        $('[search-content]').html('');
    var name = $('[name="name"]').val();
    var last = $('[name="last"]').val();
    var patronymic = $('[name="patronymic"]').val();
    var gender = $('[name="gender"]').val();
    var marital = $('[name="marital"]').val();
    var startDate = $('[name="startDate"]').val();
    var endDate = $('[name="endDate"]').val();
    url = url+'?name='+name+'&last='+last+'&patronymic='+patronymic+'&gender='+gender+'&marital='+marital+'&startDate='+startDate+'&endDate='+endDate;

    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var htmlData = '';
            if (request.response != '' || typeof request.response != 'undefined' || request.response.length > 0) {
                var responseData = JSON.parse(request.response);
                if (responseData.length > 0) {
                    responseData.forEach(function (data) {
                        htmlData += '<li class="list-group-item select-user" onclick="getUserCV(`'+ data.id +'`)">' + data.text + '</li>';
                    });
                } else {
                    htmlData = '<li class="list-group-item"><div class="alert alert-warning list-groupt-item text-center"> <strong>Nəticə tapılmadı </strong> </div></li>';
                }
            } else {
                htmlData = '<li class="list-group-item"><div class="alert alert-warning list-groupt-item text-center"> <strong>Nəticə tapılmadı </strong> </div></li>';
            }
        $('[search-content]').html(htmlData);

        }

    };
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send();
}

function getStructureData(elem,id,structure){
    if(!elem.attr('dirty')){
        var url = structureU+'/'+id+'/'+structure;
        var request = new XMLHttpRequest();
        var users = true;
        var childs = true;
        request.open('GET', url, true);
        request.onreadystatechange = function () {
            var htmlData = '';
            var usersHtmlData = '';
            var childsHtmlData = '';
            var usersHtml = '';
            if (request.readyState == 4) {
                if (request.response != '' && typeof request.response != 'undefined' && request.response.length > 0) {
                    var responseData = JSON.parse(request.response);
                    console.log(responseData);
                    if(structure == 'vxsida') {
                        if (responseData.users.length > 0) {
                            responseData.users.forEach(function (data) {
                                usersHtmlData += `
                            <li class="list-group-item justify-content-between material-shadow" data-id="${data.id}" onclick="getUserCV('${data.id}')">
                                <span>
                                    <i class="icon md-account" aria-hidden="true" draggable="true"></i>
                                    ${data.text}
                                </span>
                                    <!-- <span class="badge badge-pill badge-success">6</span> -->
                            </li>
                        `;
                            });
                        }
                        else {
                            usersHtmlData = '';
                            users = false;
                        }

                        if (responseData.childs.length > 0) {
                            responseData.childs.forEach(function (data) {
                                childsHtmlData += `
                            <div class="material-shadow">
                                <div class="card-header bg-light-blue-200 white p-5 clearfix" onclick="getSubStructureData($(this),'${data.id}','${data.rsId}')" dirty="" expanded="">
                                    <div class="font-size-18 ">${data.text}</div>
                                </div>
                                <ul class="list-group list-group-bordered mb-0 list-of-this" style="display: none">

                                </ul>
                            </div>
                        `;
                            });
                        } else {
                            childsHtmlData = '';
                            childs = false;
                        }

                    }
                    else{
                        if (responseData.users.length > 0) {
                            responseData.users.forEach(function (data) {
                                if(data.users.length > 0){
                                    usersHtml = '';
                                    data.users.forEach(function(user){
                                        usersHtml += `
                                        <li class="list-group-item justify-content-between material-shadow" data-id="${user.id}" onclick="getUserCV('${user.id}')">
                                            <span>
                                                <i class="icon md-account" aria-hidden="true" draggable="true"></i>
                                                ${user.full}
                                            </span>
                                        </li>
                                        `;
                                    })
                                    usersHtml = `<ul>${usersHtml}</ul>`
                                }

                                usersHtmlData += `
                                <li class="list-group-item justify-content-between ">
                                    <span>
                                        ${data.name}
                                    </span>
                                </li>
                                ${usersHtml}
                        `;
                            });
                        }
                        else {
                            usersHtmlData = '';
                            users = false;
                        }

                        if (responseData.childs.length > 0) {
                            responseData.childs.forEach(function (data) {
                                childsHtmlData += `
                            <div class="material-shadow">
                                <div class="card-header bg-light-blue-200 white p-5 clearfix" onclick="getStructureData($(this),'${data.id}','${data.type}')" dirty="" expanded="">
                                    <div class="font-size-18 ">${data.text}</div>
                                </div>
                                <ul class="list-group list-group-bordered mb-0 list-of-this" style="display: none">

                                </ul>
                            </div>
                        `;
                            });
                        } else {
                            childsHtmlData = '';
                            childs = false;
                        }

                    }


                    if (childs || users) {
                        htmlData = usersHtmlData+' '+childsHtmlData
                    } else {
                        htmlData = `
                        <li class="list-group-item justify-content-between">
                            <span>
                                <div class="alert alert-warning text-center"><strong>Məlumat yoxdur!</strong></div>
                            </span>
                        </li>
                        `
                    }
                } else {
                    htmlData = `
                        <li class="list-group-item justify-content-between">
                            <span>
                                <div class="alert alert-warning text-center"><strong>Məlumat yoxdur!</string></div>
                            </span>
                        </li>
                        `
                }
                elem.attr('dirty', true).attr('expanded', true);
                elem.next().html(htmlData);
                function sld() {
                    if (elem.next().html() != '') {
                        elem.next().slideDown('fast');
                    } else {
                        setTimeout(function () {
                            if (elem.next().html() != '') {
                                elem.next().slideDown('fast');
                            } else {
                                sld();
                            }
                        }, 400);
                    }
                }

                sld();
            }
        };
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send();
    }else{
        if(elem.attr('expanded') == 'true'){
            elem.attr('expanded', false);
            elem.next().slideUp('fast');
        }else if(elem.attr('expanded') == 'false'){
            elem.attr('expanded', true);
            elem.next().slideDown('fast');
        }
    }
}

function getSubStructureData(elem,id,strId){
    if(!elem.attr('dirty')){
        var url = '/chairman/substructure/'+id+'?strId='+strId;
        var request = new XMLHttpRequest();
        var users = true;
        var childs = true;
        var structure = 'vxsida'
        request.open('GET', url, true);
        request.onreadystatechange = function () {
            var htmlData = '';
            var usersHtmlData = '';
            var childsHtmlData = '';
            var usersHtml = '';
            if (request.readyState == 4) {
                if (request.response != '' && typeof request.response != 'undefined' && request.response.length > 0) {
                    var responseData = JSON.parse(request.response);
                    if(structure == 'vxsida') {
                        if (responseData.users.length > 0) {
                            responseData.users.forEach(function (data) {
                                usersHtmlData += `
                            <li class="list-group-item justify-content-between material-shadow" data-id="${data.id}" onclick="getUserCV('${data.id}')">
                                <span>
                                    <i class="icon md-account" aria-hidden="true" draggable="true"></i>
                                    ${data.text}
                                </span>
                                    <!-- <span class="badge badge-pill badge-success">6</span> -->
                            </li>
                        `;
                            });
                        }
                        else {
                            usersHtmlData = '';
                            users = false;
                        }
                        if (responseData.childs.length > 0) {
                            responseData.childs.forEach(function (data) {
                                var color = '';
                                if(data.label == 'vxsida'){
                                    color = 'bg-light-blue-50'
                                }else if(data.label == 'so'){
                                    color = 'bg-teal-a100'
                                }else if(data.label == 'fh'){
                                    color = 'bg-indigo-a100'
                                }
                                childsHtmlData += `
                            <div class="material-shadow">
                                <div class="card-header ${color} white p-5 clearfix" onclick="getSubStructureData($(this),'${data.id}','${data.rsId}')" dirty="" expanded="">
                                    <div class="font-size-18 " style="color: black">${data.text}</div>
                                </div>
                                <ul class="list-group list-group-bordered mb-0 list-of-this" style="display: none">

                                </ul>
                            </div>
                        `;
                            });
                        } else {
                            childsHtmlData = '';
                            childs = false;
                        }

                    }

                    if (childs || users) {
                        htmlData = usersHtmlData+' '+childsHtmlData+'<hr>'
                    } else {
                        htmlData = `
                        <li class="list-group-item justify-content-between">
                            <span>
                                <div class="alert alert-warning "><strong>Məlumat yoxdur!</strong></div>
                            </span>
                        </li>
                        `
                    }
                } else {
                    htmlData = `
                        <li class="list-group-item justify-content-between">
                            <span>
                                <div class="alert alert-warning"><strong>Məlumat yoxdur!</string></div>
                            </span>
                        </li>
                        `
                }
                elem.attr('dirty', true).attr('expanded', true);
                elem.next().html(htmlData);
                function sld() {
                    if (elem.next().html() != '') {
                        elem.next().slideDown('fast');
                    } else {
                        setTimeout(function () {
                            if (elem.next().html() != '') {
                                elem.next().slideDown('fast');
                            } else {
                                sld();
                            }
                        }, 400);
                    }
                }

                sld();
            }
        };
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send();
    }
    else{
        if(elem.attr('expanded') == 'true'){
            elem.attr('expanded', false);
            elem.next().slideUp('fast');
        }else if(elem.attr('expanded') == 'false'){
            elem.attr('expanded', true);
            elem.next().slideDown('fast');
        }
    }
}

function getUserCV(id){
    console.log(id);
    var url = userCV+'/'+id;
    var request = new XMLHttpRequest();
    var users = true;
    var childs = true;
    request.open('GET', url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            $('#cvModal').find('.modal-body').html(request.response);
            $('#cvModal').modal('show');
        }
    };
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send();
}