@php($uniqid = uniqid())

<div class="mt-20" id="vacation">
<style>
    .select2-container--default {
        display: block;
        z-index: 9001;
    }
</style>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="orderTypeLabel" value="vacation">
            <input type="hidden" name="listVacationTypeIdLabel" value="sabbatical_leave">

                <input type="hidden" name="orderVacationId" value="{{ $objwhole->fields['child']['orderVacationIdId'] }}">


            <div class="row">
                <div class="col-md-2">
                    <h4>Məzuniyyətin tipi: (edit)</h4>
                    <select name="listVacationTypeId" id="listVacationTypeId" class="form-control select"
                            data-url="{{ route('vacation-types.list') }}">
                        @if(isset($objwhole->listVacationTypeName))
                            <option value="{{ $objwhole->listVacationTypeId }}"
                                    selected>{{ $objwhole->listVacationTypeName }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-3 userList">
                    <h4>Əməkdaş:</h4>
                    <?php

//                        dd($objwhole);
                        ?>
                    <select name="userId" id="userInVacationIdY" class="form-control select" data-url="{{ route('users', 'select') }}">
                        @if(isset($objwhole->fields['child']['userName']))
                            <option value="{{ $objwhole->fields['child']['userId'] }}"
                                    selected>{{ $objwhole->fields['child']['userName'] }}</option>
                        @endif
                    </select>
                </div>
                <div class="sabbaticalInputs col-md-7 row">

                    @if($objwhole->fields['child']['listVacationId']!=null)
                    <div class="col-md-5 sabbaticalLeaveVacation">
                        <h4>Əlavə məzuniyyət tipləri:</h4>
                        <select id="sabbaticalLeave" name="sabbaticalLeaveName" class="form-control select" data-url="/orders/get-sabbatical-leave-search/{{$objwhole->listVacationTypeId }}/?select=root">

                            @if(isset($objwhole->fields['child']['listVacationName']))
                                <option value="{{ $objwhole->fields['child']['listVacationId'] }}"
                                        selected>{{ $objwhole->fields['child']['listVacationName'] }}</option>
                            @endif
                        </select>
                    </div>
                    @endif
                    <div class="col-md-5 sabbaticalLeaveVacationSecondRoot" style="display: none;">


                    </div>
                    <div class="col-md-2 sabbaticalLeaveVacationDays">
                        <h4>Gün/Ay:</h4>
                        <input type="text" id="sabbaticalLeaveDays" class="form-control pl-2 pr-0" name="vacationDay" value="{{ $objwhole->fields['child']['vacationDay'] }}">

                    </div>
                    <div class="col-md-2 vacationStart pl-0 pr-5">
                        <h4>Başlama vaxtı:</h4>
                        <div id="vacationStartDate">
                            <input type="text" class="col-md-12 form-control" name="vacationStartDate" id="sabbaticalVacationStartDate" value="{{   $objwhole->fields['child']['startDate'] }}">
                        </div>
                    </div>
                    <div class="col-md-2 vacationEnd pl-0 pr-0">
                        <h4>Bitmə vaxtı:</h4>
                        <div id="vacationEndDate"><input type="text" class="col-md-12 form-control" name="vacationEndDate" id="sabbaticalVacationEndDate" value="{{ $objwhole->fields['child']['endDate'] }}"></div>
                    </div>

                    <div class="col-md-3 workStartDate">
                        <h4>İşə başlama vaxtı:</h4>
                        <div id="workStartDate"><input type="text" class="col-md-12 form-control startDate" name="workStartDate" value="{{ $objwhole->fields['child']['workStartDate'] }}"></div>

                    </div>
                    {{--<div class="col-md-3 sabbaticalLeaveFromPeriod">--}}
                        {{--<h4>İlkin dövr:</h4>--}}
                        {{--<div id="sabbaticalLeaveFromPeriod"><input type="text" class="col-md-12 form-control LeaveFromPeriod" name="sabbaticalLeaveFromPeriod" value="{{ $objwhole->fields['child']['vacationWorkPeriodFrom'] }}"></div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-3 sabbaticalLeaveToPeriod">--}}
                        {{--<h4>Son dövr:</h4>--}}
                        {{--<div id="sabbaticalLeaveToPeriod"><input type="text" class="col-md-12 form-control LeaveToPeriod" name="sabbaticalLeaveToPeriod" value="{{ $objwhole->fields['child']['vacationWorkPeriodTo'] }}"></div>--}}
                    {{--</div>--}}
                </div>

                <div class="col-md-9 row vacationTypes">

                    {{--<div class="col-md-3"><h4>Əməkdaş:</h4>--}}

                        {{--<input type="hidden" id="userOldId" value="{{ $array->userIdId }}" data-value="{{$footer_str}}">--}}
                        {{--<select name="userId" id="userInVacationIdL" class="form-control select userInVacationIdL"  data-url="{{ route('users', 'select') }}"> @if(isset($array)) <option value="{{ $array->userIdId }}" selected>{{ $array->userIdLastName }} {{ $array->userIdFirstName }}</option> @endif  </select>--}}
                    {{--</div>--}}




                </div>
            </div>
        </div>
        <hr class="col-md">

        <div class="col-md-12">

            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-12 vacation-dates">

                        <div class="row">
                            <?php

//                            dd($objwhole);

                            ?>
                            @php($id = uniqid())

                        </div>
                        <!-- /dynamicly added vacation details -->


                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12 fillvacation">


                        <?php

                        //                                dd($objwhole->vacation->data, $period_array);
                        ?>

                        {{--</div>--}}
                    </div>

                </div>
            </div>
        </div>
        {{--<hr class="col-md">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12 row ml-0 pl-0 mr-0 pr-0">--}}

                    {{--<div class="col-md-4 pull-l">--}}
                           {{--<div class="col-md-12 mt-20">--}}
                            {{--<h4>Qeyd:</h4>--}}
                            {{--<textarea name="vacationComment" cols="30" rows="5" class="form-control"--}}
                                      {{--value="@if(isset($array)){{$array->vacationComment}}@endif"></textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}

        <hr class="col-md">
        {{--<div class="col-md-12 vacationTypes">--}}
            {{--<div class="fillDates">--}}


            {{--</div>--}}

        {{--</div>--}}

    </div>
</div>

<script>

    $(document).ready(function () {


        $('#btnCloneForm').hide();

        $('#sabbaticalVacationStartDate').datepicker({
            orientation: "top",
            format: 'dd.mm.yyyy',
            autoclose: true,
            todayHighlight: true,

        }).on('changeDate', function () {

//            alert($(this).val())

            var type="day";

            if($('#durationTypeHidden').val()=='Ay'){

                type="month";
            }
//            alert($('#sabbaticalLeaveDays').val());
//            $("#list option:selected").text();
            $.ajax({
                method: 'GET',
                url: '/orders/count-days/'+type+'/'+$('#sabbaticalLeaveDays').val()+'/'+$('#sabbaticalVacationStartDate').val(),
                success: function (response) {

                    $('#sabbaticalVacationEndDate').val(response)

                },
                error: function (err) {

                    throw new Error('Error counting sabbatical leave: ' + err);

                }
            });


        });;

        $('#sabbaticalVacationEndDate').datepicker({
            orientation: "top",
            format: 'dd.mm.yyyy',
            autoclose: true,
            todayHighlight: true,

        });

//        $('body').on('change', '#userInVacationIdY')
        $('body').on('change', '#sabbaticalLeave', function () {


            $('.sabbaticalLeaveVacationDays').html('<h4>Günlər:</h4><input type="text" id="sabbaticalLeaveDays" class="form-control select pl-2 pr-0" name="vacationDay">');

            $('.listDurationType').html('<div  style="margin-top: 35px"><div id="durationType"></div><input type="hidden" name="durationTypeHidden" id="durationTypeHidden"></div>');

            $('.vacationStart').html('<h4>Başlama vaxtı:</h4><div  id="vacationStartDate"><input type="text" class="col-md-12 form-control" name="vacationStartDate" id="sabbaticalVacationStartDate"></div>');

            $('.vacationEnd').html('<h4>Bitmə vaxtı:</h4><div  id="vacationEndDate"><input type="text" class="col-md-12 form-control" name="vacationEndDate" id="sabbaticalVacationEndDate"></div>');

            $('.workStartDate').html('<h4>İşə başlama vaxtı:</h4><div  id="workStartDate"><input type="text" class="col-md-12 form-control startDate" name="workStartDate"></div>');

//        $('.sabbaticalLeaveFromPeriod').html('<h4>İlkin dövr:</h4><div  id="sabbaticalLeaveFromPeriod"><input type="text" class="col-md-12 form-control LeaveFromPeriod" name="sabbaticalLeaveFromPeriod"></div>');
//
//        $('.sabbaticalLeaveToPeriod').html('<h4>Son dövr:</h4><div  id="sabbaticalLeaveToPeriod"><input type="text" class="col-md-12 form-control LeaveToPeriod" name="sabbaticalLeaveToPeriod"></div>');

//            alert($('#sabbaticalLeaveSecond').val())
            var val=$(this).val(), userId=$('#userInVacationIdY').val();

            var selectStr='';

            $.ajax({
                method: 'GET',
                url: '/orders/get-sabbatical-child-count/' + val,
                success: function (response) {

                    if(response.data[0]){

//                        alert(response.data)
                        $('.sabbaticalLeaveVacationSecondRoot').show();

                    }
                    else {

                        $('.sabbaticalLeaveVacationSecondRoot').hide();
                        $('.sabbaticalLeaveVacationSecondRoot').html('');
//                   $('.sabbaticalLeaveVacationSecondRoot').find('#sabbaticalLeaveSecond').attr('disabled');
                        $.ajax({
                            method: 'GET',
                            url: '/orders/get-sabbatical-vacation-days/' + val+ '/'+userId,
//                       url:'/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select=root,
                            success: function (response) {

                                console.log(response)


                                $('#sabbaticalLeaveDays').val(response.data[0].value);

                                $('#durationType').html(response.data[0].listDurationTypeIdName);

                                $('#durationTypeHidden').val(response.data[0].listDurationTypeIdName);

                                $('.LeaveFromPeriod').val(response.data[0].periodFirstDate);

                                $('.LeaveToPeriod').val(response.data[0].periodLastDate);

                            },
                            error: function (err) {

                                throw new Error('Error getting sabbatical vacation days: ' + err);

                            }
                        });
                    }

                },
                error: function (err) {

                    throw new Error('Error getting sabbatical vacation days: ' + err);

                }
            });

            $.ajax({
                method: 'GET',
                url: '/orders/get-sabbatical-vacation-days/' + val+'/'+userId,
                success: function (response) {

                    console.log(response)
                    response.data.forEach(function (element, item) {

                        selectStr=selectStr+'<option value="'+element['id']+'">'+element['value']+'</option>';


                    });
//
//                selectStr=selectStr+'</select>';

                    $('#sabbaticalLeaveDays').val(response.data[0].value);

                    $('#durationType').html(response.data[0].listDurationTypeIdName);

                    $('#durationTypeHidden').val(response.data[0].listDurationTypeIdName);

                    $('.LeaveFromPeriod').val(response.data[0].periodFirstDate);

                    $('.LeaveToPeriod').val(response.data[0].periodLastDate);

                },
                error: function (err) {

                    throw new Error('Error getting sabbatical vacation days: ' + err);

                }
            });

            $('#sabbaticalVacationStartDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            }).on('changeDate', function () {

//            alert($(this).val())

                var type="day";

                if($('#durationTypeHidden').val()=='Ay'){

                    type="month";
                }
//            alert($('#sabbaticalLeaveDays').val());
//            $("#list option:selected").text();
                $.ajax({
                    method: 'GET',
                    url: '/orders/count-days/'+type+'/'+$('#sabbaticalLeaveDays').val()+'/'+$('#sabbaticalVacationStartDate').val(),
                    success: function (response) {

                        $('#sabbaticalVacationEndDate').val(response)

                    },
                    error: function (err) {

                        throw new Error('Error counting sabbatical leave: ' + err);

                    }
                });


            });

            $('#sabbaticalVacationEndDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            });
//        $('.LeaveFromPeriod').datepicker({
//            orientation: "top",
//            format: 'dd.mm.yyyy',
//            autoclose: true,
//            todayHighlight: true,
//
//        });
//
//        $('.LeaveToPeriod').datepicker({
//            orientation: "top",
//            format: 'dd.mm.yyyy',
//            autoclose: true,
//            todayHighlight: true,
//
//        });
            $('.startDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            });

        });

        $('body').on('change', '#sabbaticalLeaveSecond', function () {

            $('.sabbaticalLeaveVacationDays').html('<h4>Günlər:</h4><input type="text" id="sabbaticalLeaveDays" class="form-control select pl-2 pr-0" name="vacationDay">');

            $('.listDurationType').html('<div  style="margin-top: 35px"><div id="durationType"></div><input type="hidden" name="durationTypeHidden" id="durationTypeHidden"></div>');

            var val=$(this).val(), userId=$('#userInVacationIdY').val();

            var selectStr='';

            $.ajax({
                method: 'GET',
                url: '/orders/get-sabbatical-vacation-days/' + val+'/'+userId,
                success: function (response) {

                    console.log(response)
                    response.data.forEach(function (element, item) {

                        selectStr=selectStr+'<option value="'+element['id']+'">'+element['value']+'</option>';


                    });

                    $('#sabbaticalLeaveDays').val(response.data[0].value);

                    $('#durationType').html(response.data[0].listDurationTypeIdName);

                    $('#durationTypeHidden').val(response.data[0].listDurationTypeIdName);


                },
                error: function (err) {

                    throw new Error('Error getting sabbatical vacation days: ' + err);

                }
            });

            $('#sabbaticalVacationStartDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            }).on('changeDate', function () {

                var type="day";

                if($('#durationTypeHidden').val()=='Ay'){

                    type="month";
                }

                $.ajax({
                    method: 'GET',
                    url: '/orders/count-days/'+type+'/'+$('#sabbaticalLeaveDays').val()+'/'+$('#sabbaticalVacationStartDate').val(),
                    success: function (response) {

                        $('#sabbaticalVacationEndDate').val(response)

                    },
                    error: function (err) {

                        throw new Error('Error counting sabbatical leave: ' + err);

                    }
                });


            });

            $('#sabbaticalVacationEndDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            });
//        $('.LeaveFromPeriod').datepicker({
//            orientation: "top",
//            format: 'dd.mm.yyyy',
//            autoclose: true,
//            todayHighlight: true,
//
//        });
//
//        $('.LeaveToPeriod').datepicker({
//            orientation: "top",
//            format: 'dd.mm.yyyy',
//            autoclose: true,
//            todayHighlight: true,
//
//        });
            $('.startDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            });

        });

        @if(isset($array))

            $('.select').select2({
            placeholder: 'Seçilməyib',
            width: '100%'
        });




        $('#listVacationTypeId').selectObj('listVacationTypeId');

        $('#userInVacationStructureId').selectObj('userInVacationStructureId');

        var url = $('#userInVacationPositionNameId').data('url') + '/' + '{{ $array->structureIdId }}';

        $('#userInVacationPositionNameId').selectObj('userInVacationPositionNameId', false, url);

        var userInVacationUrl = $('#userInVacationIdL').data('url') + '/' + '{{ $array->posNameIdId }}';

        $('#userInVacationIdL').selectObj('userInVacationIdL', false, userInVacationUrl);

        /*
         *
         * When structure is selected pass its id to position names url param
         * and trigger select2
         * */
        $('#userInVacationStructureId').on('select2:select', function () {

            $('#userInVacationPositionNameId').empty('');

            $('#userInVacationIdL').empty('');

            var url = $('#userInVacationPositionNameId').data('url') + '/' + $(this).val();

            $('#userInVacationPositionNameId').selectObj('userInVacationPositionNameId', false, url);

        });

        /*
         *
         * When position name is chosen pass its id and get employees
         * trigger select2
         * */

        $('#userInVacationPositionNameId').on('select2:select', function () {

            var url = $('#userInVacationIdL').data('url') + '/' + $(this).val();


            $('#userInVacationIdL').selectObj('userInVacationIdL', false, url);

        });

        @else

            $('.select').select2({
            placeholder: 'Seçilməyib',
            width: '100%'
        });


        $('body').on("select2:select", '.additional-types', function (e) {

            //  alert(this.value)

        });

        $('body').on('change', '#listVacationTypeId', function () {

            $('.vacationTypes').html('');
            $('.fillvacation').html('');
            $('#userInVacationIdY').html('');
//            $('.userList').html('');

//            alert($(this).select2('data')[0].label);
            if($(this).select2('data')[0].label=='labor_vacation') {

                $('.sabbaticalInputs').find('div').each(function () {

                    $(this).html('');

                });

                $('#listVacationTypeIdLabel').val('labor_vacation');

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationId" class="form-control select"  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                $('.vacationTypes').html('<div class="col-md-8"><div class="fillDates"></div></div><div class="col-md-4 fillAdditionalVacationTypes"></div>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationId').selectObj('userInVacationId', false, url);

                var vacationstr='<div class="row ml-15">'+
                    ' <div class="col-md-2 mt-15 pull-l">İş ili dövrü</div>'+
                    '<div class="col-md-1 mt-15 pull-l">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</div>'+
                    '<div class="col-md-1 mt-15 pull-l">İşçinin əlavə məzuniyyəti</div>'+
                    '<div class="col-md-1 mt-15 pull-l">istifadə etdiyi əsas məzuniyyət günləri</div>'+
                    '<div class="col-md-1 mt-15 pull-l">Əsas məzuniyyət gününün qalığı</div>'+
                    '<div class="col-md-1 mt-15 pull-l">Istifadə etdiyi əlavə məzuniyyət günləri</div>'+
                    '<div class="col-md-1 mt-15 pull-l">Əlavə məzuniyyət gününün qalığı</div>'+
                        {{--<div class="col-md-1 mt-15 pull-l">Cari əlavə məzuniyyət (İşçinin vəzifəsinə uyğun əlavə məzuniyyət günü)</div>--}}
                                {{--<div class="col-md-1 mt-15 pull-l">Cəmi məzuniyyət</div>--}}
                            '<div class="col-md-1 mt-15 pull-l" style="display:none"><b>Əlavə məzuniyyət</b></div>'+
                    '<div class="col-md-1 mt-15 pull-l">Ümumi istifadə olunan</div>'+
                    '<div class="col-md-1 mt-15 pull-l">Cari məzuniyyət</div>'+
                    '<div class="col-md-1 mt-15 pull-l">Kollektive müqavilə üzrə</div>'+
                    '<div class="col-md-1 mt-15 pull-l" style="display:none"><b>(əsas m)</b></div>'+


                    '</div><div class="fillArch"></div>';

                $('.fillvacation').html(vacationstr);

                $('.mainVacationDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })

            }

            else if($(this).select2('data')[0].label=='sabbatical_leave' || $(this).select2('data')[0].label=='paid_social_vacation' || $(this).select2('data')[0].label=='paid_educational_vacation' || $(this).select2('data')[0].label=='nonpaid_vacation'){

                $('#listVacationTypeIdLabel').val('sabbatical_leave');

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationIdY" class="form-control select"  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationIdY').selectObj('userInVacationIdY', false, url);

                var url2 = '/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select=root';

                $('.sabbaticalLeaveVacation').html('<h4>Əlavə məzuniyyət tipləri:</h4><select id="sabbaticalLeave" name="sabbaticalLeaveName" class="form-control select" data-url="'+url2+'"></select>');

                $('#sabbaticalLeave').selectObj('sabbaticalLeave', false, url2);

                $('#sabbaticalLeave').on('select2:select', function () {

                    var id=$(this).select2('data')[0].id;

                    $('.sabbaticalLeaveVacationSecondRoot').html('<h4>Əlavə məzuniyyət alt tiplər:</h4><select id="sabbaticalLeaveSecond" name="sabbaticalLeaveName" class="form-control select" data-url="/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select='+id+'"></select>');
                    var url3 = "/orders/get-sabbatical-leave-search/"+$('#listVacationTypeId').val()+"/?select="+id;
                    $('#sabbaticalLeaveSecond').selectObj('sabbaticalLeaveSecond', false, url3);
                });

//            $.ajax({
//                method: 'GET',
//                url: '/orders/get-sabbatical-leave/',
//                success: function (response) {
//
//                    selectStr='';
//
////                    response.data.forEach(function (element, item) {
////
////                        selectStr=selectStr+'<option value="'+element['id']+'">'+element['name']+'</option>';
////
////                    })
////
////                    selectStr=selectStr+'</select>';
////
////                    $('#sabbaticalLeave').html(selectStr);
//
//
//
//
//                },
//                error: function (err) {
//
//                    throw new Error('Error getting sabbatical leave: ' + err);
//
//                }
//            });

            }


        });

        $('#listVacationTypeId').selectObj('listVacationTypeId');

        $('#userInVacationStructureId').selectObj('userInVacationStructureId');

        /*
         *
         * When structure is selected pass its id to position names url param
         * and trigger select2
         * */
        $('#userInVacationStructureId').on('select2:select', function () {

            $('#userInVacationPositionNameId').empty('');

            $('#userInVacationIdL').empty('');

            var url = $('#userInVacationPositionNameId').data('url') + '/' + $(this).val();


            $('#userInVacationPositionNameId').selectObj('userInVacationPositionNameId', false, url);

        });



        $('#userInVacationIdY').selectObj('userInVacationIdY', false, $('#userInVacationIdY').attr('data-url'));

        var url = $('#userInVacationIdL').data('url');

        @endif

        /* datepicker */
        $('[data-plugin="datepicker"]').datepicker({
            orientation: "top",
            format: 'dd.mm.yyyy',
            autoclose: true,
            todayHighlight: true,
        });



        /* get vacation dates */
        $(document).on('changeDate', '#vacationStartDate', function () {

            /* get user id */
            let user = $('#userInVacationIdL').val();
            /* get vacation start date */
            let date = ($(this).val()).split('.');

            /* generate Java date */
            let service_date = date[2] + '-' + date[1] + '-' + date[0];

            /* make an ajax call */
            $.ajax({
                method: 'GET',
                url: '/orders/vacation/get-remaining-days/'+ user + '/' + service_date,
                success: function (response) {

                    /* response code is OK */
                    console.log(response);
                    if (response.code == 200)
                    {
                        /* append vacation days */
                        $('#mainVacation')
                            .val(response.data.vacationDays);
                        /* append additional vacation days */
                        $('#additionalVacation')
                            .val(response.data.additionalVacationDays);
                    }
                    else
                    {
                        /* append vacation days - default zero */
                        $('#mainVacation')
                            .val(0);
                        /* append additional vacation days - default zero */
                        $('#additionalVacation')
                            .val(0);
                    }

                },
                error: function (err) {

                    /* append vacation days */
                    $('#mainVacation').val(0);
                    /* append additional vacation days */
                    $('#additionalVacation').val(0);

                    throw new Error('Error getting vacation days: ' + err);

                }
            });
        });

        /* calculate number of days between start and end dates */
        $(document).on('changeDate', '#vacationEndDate', function () {

            /* get start date */
            let vacationStartDate = $('#vacationStartDate').val();
            /* vacation end date */
            let vacationEndDate   = $(this).val();

            /* get days diff between dates */
            /* moment.js */
            let daysDiff = moment(vacationEndDate, 'DD.MM.YYYY').diff(moment(vacationStartDate, 'DD.MM.YYYY'), 'days');

            /* append days to closest input[type="number"] */
            $("#difference_time").val(daysDiff);

        });

        /* check if  main vacation days are drained before using additional vacation */
        $(document).on('change', '#isMainVacation', function () {

            /* main vacation days */
            let mainVacationDays = $('#mainVacation').val();

            /* if vacation is the main */
//        if (!$(this).is(':checked') && mainVacationDays > 0)
//        {
//            /* give info message */
//            swal('Diqqət!', 'Əsas məzuniyyət günləri tam istifadə olunmamış işçi əlavə məzuniyyətə göndərilə bilməz.', 'info');
//            /* trigger click to change value */
//            $(this).trigger('click');
//        }

        });

        $('body').on('change',  '#userInVacationIdL', function () {


            if($(this).val()!=$('#userOldId').val()) {

                var options = '', additionalDays = '<h4>Əlavə məzuniyyət növləri:</h4><select class="form-control additional-types" multiple>';

                $.ajax({
                    method: 'GET',
                    url: '/orders/get-additional-vacation-days/' + $(this).val(),
                    success: function (response) {

                        console.log(response);

                        if (response.code == 200) {
                            response.data.forEach(function (element, index) {

                                options = options + '<option value="' + response.data[index].id + '" id="' + response.data[index].day + '">' + response.data[index].name + '</option>';


                            });

                            additionalDays = additionalDays + options + '</select>';

                            $('.fillAdditionalVacationTypes').html(additionalDays)
                        }

                        $('.additional-types').select2({placeholder: 'Seçin...'});

                    },
                    error: function (err) {

                        throw new Error('Error getting additional days: ' + err);

                    }
                });

                $.ajax({
                    method: 'GET',
                    url: '/orders/getarch/' + $(this).val(),
                    success: function (response) {

                        /* response code is OK */
                        var data = '', klass = '', selectedMaxData = '', con = '', currentAdditionalVacation, chosenData = '', currentVacation = '', mainRemainderVacationday = '';
                        console.log(response);
                        if (response.code == 200) {
                            response.data.forEach(function (element, index) {

                                klass = index > 0 ? 'multi' : 'first';

//                        if(response.data[index].months>=6) {
//                        con = response.data[index].con == 1?response.data[index].mainRemainderVacationDay!='0'?parseInt(response.data[index].mainVacationDay)-parseInt(response.data[index].mainRemainderVacationDay) : '0':response.data[index].mainVacationDay;
                                if (response.data[index].con == 1) {

                                    if (response.data[index].mainRemainderVacationDay != '0' || response.data[index].additionalRemainderVacationDay != '0') {

                                        con = parseInt(response.data[index].mainRemainderVacationDay);
                                    }
                                    else {

                                        con = response.data[index].mainVacationDay;
                                    }
                                }
                                else {

                                    con = response.data[index].mainVacationDay;
                                }

                                currentAdditionalVacation = response.data[index].con == 1 ? response.data[index].additionalRemainderVacationDay : response.data[index].additionalVacationDay;
                                currentVacation = response.data[index].con == 1 ? response.data[index].additionalRemainderVacationDay : (con / 12) * response.data[index].months.toFixed(2);
                                if (response.data[index].con == 1) {
                                    if (response.data[index].mainRemainderVacationDay != '0' || response.data[index].additionalRemainderVacationDay != '0') {

                                        mainRemainderVacationday = parseInt(response.data[index].mainVacationDay) - parseInt(response.data[index].mainRemainderVacationDay);


                                    }
                                    else {
//                                mainRemainderVacationday='0';

                                        mainRemainderVacationday = parseInt(response.data[index].mainRemainderVacationDay);

                                    }
                                }
                                else {
                                    mainRemainderVacationday = '0';
                                }

                                if (response.data[index].additionalRemainderVacationDay == '0' && response.data[index].mainRemainderVacationDay != '0') {

                                    var totalRemainder = parseInt(response.data[index].mainRemainderVacationDay) + parseInt(response.data[index].additionalVacationDay);
                                }
                                else if (response.data[index].additionalRemainderVacationDay == '0' && response.data[index].mainRemainderVacationDay == '0') {

                                    var totalRemainder = parseInt(response.data[index].mainVacationDay) + parseInt(response.data[index].additionalVacationDay);

                                }
                                else {

                                    var totalRemainder = parseInt(response.data[index].mainRemainderVacationDay) + parseInt(response.data[index].additionalRemainderVacationDay);

                                }
                                var totalVacation = parseInt(response.data[index].mainVacationDay) + parseInt(response.data[index].additionalVacationDay);

                                if (response.data[index].con == 1) {

                                    if (response.data[index].additionalRemainderVacationDay == '0') {
                                        var elaveMezuniyyetQaliq = '0';
                                    }
                                    else {
                                        var elaveMezuniyyetQaliq = parseInt(response.data[index].additionalVacationDay) - parseInt(response.data[index].additionalRemainderVacationDay);

                                    }
                                }
                                else {
                                    var elaveMezuniyyetQaliq = response.data[index].additionalRemainderVacationDay;

                                }

                                if (response.data[index].additionalRemainderVacationDay == '0' && response.data[index].mainReminderVacationDay != '0') {

                                    response.data[index].additionalRemainderVacationDay = parseInt(response.data[index].additionalVacationDay);
                                }


                                selectedMaxData = totalRemainder > 0 ? totalRemainder : totalVacation;

                                data = data + '<div class="row">';
                                data = data + '<div class="mt-15 pull-l pr-0 checkbox-custom checkbox-primary"><input type="checkbox" class="col-md-12 form-control enableIt pl-1 pr-1 ' + klass + '" name="enableIt" rel="' + index + '"><label for="enableIt"></label></div>';
                                data = data + '<div class="col-md-1 mt-15 pull-l pr-0"><input type="text" class="col-md-12 form-control pl-1 pr-1 vacationWorkPeriodFrom" id="remainingDays" data-name="vacationWorkPeriodFrom[]" value="' + response.data[index].fromDate + '"></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l pr-0"><input type="text" class="col-md-12 form-control pl-1 pr-1 vacationWorkPeriodTo" id="remainingDays" data-name="vacationWorkPeriodTo[]" value="' + response.data[index].toDate + '"></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 mainVacationDayForPerson" data-name="mainVacationDayForPerson[]" data-value="' + response.data[index].mainVacationDay + '" readonly value="' + response.data[index].mainVacationDay + '"></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 currentAdditionalVacation" data-name="currentAdditionalVacation[]" data-value="' + response.data[index].additionalVacationDay + '" required readonly value="' + response.data[index].additionalVacationDay + '"></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 mainRemainderVacationDay" readonly data-name="mainRemainderVacationDay[]" data-value="' + mainRemainderVacationday + '" readonly value="' + mainRemainderVacationday + '"></div>';
                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 currentMainVacation" data-name="currentMainVacation[]" data-value="' + con + '" required value="' + con + '"></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 additionalVacationDay" data-name="additionalVacationDay[]" data-value="' + elaveMezuniyyetQaliq + '"  value="' + elaveMezuniyyetQaliq + '" readonly></div>';
                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 additionalRemainderVacationDay" readonly data-name="additionalRemainderVacationDay[]"  data-value="' + response.data[index].additionalRemainderVacationDay + '" value="' + response.data[index].additionalRemainderVacationDay + '"></div>';
//                        data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 totalVacation" data-name="totalVacation[]" data-value="' + selectedMaxData + '" readonly value="' + selectedMaxData + '"></div>';
                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 radditionalVacation"  readonly data-name="radditionalVacation[]" data-rel="" value="0"  required rel=""></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 chosenAmount" data-name="chosenAmount[]" data-rel="' + (index + 1) + '" value="0"  max="' + selectedMaxData + '" required disabled rel="' + response.data[index].con + '"></div>';

                                data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2"  value="' + currentVacation + '"  required disabled rel="' + currentVacation + '"></div>';
                                data = data + '<div><input type="number" class="col-md-8 form-control p-2 rmainVacation" readonly data-name="rmainVacation[]" style="width:73px"></div>';

                                data = data + '</div>';

//                                if (index != 0) {

                                chosenData = chosenData + '<div class="row"><div class="col-md-6"><h4>Məzuniyyətin başlama vaxtı:</h4><input type="text" class="col-md-12 form-control mainVacationDate" rel="' + index + '" name="vacationStartDate[]"></div>';

                                chosenData = chosenData + '<div class="col-md-6"><h4>Məzuniyyətin bitmə vaxtı:</h4><input type="text" class=" col-md-12 form-control additionalVacationDate" id="additionalVacation" name="vacationEndDate[]"></div></div>';

//                                }
//                        }
                            });



                            $('.fillArch').html(data);
                            $('.fillDates').html(chosenData);
                            $('.mainVacationDate').datepicker({
                                orientation: "top",
                                format: 'dd.mm.yyyy',
                                autoclose: true,
                                todayHighlight: true,

                            })
                        }
                        else {

                        }

                    },
                    error: function (err) {


                        throw new Error('Error getting vacation days: ' + err);

                    }
                });


            }
            else {



                $('.fillvacation').html($('#userOldId').data('value'))
            }
        });

        $('#sabbaticalLeave').selectObj('sabbaticalLeave', false, $('#sabbaticalLeave').attr('data-url'));

//        $('body').on('click', '.clearVacation', function () {
//
//            var that=$(this);
//
//            $.ajax({
//                method: 'GET',
//                url: 'orders/get-last-vacation-days/'+$(this).attr('rel')+'/'+ $(this).attr('id'),
//                success: function (response) {
//
//                    var periodstr='';
//
//                    var data = '', klass = '', selectedMaxData = '', con = '', currentAdditionalVacation, chosenData = '', currentVacation = '', mainRemainderVacationday = '';
//                    console.log(response);
//                    if (response.code == 200) {
//                        response.data.forEach(function (element, index) {
//
//                            klass = index > 0 ? 'multi' : 'first';
//
////                        if(response.data[index].months>=6) {
////                        con = response.data[index].con == 1?response.data[index].mainRemainderVacationDay!='0'?parseInt(response.data[index].mainVacationDay)-parseInt(response.data[index].mainRemainderVacationDay) : '0':response.data[index].mainVacationDay;
//                            if (response.data[index].con == 1) {
//
//                                if (response.data[index].mainRemainderVacationDay != '0' || response.data[index].additionalRemainderVacationDay != '0') {
//
//                                    con = parseInt(response.data[index].mainRemainderVacationDay);
//                                }
//                                else {
//
//                                    con = response.data[index].mainVacationDay;
//                                }
//                            }
//                            else {
//
//                                con = response.data[index].mainVacationDay;
//                            }
//
//                            currentAdditionalVacation = response.data[index].con == 1 ? response.data[index].additionalRemainderVacationDay : response.data[index].additionalVacationDay;
//                            currentVacation = response.data[index].con == 1 ? response.data[index].additionalRemainderVacationDay : (con / 12) * response.data[index].months.toFixed(2);
//                            if (response.data[index].con == 1) {
//                                if (response.data[index].mainRemainderVacationDay != '0' || response.data[index].additionalRemainderVacationDay != '0') {
//
//                                    mainRemainderVacationday = parseInt(response.data[index].mainVacationDay) - parseInt(response.data[index].mainRemainderVacationDay);
//
//
//                                }
//                                else {
////                                mainRemainderVacationday='0';
//
//                                    mainRemainderVacationday = parseInt(response.data[index].mainRemainderVacationDay);
//
//                                }
//                            }
//                            else {
//                                mainRemainderVacationday = '0';
//                            }
//
//                            if (response.data[index].additionalRemainderVacationDay == '0' && response.data[index].mainRemainderVacationDay != '0') {
//
//                                var totalRemainder = parseInt(response.data[index].mainRemainderVacationDay) + parseInt(response.data[index].additionalVacationDay);
//                            }
//                            else if (response.data[index].additionalRemainderVacationDay == '0' && response.data[index].mainRemainderVacationDay == '0') {
//
//                                var totalRemainder = parseInt(response.data[index].mainVacationDay) + parseInt(response.data[index].additionalVacationDay);
//
//                            }
//                            else {
//
//                                var totalRemainder = parseInt(response.data[index].mainRemainderVacationDay) + parseInt(response.data[index].additionalRemainderVacationDay);
//
//                            }
//                            var totalVacation = parseInt(response.data[index].mainVacationDay) + parseInt(response.data[index].additionalVacationDay);
//
//                            if (response.data[index].con == 1) {
//
//                                if (response.data[index].additionalRemainderVacationDay == '0') {
//                                    var elaveMezuniyyetQaliq = '0';
//                                }
//                                else {
//                                    var elaveMezuniyyetQaliq = parseInt(response.data[index].additionalVacationDay) - parseInt(response.data[index].additionalRemainderVacationDay);
//
//                                }
//                            }
//                            else {
//                                var elaveMezuniyyetQaliq = response.data[index].additionalRemainderVacationDay;
//
//                            }
//
//                            if (response.data[index].additionalRemainderVacationDay == '0' && response.data[index].mainReminderVacationDay != '0') {
//
//                                response.data[index].additionalRemainderVacationDay = parseInt(response.data[index].additionalVacationDay);
//                            }
//
//
//                            selectedMaxData = totalRemainder > 0 ? totalRemainder : totalVacation;
//
//                            data = data + '<div class="row">';
//                            data = data + '<div class="mt-15 pull-l pr-0 checkbox-custom checkbox-primary"><input type="checkbox" class="col-md-12 form-control enableIt pl-1 pr-1 ' + klass + '" name="enableIt" rel="' + index + '"><label for="enableIt"></label></div>';
//                            data = data + '<div class="col-md-1 mt-15 pull-l pr-0"><input type="text" class="col-md-12 form-control pl-1 pr-1 vacationWorkPeriodFrom" id="remainingDays" data-name="vacationWorkPeriodFrom[]" value="' + response.data[index].fromDate + '"></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l pr-0"><input type="text" class="col-md-12 form-control pl-1 pr-1 vacationWorkPeriodTo" id="remainingDays" data-name="vacationWorkPeriodTo[]" value="' + response.data[index].toDate + '"></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 mainVacationDayForPerson" data-name="mainVacationDayForPerson[]" data-value="' + response.data[index].mainVacationDay + '" readonly value="' + response.data[index].mainVacationDay + '"></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 currentAdditionalVacation" data-name="currentAdditionalVacation[]" data-value="' + response.data[index].additionalVacationDay + '" required  value="' + response.data[index].additionalVacationDay + '"></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 mainRemainderVacationDay" readonly data-name="mainRemainderVacationDay[]" data-value="' + mainRemainderVacationday + '" readonly value="' + mainRemainderVacationday + '"></div>';
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 currentMainVacation" data-name="currentMainVacation[]" data-value="' + con + '" required value="' + con + '"></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 additionalVacationDay" data-name="additionalVacationDay[]" data-value="' + elaveMezuniyyetQaliq + '"  value="' + elaveMezuniyyetQaliq + '" readonly></div>';
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 additionalRemainderVacationDay" readonly data-name="additionalRemainderVacationDay[]"  data-value="' + response.data[index].additionalRemainderVacationDay + '" value="' + response.data[index].additionalRemainderVacationDay + '"></div>';
////                        data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 totalVacation" data-name="totalVacation[]" data-value="' + selectedMaxData + '" readonly value="' + selectedMaxData + '"></div>';
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 radditionalVacation"  readonly data-name="radditionalVacation[]" data-rel="" value="0"  required rel=""></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 chosenAmount" data-name="chosenAmount[]" data-rel="' + (index + 1) + '" value="0"  max="' + selectedMaxData + '" required disabled rel="' + response.data[index].con + '"></div>';
//
//                            data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2"  value="' + currentVacation + '"  required readonly rel="' + currentVacation + '"></div>';
//                            data = data + '<div><input type="number" class="col-md-8 form-control p-2 rmainVacation" readonly data-name="rmainVacation[]" style="width:73px"></div>';
//
//                            data = data + '</div>';
//
////                                if (index != 0) {
//
//                            chosenData = chosenData + '<div class="row"><div class="col-md-6"><h4>Məzuniyyətin başlama vaxtı:</h4><input type="text" class="col-md-12 form-control mainVacationDate" rel="' + index + '" name="vacationStartDate[]"></div>';
//
//                            chosenData = chosenData + '<div class="col-md-6"><h4>Məzuniyyətin bitmə vaxtı:</h4><input type="text" class=" col-md-12 form-control additionalVacationDate" id="additionalVacation" name="vacationEndDate[]"></div></div>';
//
////                                }
////                        }
//                        });
//
//
//
//                        $('.fillArch').html(data);
//                        $('.fillDates').html(chosenData);
//                        $('.mainVacationDate').datepicker({
//                            orientation: "top",
//                            format: 'dd.mm.yyyy',
//                            autoclose: true,
//                            todayHighlight: true,
//
//                        })
//                    }
//                    else {
//
//                    }
//
//                    $('.fillArch').html(data);
//
//                    that.replaceWith('<input type="hidden" id="hiddenEdit" value="hidden" name="hiddenEdit">');
//                },
//                error: function (err) {
//
//                    throw new Error('Error getting additional days: ' + err);
//
//                }
//            });
//        })

    })

</script>
<script src="{{asset('js/custom/pages/orders/vacation/vacation.js')}}"></script>