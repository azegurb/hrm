// console.log('here and working')

$(function() {

    if (typeof hasId == 'undefined') return;

    if(hasId == 200){
        var margin = $('.page-main').css('margin');
        toggler = false;
        var asideIs = $('.page-aside').outerWidth(true) != null ? true : false;
        var aside = $('.page-aside').outerWidth(true) != null ? $('.page-aside').outerWidth(true) : 350;
        if (side == false){
            asideIs = false;
            aside  = 350;
        }
        $('#tree-container-show').css({ left: (aside)+'px', width:  aside});
        $('.page-main').css({ margin:'0 0 0 '+(aside)+'px'});
        $('#tree-container-show').css('left',0);

        // if (asideIs){
        //     $('.page-main').animate({ margin:'0 0 0 '+(2*aside)+'px'}, {duration: 300,queue: false});
        // }else{
        //     $('.page-main').animate({ margin:'0 0 0 '+(aside)+'px'}, {duration: 300,queue: false});
        // }
        $('#tree-btn').on('click' , function(){
            console.log('test')
            if(toggler){
                aside = 350;
                $('#tree-container-show').animate({ left:'0px' , width: aside+'px' } , {duration: 300,queue: false});
                $('.page-aside').animate({ left:aside+'px' }, {duration: 100,queue: false});
                if (asideIs){
                    $('.page-main').animate({ margin:'0 0 0 '+(2*aside)+'px'}, {duration: 300,queue: false});
                }else{
                    $('.page-main').animate({ margin:'0 0 0 '+(aside)+'px'}, {duration: 300,queue: false});
                }
                toggler = false;
            }else{
                aside = element.offsetWidth;
                $('#tree-container-show').animate({ left:'-'+(aside-10)+'px' } , {duration: 300,queue: false});
                $('.page-aside').animate({ left:'0px' }, {duration: 100,queue: false});
                if(side == false){
                    $('.page-main').animate({ margin: 0 }, {duration: 300,queue: false});
                }else{
                    $('.page-main').animate({ margin:margin }, {duration: 300,queue: false});
                }

                toggler = true;
            }
        });
    }else if(hasId == 500){
        var margin = $('.page-main').css('margin');
        var toggler = false;
        var asideIs = $('.page-aside').outerWidth(true) != null ? true : false;
        var aside = $('.page-aside').outerWidth(true) != null ? $('.page-aside').outerWidth(true) : 350;

        // On Boot Don't show
        $('#tree-container-show').css({ left:'-'+(2*aside)+'px', width:  aside});
        $('.page-main').css({ margin:'0 0 0 '+(aside)+'px'});

        $('#tree-btn').on('click' , function(){
            console.log(asideIs)
            if(toggler){
                $('#tree-container-show').animate({ left:'0px' , width: aside+'px' } , {duration: 300,queue: false});
                $('.page-aside').animate({ left:aside+'px' }, {duration: 100,queue: false});
                if (asideIs){
                    $('.page-main').animate({ margin:'0 0 0 '+(aside)+'px'}, {duration: 300,queue: false});
                }else{
                    $('.page-main').animate({ margin:'0 0 0 '+(aside)+'px'}, {duration: 300,queue: false});
                }
                toggler = false;
            }else{
                $('#tree-container-show').animate({ left:'-'+(aside-10)+'px' } , {duration: 300,queue: false});
                $('.page-aside').animate({ left:'0px' }, {duration: 100,queue: false});
                $('.page-main').animate({ margin:0 }, {duration: 300,queue: false});
                toggler = true;
            }
        });
    }
});
