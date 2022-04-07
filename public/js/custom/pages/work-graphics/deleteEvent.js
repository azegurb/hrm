function deleteEvent(elem){
    swal({
        title: 'Silinmə əməliyyatı',
        text:   'Təsdiqləyəcəyiniz təqdirdə məlumat silinəcəkdir',
        type:   'warning',
        showConfirmButton:true,
        showCancelButton:true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Təsdiq",
        cancelButtonText: "İmtina",
    },function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: elem.closest('form').prop('action'),
            type: 'DELETE'
        });
        $.ajax({
            success: function(data){
                console.log(typeof data);
                if(typeof data == 'string' && data != ''){
                    $('#calendar-modal').modal('hide');
                    $('#calendar').fullCalendar( 'removeEvents', data);
                }
            }
        });
    });
}