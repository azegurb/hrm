<section id='links'>
    <style>
        .popover {
            z-index: 4200 !important;
        }
    </style>
</section>
<section id='content'>
    {{--Tabs--}}
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            <div class="tab-content">
                <div class="tab-pane active" id="WorkpanelTab1" role="tabpanel">
                    {{--Umumi--}}
                    <div class="container-fluid">
                        <div class="row">
                            @if($periodic === false)
                                @include('pages.personal_cards.special_work_graphics._table_type' , [ 'data' => $data])
                            @elseif($periodic === true)
                                @include('pages.personal_cards.special_work_graphics._calendar_type' , [ 'data' => $data])
                            @elseif($periodic == 'not')
                                @include('pages.personal_cards.special_work_graphics._undefined')
                            @endif
                        </div>
                    </div>
                </div>
                {{--Gundelik--}}
                <div class="tab-pane" id="WorkpanelTab2" role="tabpanel">
                    <div class="row ">
                        <div class=" col-lg-4 ">
                            <h4 style="font-size: 15px;">İl/Gün/Ay</h4>
                            <div class="input-group">
                               <span class="input-group-addon">
                                 <i class="icon md-calendar" aria-hidden="true"></i>
                               </span>
                               <input type="text" class=" input-datepicker form-control" data-plugin="datepicker" data-multidate="true">
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <h4 style="font-size: 15px;">Başlama vaxtı</h4>
                            <div class="input-group clockpicker-wrap" data-plugin="clockpicker">
                                <input type="text" class="form-control">
                                <span class="input-group-addon">
                                    <span class="md-time"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <h4 style="font-size: 15px;">Bitmə vaxtı</h4>
                            <div class="input-group clockpicker-wrap" data-plugin="clockpicker">
                                <input type="text" class="form-control">
                                <span class="input-group-addon">
                                    <span class="md-time"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-2 example">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Təsdiq</button>
                            </div>
                        </div>
                    </div>
                    <hr></hr>
                    @include('components.filter-bar' , ['sid' => 'special-work-graphics-search','sname' => 'swg-search' , 'pid' => 'special-work-graphics-pagination' , 'pname' => 'swg-pagination'])
                    {{--style=" font-size: 15px; margin-top: 30px; margin-bottom: -4px;"--}}
                    <table  class="table table-hover dataTable3 table-striped w-full" data-plugin="dataTable3">
                        <thead >
                        <tr>
                            <th>№</th>
                            <th>Tarix:</th>
                            <th>İşin başlama vaxtı:</th>
                            <th>İşin bitmə vaxtı:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.personal_cards.special_work_graphics._modals')
    {{-- /Modal --}}


</section>
<section id='scripts'>
    <script src="{{asset('js/custom/pages/work-graphics/modal-control.js')}}"></script>
    <script src="{{asset('js/custom/pages/work-graphics/shiftRadios.js')}}"></script>
    <script src="{{asset('core/global/vendor/moment/moment.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/screenfull/screenfull.js')}}"></script>
    <script src="{{asset('core/global/vendor/fullcalendar/fullcalendar.js')}}"></script>
    <script src="{{asset('core/assets/js/App/Calendar.js')}}"></script>
    <script src="{{asset('js/custom/pages/work-graphics/full-calendar-customization.js')}}"></script>
    <script src="{{asset('js/custom/pages/work-graphics/deleteEvent.js')}}"></script>
    <script src="{{asset('js/custom/plugins/errorHandler.js')}}"></script>
    <script src='{{asset('core/global/vendor/fullcalendar/locale/az.js')}}' ></script>
    <script src='{{asset('core/global/js/Plugin/bootstrap-datetimepicker.js')}}' ></script>
    @stack('scripts')
    <script>
        $(".input-datepicker").datepicker({
            orientation: "left bottom",
            format: "dd.mm.yyyy",
            multidate: true,
            weekStart: 1
        });
    </script>

</section>