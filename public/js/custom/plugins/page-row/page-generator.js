function row_generator(method, data, num, reload, tbody) {
    var tr = '';
    let responseData;
    let responseHtml;
    let isNC = false;
    if (Array.isArray(data.data)) {
        data.data.forEach(function (item) {
            ++num;
            if (typeof item.periodic != 'undefined') {
                responseData = eval(method)(item, num);
                responseHtml = typeof responseData.html != 'undefined' ? responseData.html : responseData;
                if(item.isarchived && item.isarchived==true && $('#currentA').length>0) {
                    tr += '<tr class="isClosed" ondblclick="document.loadPanel(\'' + item.id + '\',  \'' + item.periodic + '\')" id="' + item.id + '">' + responseHtml + '</tr>';
                    if (typeof responseData.nc != 'undefined' && responseData.nc) {
                        let ncHtml = generateNC(item.nc, responseData.rows, num);
                        tr += ncHtml;
                    }
                }
                else {
                    tr += '<tr ondblclick="document.loadPanel(\'' + item.id + '\',  \'' + item.periodic + '\')" id="' + item.id + '">' + responseHtml + '</tr>';
                    if (typeof responseData.nc != 'undefined' && responseData.nc) {
                        let ncHtml = generateNC(item.nc, responseData.rows, num);
                        tr += ncHtml;
                    }

                }
            }else {
                responseData = eval(method)(item, num);
                responseHtml = typeof responseData.html != 'undefined' ? responseData.html : responseData;
                if(item.isarchived && item.isarchived==true && $('#currentA').length>0) {
                    tr += '<tr class="isClosed" id="' + item.id + '">' + responseHtml + '</tr>';
                    if (typeof responseData.nc != 'undefined' && responseData.nc) {
                        let ncHtml = generateNC(item.nc, responseData.rows, num);
                        tr += ncHtml;
                    }
                }
                else {
                    tr += '<tr id="' + item.id + '">' + responseHtml + '</tr>';
                    if (typeof responseData.nc != 'undefined' && responseData.nc) {
                        let ncHtml = generateNC(item.nc, responseData.rows, num);
                        tr += ncHtml;
                    }

                }
            }
        });
    } else if (data != '' && reload != 'edit') {

        ++num;
        if (typeof data.periodic != 'undefined') {
            responseData = eval(method)(data.body.data, num);
            responseHtml = typeof responseData.html != 'undefined' ? responseData.html : responseData;
            tr += '<tr ondblclick="document.loadPanel(\'' + data.body.data.id + '\',  \'' + data.body.data.periodic + '\')" id="' + data.body.data.id + '">' + responseHtml + '</tr>';
        }else {
            responseData = eval(method)(data.body.data, num);
            responseHtml = typeof responseData.html != 'undefined' ? responseData.html : responseData;
            tr += '<tr id="' + data.body.data.id + '">' + responseHtml + '</tr>';
        }
        if(typeof data.headers != 'undefined' && typeof data.headers[0] != 'undefined' && data.headers['hasConfirm'][0] == 'true'){
            element = $(tr);
            element.find('td').last().html('');
            element.css('background' , '#ffe3a6');
            element.find('td').css('background' , '#ffe3a6');
            tr = element;
        }
    } else if (reload == 'edit') {
        responseData = eval(method)(data.data, num);
        responseHtml = typeof responseData.html != 'undefined' ? responseData.html : responseData;
        tr = responseHtml;
        if(typeof data.headers != 'undefined' && typeof data.headers[0] != 'undefined' && data.headers['hasConfirm'][0] == 'true'){
            tr = '<tr>'+tr+'</tr>'
            element = $(tr);
            console.log(element.find('td').last().html());
            element.find('td').last().html('');
            element.css('background' , '#ffe3a6');
            element.find('td').css('background' , '#ffe3a6');
            tr = element;
            isNC = true;
        }
    }
    // console.log(tbody,tr,reload)
    if (reload == false || reload == 'add') {
        tbody.append(tr);
        if (reload == 'add') {
            $el = tbody.find('tr').last();
            $el.addClass('highlight');
        }
    } else {
        console.log(tr);
        console.log(isNC)
        if(isNC){
            tbody.after(tr);
        }else{
            tbody.html(tr);
        }
        if (reload == 'edit') {
            console.log(reload);
            $el = tbody;
            $el.addClass("highlight");

        }
    }
}