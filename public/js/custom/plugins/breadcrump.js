/**
 * Created by Asan on 5/12/2017.
 */
// On Load
var breadcrump;
console.log(window.location.pathname);
var href = $('#head-menu').find('.site-menu-item').find('a[href="'+window.location.pathname+'"]').find('span').text();
if (href == ''){
    breadcrump = '<li class="breadcrumb-item"><a onclick="clearUser()" class="mainpagechanger">Əsas səhifə</a></li><li class="breadcrumb-item"><a href="javascript:void(0)">'+$('#side-navs').data('parent')+'</a></li><li class="breadcrumb-item"><a href="javascript:void(0)">'+$('#side-navs').find('a[href="'+window.location.pathname+'"]').text()+'</a></li>';
}else{
    breadcrump = '<li class="breadcrumb-item"><a onclick="clearUser()" class="mainpagechanger">Əsas səhifə</a></li><li class="breadcrumb-item"><a href="javascript:void(0)">'+href+'</a></li>';
}
$('#breadcrump-container').find('#breadcrumb-ol').html(breadcrump);



// On Click
$('#side-navs').find('a').on('click' , function(){
    var name = $(this).text();
    var breadcrump  = '<li class="breadcrumb-item"><a onclick="clearUser()" class="mainpagechanger">Əsas səhifə</a></li><li class="breadcrumb-item"><a href="javascript:void(0)">'+$('#side-navs').data('parent')+'</a></li><li class="breadcrumb-item"><a href="javascript:void(0)">'+name+'</a></li>';
    $('#breadcrump-container').find('#breadcrumb-ol').html(breadcrump);
});

$('a[href="'+window.location.pathname+'"]').addClass('navactive');