$('#shiftAdder').on('submit' , function(e){
    e.preventDefault();

    var bool=false;

    // $('.checkerClass').each(function () {
    //
    //     if($(this).attr('checked')=='true'){
    //
    //         bool=true;
    //         break;
    //     }
    // })

    console.log($('input[name="checkers"]').size());

    bool=($('input[name="checkers"]:checked').length > 0)?true:false;

    $('.checkerClass').each(function () {

        if($(this).attr('id')=='3' || $(this).attr('id')=='4'){


            if(bool==false){

                swal({
                    title: 'Əməliyyat yerinə yetirilə bilmədi',
                    text:   'Xahiş olunur iş və ya istirahət günlərindən birini seçəsiniz',
                    type:   'warning',
                    showConfirmButton:true
                },function(){
                    return false
                });
                return false;
            }

        }

    })

    loader_start($('.loader_panel'));
    var formData = $('#shiftAdder').serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/personal-cards/special-work-connect-to-user',
        type: 'POST',
        data: formData,
        success: function (data) {
            if(data == 201) {
                swal({
                    title: '',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 2000
                },function(){
                    swal.close();
                    loader_stop($('.loader_panel'));
                    refresh();
                })
            }else{
                swal({
                    title: '',
                    text: 'İstifadəçi növbəyə bağlanarkən xəta baş verdi.Xahiş olunur yenidən yoxlayın',
                    type: 'warning',
                    showConfirmButton: true
                },function(){
                    swal.close();
                    refresh();
                    loader_stop($('.loader_panel'));
                })
            }
        },
        error: function(){
            swal({
                title: '',
                text: 'İstifadəçi növbəyə bağlanarkən xəta baş verdi.Xahiş olunur yenidən yoxlayın',
                type: 'warning',
                showConfirmButton: true
            },function(){
                swal.close();
                refresh();
                loader_stop($('.loader_panel'));
            })
        }
    });

});
$('#shiftChanger').on('submit' , function(e){
    e.preventDefault();

    var bool=false;

    // $('.checkerClass').each(function () {
    //
    //     if($(this).attr('checked')=='true'){
    //
    //         bool=true;
    //         break;
    //     }
    // })

    console.log($('input[name="checkers"]').size());

    bool=($('input[name="checkers"]:checked').length > 0)?true:false;

    $('.checkerClass').each(function () {

        if($(this).attr('id')=='3' || $(this).attr('id')=='4'){


            if(bool==false){

                swal({
                    title: 'Əməliyyat yerinə yetirilə bilmədi',
                    text:   'Xahiş olunur iş və ya istirahət günlərindən birini seçəsiniz',
                    type:   'warning',
                    showConfirmButton:true
                },function(){
                    return false
                });
                return false;
            }

        }

    })




    loader_start($('.loader_panel'));
    var formData = $('#shiftChanger').serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/personal-cards/special-work-reconnect-to-user',
        type: 'POST',
        data: formData,
        success: function (data) {

            if(data == 200) {
                swal({
                    title: '',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 2000
                },function(){
                    swal.close();
                    loader_stop($('.loader_panel'));
                    refresh();
                })
            }else{
                swal({
                    title: '',
                    text: 'İstifadəçi növbəyə bağlanarkən xəta baş verdi.Xahiş olunur yenidən yoxlayın',
                    type: 'warning',
                    showConfirmButton: true
                },function(){
                    swal.close();
                    refresh();
                    loader_stop($('.loader_panel'));
                })
            }
        },
        error: function(){
            swal({
                title: '',
                text: 'İstifadəçi növbəyə bağlanarkən xəta baş verdi.Xahiş olunur yenidən yoxlayın',
                type: 'warning',
                showConfirmButton: true
            },function(){
                swal.close();
                refresh();
                loader_stop($('.loader_panel'));
            })
        }
    });

});
function refresh(){
    $('#side-navs').find('.list-group-item').each(function(){
        if ($(this).hasClass("active")) {
            $(this).click();
        }
    });
}