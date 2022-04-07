$(document).ready(function(){

    alert('{{ $modalid }}');
    var bul='{{ json_encode($data->permission[0]->accesible) }}';
    if(bul=='false'){

        $('#usersModal_form').find('button[type="submit"]').html('Təsdiqə göndər')
    }

})