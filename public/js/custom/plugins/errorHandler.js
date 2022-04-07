function eHandler(exception){
    var errorText = '';
    keys = Object.keys(exception);
    for (var index in keys) {
        exception[keys[index]].forEach(function(item){
            errorText += '<li style="list-style-type:none">'+item+'</li>';
        })
    }
    swal({
        title: 'Məlumatda çatışmazlıq mövcuddur',
        text:   errorText,
        type:   'warning',
        html:   true,
        showConfirmButton:true,
        confirmButtonText: 'Geri'
    });
}