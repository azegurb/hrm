/**
 * Created by Heydər Şükürov on 4/26/2017.
 */
var same;
var route;
function activator(){
    $('#side-navs').find('a').each(function(){
        $(this).removeClass('active');
    });
    $('#side-navs').find('a[href="'+ window.location.pathname +'"]').addClass('active');
}
//Load on click
$('#side-navs').find('a').on('click' , function(e){
    e.preventDefault();
    loader_start($('.loader_panel'));
    var url = $(this).attr('href');
    var contentIds = null;
    var element = null;

    if(url != ''){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            timeout: 30000,
            async: true
        });
        $.ajax({
            // Get Remote data
            url: url+'?load=true',
            type: 'GET',
            success: function (data) {
                if(data != ''){
                    loader_stop($('.loader_panel'));
                    $(data).filter('section').each(function(){
                        element = $(this);
                        contentIds = element.attr('id');
                        $('yield#'+contentIds).html(element.html());
                    });
                    window.history.pushState("","", url);
                    localStorage.setItem('refered' , window.location.href);
                    activator();
                    $('[data-toggle="tooltip"]').tooltip();
                }else{
                    swal("", "Menyu boşdur.", "error");
                    loader_stop($('.loader_panel'));
                }
            },
            error:   function (msg){
                swal("", "Məlumat əldə etmək mümkün olmadı xahiş olunur bir daha cəhd edin", "error");
                loader_stop($('.loader_panel'));
            }
        });
    }
});
//load on browsers nav button click
window.onpopstate = function(e){
    if(window.location.pathname != '/personal-cards' && window.location.pathname != '/helper-lists'){
        var url = window.location.href;
        var contentIds = null;
        var element = null;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            timeout: 30000,
            async: true
        });
        $.ajax({
            // Get Remote data
            url: url+'?load=true',
            type: 'GET',
            success: function (data) {
                if(data != ''){
                    $(data).filter('section').each(function(){
                        element = $(this);
                        contentIds = element.attr('id');
                        $('yield#'+contentIds).html(element.html());
                        activator();
                    });
                }else{
                    swal("", "Menyu boşdur.", "error");
                    loader_stop($('.loader_panel'));
                }
            },
            error:   function (msg){
                swal("", "Məlumat əldə etmək mümkün olmadı xahiş olunur bir daha cəhd edin", "error");
                loader_stop($('.loader_panel'));
            }
        });
    }else{
        $('yield').each(function(){
            $(this).html('');
        });
    }

};

// If LocalStorage not empty equal it to route
if(localStorage.getItem('refered') != null){
    refered = localStorage.getItem('refered');
}else{
    localStorage.setItem('refered' , window.location.href);
}
// Split by / for comparing route and refered
routeArr = window.location.href.split('/');
referedArr = refered.split('/');
//Refered
if(refered != '' && refered != window.location.href && routeArr[3] == referedArr[3]){

    var url = refered;
    var contentIds = null;
    var element = null;
    window.history.pushState("","", url);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });
    $(document).ready(function(){
        $.ajax({
            // Get Remote data
            url: url+'?load=true',
            type: 'GET',
            success: function (data) {
                if(data != ''){
                    $(data).filter('section').each(function(){
                        element = $(this);
                        contentIds = element.attr('id');
                        $('yield#'+contentIds).html(element.html());
                    });
                }else{
                    swal("", "Menyu boşdur.", "error");
                    loader_stop($('.loader_panel'));
                }
            },
            error:   function (msg){
                swal("", "Məlumat əldə etmək mümkün olmadı xahiş olunur bir daha cəhd edin", "error");
                loader_stop($('.loader_panel'));
            }
        });
    });
    localStorage.setItem('refered' , window.location.href);
}else{
    localStorage.setItem('refered' , window.location.href);
}
// Linked Button Marker
$('#side-navs').find('a[href="'+ window.location.pathname +'"]').addClass('active');
