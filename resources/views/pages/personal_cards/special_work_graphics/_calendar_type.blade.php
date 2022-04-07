<link rel="stylesheet" href="{{asset('core/global/vendor/fullcalendar/fullcalendar.css')}}">
<link rel="stylesheet" href="{{asset('core/assets/examples/css/apps/calendar.css')}}">
<link rel="stylesheet" href="{{asset('core/global/css/bootstrap-datetimepicker.min.css')}}">
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-30">
            <form id="shiftChanger">
                <div class="col-md-6 float-left">
                    <h4 style="font-size: 15px;">Növbə</h4>
                    <div class="input-group">
                        <input type="hidden" name="id" value="{{$userShiftId->reluserid}}">
                        <select class="form-control select" id="getShift" data-url="{{route('shift.get')}}" name="shift">

                        </select>
                    </div>
                    <div class="col-md-12 mt-20 periodic-shift-selector" style="display: none">
                        <div class="col-md-6 pl-0 float-left">
                            <h4>İş günü</h4>
                            <div class="workDay">
                            </div>
                        </div>
                        <div class="col-md-6 pr-0 float-left">
                            <h4>Istirahət günü</h4>
                            <div class="restDay">

                            </div>
                        </div>
                        <div class="col-md-7 pt-5">
                            <h4 style="font-size: 15px;">Geri seçim tarixi:</h4>
                            <input type="text" class="date_id form-control beforeDate" name="beforeDate">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-left mt-30 approve"> Təsdiq </button>
            </form>
        </div>
    </div>
</div>

    <div id="calendar_type">
        <div id='calendar' data-events="{{$data}}"></div>
    </div>
<style>
    .fc-day-grid-container{
        height: 70vh!important;
    }
</style>
{{--Modal--}}
@include('components.modal-header' , ['id' => 'calendar-modal','mdlTitle' => 'İş vaxtlarının seçim ekranı', 'mdUrl' => route('special-work-graphics.store'), 'custom' => 'addData($(this))'])
<div class="container">
    <div class="row">
        <div class="input-daterange">
            <div class="input-group ">
        <span class="input-group-addon">
            <i class="icon md-calendar" aria-hidden="true"></i>
        </span>
                <input type="text" class="form-control dater input-daterange-start" name="start"/>
            </div>
            <div class="input-group ">
                <span class="input-group-addon">&mdash;</span>
                <input type="text" class="form-control dater input-daterange-end" name="end"/>
            </div>
        </div>
    </div>
</div>
@include('components.modal-footer' , ['custom' => '<button type="button" class="btn btn-danger delete-button" style="display:none;" onclick="deleteEvent($(this))">Sil</button>'])

{{--End Modal--}}

@push('scripts')
    <script src="{{asset('core/global/vendor/moment/moment.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/screenfull/screenfull.js')}}"></script>
    <script src="{{asset('core/global/vendor/fullcalendar/fullcalendar.js')}}"></script>
    <script src="{{asset('core/assets/js/App/Calendar.js')}}"></script>
    <script src="{{asset('js/custom/pages/work-graphics/full-calendar-customization.js')}}"></script>
    <script src="{{asset('js/custom/pages/work-graphics/deleteEvent.js')}}"></script>
    <script src="{{asset('js/custom/plugins/errorHandler.js')}}"></script>
    <script src='{{asset('core/global/vendor/fullcalendar/locale/az.js')}}' ></script>
    <script src='{{asset('core/global/js/Plugin/bootstrap-datetimepicker.js')}}' ></script>
    <script src="{{asset('js/custom/pages/work-graphics/shift-connector.js')}}"></script>
    <script>$('#getShift').selectObj('getShift',false);</script>
    <script>
        var select = $('select#getShift');
        var option = '<option value="{{$userShiftId->id}}" selected>{{$userShiftId->name}}</option>';
        select.append(option);
        shiftData = {
            'periodic' : {{$userShiftId->periodic}},
            'workDay'  : {{$userShiftId->workDay}},
            'restDay'  : {{$userShiftId->restDay}},
            'checkrestDay'  : {{$userShiftId->checkrestDay}},
            'checkworkDay'  : {{$userShiftId->checkworkDay}},
        };
        select.trigger('change');

        $(document).ready(function () {

            $('body').on('click', '.fc-next-button', function(){
                var get_month= $('#calendar').fullCalendar('getDate');

                $.ajax({
                    type: 'GET',
                    url: '/personal-cards/get-month/',
                    data: {obj:get_month.format(), userid:$('#userlongid').val()},
                    success: function (response) {

                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', response.data);
                        $('#calendar').fullCalendar('rerenderEvents');
                    }
                });
            })

            $('body').on('click', '.fc-prev-button', function(){
                var get_month= $('#calendar').fullCalendar('getDate');

                $.ajax({
                    type: 'GET',
                    url: '/personal-cards/get-month/',
                    data: {obj:get_month.format(), userid:$('#userlongid').val()},
                    success: function (response) {

                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', response.data);
                        $('#calendar').fullCalendar('rerenderEvents');

                    }
                });
            })


        })
    </script>
@endpush
