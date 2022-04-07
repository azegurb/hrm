
<section id="links">

    <link rel="stylesheet" href="{{asset('core/global/vendor/fullcalendar/fullcalendar.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/apps/calendar.css')}}">

    <style type="text/css">
        .fc-day:hover {
            cursor: pointer;
        }
    </style>

</section>

<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">

            <div id="calendar">

            </div>

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#non-work-days-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.non_work_days._modals')
    {{-- /Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('core/global/vendor/fullcalendar/fullcalendar.js')}}"></script>
    <script>
        $(".non-working-day-date").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });

        var myEvents = {!! $events !!};

        var myOptions = {
            header: {
                left: null,
                center: 'prev,title,next',
                right: 'month,agendaWeek,agendaDay'
            },
            monthNames: ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktryabr', 'Noyabr', 'Dekabr'],
            monthNamesShort: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'İyun', 'İyul', 'Avq', 'Sen', 'Okt', 'Noy', 'Dek'],
            dayNames: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'İyun', 'İyul', 'Avq', 'Sen', 'Okt', 'Noy', 'Dek'],
            dayNamesShort: ['Bazar', 'Bazar ertəsi', 'Çərşənbə aşxamı', 'Çərşənbə', 'Cümə axşamı', 'Cümə', 'Şənbə'],
            buttonText: {
                today: 'Bugün',
                month: 'Ay',
                week: 'Həftə',
                day: 'Gün'
            },
            defaultDate: moment().format('YYYY-MM-DD'),
            selectable: true,
            selectHelper: true,
            select: function select(start, end, jsEvent, view) {
                let startDate = start.format('YYYY-MM-DD');

                $('#non-work-days-modal_form').find('[name="start"]').val(startDate);

                $('#non-work-days-modal').modal('show');
            },
            eventClick: function(event, jsEvent, view) {
                let startDate = event.start.format('YYYY-MM-DD');
                let action    = `/helper-lists/non-work-days/${event.id}`

                $('#non-work-days-edit-modal_form').find('[name="start"]').val(startDate);
                $('#non-work-days-edit-modal_form').find('[name="name"]').val(event.title);

                $('#non-work-days-edit-modal_form').attr('action', action);
                $('#event-delete-form').attr('action', action);

                $('#non-work-days-edit-modal').modal('show');
            },
            editable: true,
            eventLimit: true,
            windowResize: function windowResize(view) {
                var width = $(window).outerWidth();
                var options = Object.assign({}, myOptions);
                options.events = view.calendar.getEventCache();
                options.aspectRatio = width < 667 ? 0.5 : 1.35;

                $('#calendar').fullCalendar('destroy');
                $('#calendar').fullCalendar(options);
            },
            events: myEvents
        };

        var _options = void 0;
        var myOptionsMobile = Object.assign({}, myOptions);

        myOptionsMobile.aspectRatio = 0.5;
        _options = $(window).outerWidth() < 667 ? myOptionsMobile : myOptions;

        $('#editNewEvent').modal();
        $('#calendar').fullCalendar(_options);

    </script>
</section>