/**
 * Create New Nc Row
 * @param data
 * @param rows
 * @param count
 * @returns {string}
 */
function generateNC(data,rows,count) {
    let html = '';
    let td = '';
    if(rows.length > 0){
        rows.forEach(function(row){
            td += iterate(data,row);
        })
    }
    html += `<tr style="background-color: rgba(255,176,0,0.32)">
                <td>${count}</td>
                ${td}
                <td></td>
            </tr>`
    return html;
}

/**
 * Create Td
 * @param data
 * @param rows
 * @returns {string}
 */
function iterate(data,rows){
    let prop = '';
    if(rows.includes('.')){
        prop = '';
        let rowArr = rows.split(".");
        let count = rowArr.length;
        prop = data;
        for(let i = 0; i < count; i++){
            let next = rowArr[i];
            prop = prop[next];
        }
    }else{
        prop = data[rows];
    }
    return '<td>'+prop+'</td>';
}