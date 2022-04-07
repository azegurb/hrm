$(document).ready(function() {
    // page is now ready, initialize the calendar...
    var data = $('#calendar').data('events');


    $(".beforeDate").datepicker({
        orientation: "left bottom",
        format: 'yyyy-mm-dd',
        endDate: '1d'
    });
    // var dateControler = {
    //     currentDate : null
    // }
    // $(document).on( "change", ".beforeDate",function( event, ui ) {
    //     var now = new Date();
    //     var selectedDate = new Date($(this).val());
    //
    //     if(selectedDate > now) {
    //         $(this).val(dateControler.currentDate)
    //     } else {
    //         dateControler.currentDate = $(this).val();
    //     }
    // });



    if(typeof data != 'undefined'){

        $('#calendar').fullCalendar({
            header: {
                left: null,
                center: 'prev,title,next',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today:    'Bu gün',
                month:    'Ay',
                week:     'Həftə',
                day:      'Gün',
                list:     'Siyahı'
            },

            viewRender: function(view, element) {


            },
            editable: true,
            timeFormat: 'H:mm',
            nextDayThreshold: "00:01:00",
            displayEventEnd: {
                month: false,
                basicWeek: true,
                "default": true
            },
            //
            // Events starting here
            //

            events: data.data,
            dayClick: function(date, allDay, jsEvent, view) {

                if (allDay) {

                    $('#calendar-modal').modal('show');
                    $('#calendar-modal').on('shown.bs.modal' , function(){
                        $(this).find('form').prop('action' , '/personal-cards/special-work-graphics');
                        $(this).find('form').prop('data-type' , 'POST');

                        //Start Date
                        $('.input-daterange-start').datetimepicker({
                            sideBySide: true,
                            defaultDate: moment(date)
                        });
                        $('.input-daterange-start').val(moment(date).format('DD.MM.YYYY HH:mm'));
                        //End Date
                        $('.input-daterange-end').datetimepicker({
                            sideBySide: true,
                            defaultDate: moment(date).add(1,'minutes'),
                            useCurrent: false //Important! See issue #1075
                        });
                        $('.input-daterange-end').val(moment(date).add(1,'minutes').format('DD.MM.YYYY HH:mm'));
                        $(".input-daterange-start").on("dp.change", function (e) {
                            $('.input-daterange-end').data("DateTimePicker").minDate(e.date);
                        });
                        $(".input-daterange-end").on("dp.change", function (e) {
                            $('.input-daterange-start').data("DateTimePicker").maxDate(e.date);
                        });

                    });
                }else{

                }
            },
            eventClick: function(calEvent, jsEvent, view) {
                $('#calendar-modal').modal('show');
                $('.delete-button').show();
                $('#calendar-modal').on('shown.bs.modal' , function(){
                    $(this).find('form').prop('action' , '/personal-cards/special-work-graphics/'+calEvent.id);
                    $(this).find('form').prop('data-type' , 'PUT');

                    $(function () {
                        var modal = $(this);
                        //Start Date
                        modal.find('.input-daterange-end').val(moment(calEvent.end).format('DD.MM.YYYY HH:mm'));
                        modal.find('.input-daterange-start').val(moment(calEvent.start).format('DD.MM.YYYY HH:mm'));
                        modal.find('.input-daterange-start').datetimepicker({
                            sideBySide: true
                        });

                        //End Date
                        modal.find('.input-daterange-end').datetimepicker({
                            sideBySide: true,
                            useCurrent: false //Important! See issue #1075
                        });
                    });

                });
            },


            //
        });

    }
    $('body').on('click', '.fc-button-prev span', function(){
        var date1 = $('#calendar').fullCalendar('prev').fullCalendar( 'getDate' );
        alert('prev ' + date1.getMonth());
        return false;
    });

    $('.fc-button-next span').click(function(){
        var date1 = $('#calendar').fullCalendar('next').fullCalendar( 'getDate' );
        alert('next ' + date1.getMonth());
        return false;
    });
});
// Manipulate Calendar Data
function addData(obj){
    var formData = obj.serialize();
    $('input[type="submit"]').prop('disabled' , true);
    $.ajax({
        url: obj.prop('action'),
        type: obj.prop('data-type'),
        data: formData,
        async: false,
        success: function(data){
            if(data.code == 201){
                $('input[type="submit"]').prop('disabled' , true);
                swal({
                    title: 'Əlavə olundu',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton:false
                });
                $('#calendar-modal').modal('hide');
                var newEvent = new Object();
                newEvent.start = data.data.start;
                newEvent.id = data.data.id;
                newEvent.end = data.data.end;
                newEvent.allDay = true;
                newEvent.title = data.data.startTime+' - '+data.data.endTime;
                // console.log(newEvent);
                $('#calendar').fullCalendar( 'renderEvent', newEvent );
            }else if(data.code == 200){
                $('input[type="submit"]').prop('disabled' , true);
                swal({
                    title: 'Redaktə olundu' ,
                    type: 'success',
                    timer: 1500,
                    showConfirmButton:false
                });
                $('#calendar-modal').modal('hide');
                var existingEvent = new Object();
                existingEvent.id = data.data.id;
                existingEvent.start = data.data.start;
                existingEvent.end = data.data.end;
                $('#calendar').fullCalendar( 'removeEvents', data.data.id);
                $('#calendar').fullCalendar( 'renderEvent', existingEvent );
            }else{
                swal({
                    title: 'Istənilən məlumat əldə edilə bilmədi',
                    text:   'Xahiş olunur səhifəni yeniləyərək yenidən yoxlayın',
                    type:   'warning',
                    showConfirmButton:true
                },function(){
                    window.location.reload();
                });
                throw new Error('Error occured while trying to parse data please reload and try again');
            }
        },
        error: function(data){
            var exception = JSON.parse(data.responseText);
            if(data.status == 422){
                eHandler(exception);
            }else{
                swal({
                    title: 'Istənilən məlumat əldə edilə bilmədi',
                    text:   'Xahiş olunur səhifəni yeniləyərək yenidən yoxlayın',
                    type:   'warning',
                    showConfirmButton:true
                },function(){
                    window.location.reload();
                });
                throw Error('Error occured while trying to path data please reload and try again');
            }
        }
    });
}