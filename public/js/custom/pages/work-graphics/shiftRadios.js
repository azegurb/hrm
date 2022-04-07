var shiftData = null;
$('#getShift').on('change' , function(){
    var data = $(this).select2('data')[0].all;



    if(typeof data == 'undefined' && shiftData != null){
        data = shiftData;
    }

    if(data.periodic == true){
        if(!$('.beforeDate')[0]){

            $('.periodic-shift-selector').append('<div class="col-md-7 pt-5 colexists"><h4 style="font-size: 15px;">Geri seçim tarixi:</h4><input type="text" class="date_id form-control beforeDate" name="beforeDate"></div>');

        }

        $('.periodic-shift-selector').show('fast');
        $('.restDay').html('');
        $('.workDay').html('');
        for(var i = 1; i <= data.restDay; i++){
            $('.restDay').append('' +
                '<div class="radio-custom radio-primary float-left mr-5">' +
                `<input type="radio" id="${i}" name="checkers" class="checkerClass" value='{"rest" : ${i}}'>` +
                '<label for="'+i+'">'+i+'</label>' +
                '</div>' +
                '');
        }

        for(var j = 1; j <= data.workDay; j++){
            $('.workDay').append('' +
                '<div class="radio-custom radio-primary float-left mr-5">' +
                `<input type="radio" id="${j}" name="checkers" class="checkerClass" value='{"work" : ${j}}'>`+
                '<label for="'+j+'">'+j+'</label>' +
                '</div>' +
                '');
        }
        if(typeof data.checkrestDay != 'undefined' && data.checkrestDay != 0){
            $('.restDay').find('input#'+data.checkrestDay).attr('checked' , true)
        }
        if(typeof data.checkworkDay != 'undefined' && data.checkworkDay != 0){
            $('.workDay').find('input#'+data.checkworkDay).attr('checked' , true)
        }

        $(".beforeDate").datepicker({
            format: 'yyyy-mm-dd',
            endDate: '1d'


        });

    }else{
        $('.periodic-shift-selector').hide('fast');
    }
});