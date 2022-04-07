function getFile(url){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 30000,
        async: true
    });
    $.ajax({
        // Get Remote data
        url: url,
        type: 'GET',
        success: function (data) {
            if(data != ''){
                $('#fileShow').find('.modal-body').html(data);
                $('#fileShow').find('input[type="hidden"]#data').val(data);
                $('#fileShow').modal('show');
            }
        }
    });
}
// function printData(){
//     var divToPrint = document.getElementById('tablehide');
//     console.log(divToPrint);
//     var data = divToPrint.innerHTML;
//     console.log(data);
//     var newWin = window.open('http://www.roberthayeskee.com/bush2.html','_blank','width=200','height=200');
//
//     newWin.document.open();
//
//     newWin.document.write('<html><body onload="window.print()">'+data+'</body></html>');
//
//     newWin.document.close();
//
//     setTimeout(function(){newWin.close();},1);
// }