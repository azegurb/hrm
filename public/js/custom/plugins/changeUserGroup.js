$('.user-group-change').on('click' , function(){
    let id = $(this).attr('data-id');
    $.ajax({
        type:'GET',
        url:'/change-user-group/'+id,
        success: function(data){
            window.location.reload();
        }
    })
});