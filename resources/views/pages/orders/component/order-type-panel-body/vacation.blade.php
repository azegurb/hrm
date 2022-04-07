@php($uniqid = uniqid())
<script>
    Date.prototype.addDays = function(days) {
        this.setDate(this.getDate() + parseInt(days));
        return this;
    };
</script>
<div class="mt-20" id="vacation">
    <style>
        .fillArch td{
            padding-left: 1px !important;
            padding-right: 1px !important;

        }
    </style>
    <div class="row">
        <div class="col-md-3">
            <h4>Məzuniyyətin tipi:</h4>
            <select name="listVacationTypeId" id="listVacationTypeId" class="form-control select"
                    data-url="{{ route('vacation-types.list') }}">
                @if(isset($array))
                    <option value="{{ $array->listVacationTypeIdId }}"
                            selected>{{ $array->listVacationTypeIdName }}</option>
                @endif
            </select>
            <input type="hidden" id="listVacationTypeIdLabel" name="listVacationTypeIdLabel">
        </div>
        <div class="col-md-3 userList">


        </div>
        <div class="sabbaticalInputs col-md-8 row">
            <div class="col-md-5 sabbaticalLeaveVacation">


            </div>
            <div class="col-md-5 sabbaticalLeaveVacationSecondRoot" style="display: none;">


            </div>
            <div class="col-md-1 sabbaticalLeaveVacationDays">


            </div>
            <div class="col-md-1 listDurationType">


            </div>
            <div class="col-md-2 vacationStart pl-0 pr-5">


            </div>
            <div class="col-md-2 vacationEnd pl-0 pr-0">


            </div>

            <div class="col-md-6 workStartDate">


            </div>
            {{--<div class="col-md-3 sabbaticalLeaveFromPeriod">--}}


            {{--</div>--}}
            {{--<div class="col-md-3 sabbaticalLeaveToPeriod">--}}


            {{--</div>--}}
        </div>

    </div>
    <div class="row">
        <hr class="col-md">

        <div class="col-md-12">

            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-12 vacation-dates">

                        <!-- dynamicly added vacation details -->
                        <div class="row">
                            @php($id = uniqid())

                        </div>
                        <!-- /dynamicly added vacation details -->


                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12 fillvacation">


                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <input type="hidden" name="orderTypeLabel" value="vacation">
            @if(isset($array))
                <input type="hidden" name="orderVacationId" value="{{ $array->orderVacationId }}">
            @endif
            <div class="row">
                <div class="col-12">
                </div>
            </div>
            <div class="row">


            </div>

        </div>

        <div class="col-md-12">

            <div class="row vacationForCollectiveAggrementTable">



            </div>
        </div>

        <div class="col-md-12">

            <div class="row collectiveAggrementTypesTable">



            </div>


        </div>

        <div class="col-md-6 workStartDateDiv">
        </div>



    </div>
</div>

<script>

    $('#btnCloneForm').hide();

    @if(isset($array))

    $('.select').select2({
        placeholder: 'Seçilməyib',
        width: '100%'
    });


    $('#listVacationTypeId').selectObj('listVacationTypeId');

    $('#userInVacationStructureId').selectObj('userInVacationStructureId');

    var url = $('#userInVacationPositionNameId').data('url') + '/' + '{{ $array->structureIdId }}';

    $('#userInVacationPositionNameId').selectObj('userInVacationPositionNameId', false, url);

    var userInVacationUrl = $('#userInVacationId').data('url') + '/' + '{{ $array->posNameIdId }}';

    $('#userInVacationId').selectObj('userInVacationId', false, userInVacationUrl);

    /*
     *
     * When structure is selected pass its id to position names url param
     * and trigger select2
     * */
    $('#userInVacationStructureId').on('select2:select', function () {

        $('#userInVacationPositionNameId').empty('');

        $('#userInVacationId').empty('');

        var url = $('#userInVacationPositionNameId').data('url') + '/' + $(this).val();

        $('#userInVacationPositionNameId').selectObj('userInVacationPositionNameId', false, url);

    });

    /*
     *
     * When position name is chosen pass its id and get employees
     * trigger select2
     * */

    $('#userInVacationPositionNameId').on('select2:select', function () {

        var url = $('#userInVacationId').data('url') + '/' + $(this).val();


        $('#userInVacationId').selectObj('userInVacationId', false, url);

    });

    @else

    $('.select').select2({
        placeholder: 'Seçilməyib',
        width: '100%'
    });

    $(document).ready(function(){

        $('.fillvacation').on('click', '.multi', function () {

            var thatCollective=$(this).parent().parent();
            var relvalue=thatCollective.find('.vacationWorkPeriodFrom').val();

            var collectiveObj=$('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").parent().find("input[rel='"+relvalue+"']").parent().parent().prev();

            var collectiveObjCommons=parseInt(collectiveObj.find('.commonAllWomenDay').val())+parseInt(collectiveObj.find('.commonKvChild142').val())+parseInt(collectiveObj.find('.commonKvChild143').val())+parseInt(collectiveObj.find('.commonChernobylAccident').val());
            var collectiveObjGiven=parseInt(collectiveObj.find('.allWomenDay').val())+parseInt(collectiveObj.find('.kvChild142').val())+parseInt(collectiveObj.find('.kvChild143').val())+parseInt(collectiveObj.find('.chernobylAccident').val());
            var allCollectiveObj=parseInt(collectiveObj.find('.allWomenDay').val())+parseInt(collectiveObj.find('.kvChild142').val())+parseInt(collectiveObj.find('.kvChild143').val())+parseInt(collectiveObj.find('.chernobylAccident').val())+parseInt(collectiveObj.find('.remaindeAllWomenDay').val())+parseInt(collectiveObj.find('.kvRemaindeChild142').val())+parseInt(collectiveObj.find('.kvRemaindeChild143').val())+parseInt(collectiveObj.find('.remaindeChernobylAccidenDay').val());

            if($(this).attr('rel')==1) {

                if ($('.first').is(":checked") && $(this).is(":checked")) {

                    var that=$(this).parent().parent().prev();

                    var chosenVal = $(this).parent().parent().prev().find('.chosenAmount').val()!=''?parseInt($(this).parent().parent().prev().find('.chosenAmount').val()):'0';

                    var totalReminderDay = parseInt(that.find('.mainVacationDayForPerson').val())+parseInt(that.find('.currentAdditionalVacation').val())-parseInt(that.find('.mainRemainderVacationDay').val())-parseInt(that.find('.additionalVacationDay').val())

                    if (chosenVal < totalReminderDay) {

                        swal('Diqqət!', 'Əvvəlki qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');

                        $(this).trigger('click');
                    }

                    else {

                        console.log('collectObjgive:'+collectiveObjGiven);
                        console.log('total reminder:'+totalReminderDay);
                        console.log('collectiveObjCommons'+collectiveObjCommons);
                        if((parseInt(chosenVal)+parseInt(collectiveObjGiven))<(parseInt(totalReminderDay)+parseInt(collectiveObjCommons)) && allCollectiveObj>0){

                            swal('Diqqət!', 'Kollektiv müqaviləyə uyğun qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');

                            $(this).trigger('click');


                        }
                        else {

                            $('.first').parent().parent().find('.chosenAmount').prop("readonly", true);

                        }

                    }

                }
                else if (!$('.first').is(":checked") && $(this).is(":checked")) {

                    swal('Diqqət!', 'Əvvəlki tarixdlərdə seçmədiyiniz məbləğ var!', 'info');

                    $(this).trigger('click');

                }
                else if ($('.first').is(":checked") && !$(this).is(":checked")) {

                    $('.first').parent().parent().find('.chosenAmount').prop("readonly", false);
                }
            }
            else {

                if ($(this).parent().parent().prev().find('.enableIt').is(":checked") && $(this).is(":checked")) {
                    var that=$(this).parent().parent().prev()

                    var chosenVal = $(this).parent().parent().prev().find('.chosenAmount').val()!=''?parseInt($(this).parent().parent().prev().find('.chosenAmount').val()):'0';

                    var totalReminderDay = parseInt(that.find('.mainVacationDayForPerson').val())+parseInt(that.find('.currentAdditionalVacation').val())-parseInt(that.find('.mainRemainderVacationDay').val())-parseInt(that.find('.additionalVacationDay').val())

//                alert($(this).parent().parent().prev().find('.totalVacation').val())
                    if (chosenVal < totalReminderDay) {

                        swal('Diqqət!', 'Əvvəlki qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');

                        $(this).parent().parent().find('.enableIt').trigger('click');
                    }
                    else {

                        console.log('collectObjgive:'+collectiveObjGiven);
                        console.log('total reminder:'+totalReminderDay);
                        console.log('collectiveObjCommons'+collectiveObjCommons);
                        if((parseInt(chosenVal)+parseInt(collectiveObjGiven))<(parseInt(totalReminderDay)+parseInt(collectiveObjCommons))){

                            swal('Diqqət!', 'Kollektiv müqaviləyə uyğun qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');


                            $(this).trigger('click');



                        }
                        else {
                            $(this).parent().parent().prev().find('.chosenAmount').prop("readonly", true);

                        }


                    }

                }
                else if (!$(this).parent().parent().prev().find('.enableIt').is(":checked") && $(this).is(":checked")) {

                    swal('Diqqət!', 'Əvvəlki tarixdlərdə seçmədiyiniz məbləğ var!', 'info');

                    $(this).trigger('click');

                }

                else if ($(this).parent().parent().prev().find('.enableIt').is(":checked") && !$(this).is(":checked")) {

                    $(this).parent().parent().prev().find('.chosenAmount').prop("readonly", false);
                }

            }
        });

        $('.fillvacation').on('changeDate', '.mainVacationDate', function () {

            var rel=parseInt($(this).attr('rel'))+1;


            $('.chosenAmount').each(function () {

                if($(this).attr('data-rel')==rel){

                    $(this).trigger('blur');
                }

            })

        });

        $('.fillvacation').on('blur', '.chosenAmount', function () {

            var totalall=0, relChosen=$(this).attr('data-rel');

            $('.chosenAmount').each(function (element, index) {

                totalall=parseInt(totalall)+parseInt(this.value);

            });
            var that=$(this).parent().parent();
            var relvalue=that.find('.vacationWorkPeriodFrom').val()

            var obj2=$('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").parent().find("input[rel='"+relvalue+"']").parent().parent();

            var t1=0, t2=0, t3=0, t4=0;
            if(obj2.find('.remaindeAllWomenDay').attr('data-value')>0){


                t1=parseInt(obj2.find('.allWomenDay').val())-parseInt(obj2.find('.allWomenDay').attr('data-value'))
            }
            else {

                t1=parseInt(obj2.find('.allWomenDay').val());
            }

            if(obj2.find('.kvRemaindeChild142').attr('data-value')>0){


                t2=parseInt(obj2.find('.kvChild142').val())-parseInt(obj2.find('.kvChild142').attr('data-value'))
            }
            else {

                t2=parseInt(obj2.find('.kvChild142').val());
            }

            if(obj2.find('.kvRemaindeChild143').attr('data-value')>0){

                t3=parseInt(obj2.find('.kvChild143').val())-parseInt(obj2.find('.kvChild143').attr('data-value'))
            }
            else {

                t3=parseInt(obj2.find('.kvChild143').val());
            }

            if(obj2.find('.remaindeChernobylAccidenDay').attr('data-value')>0){

                t4=parseInt(obj2.find('.chernobylAccident').val())-parseInt(obj2.find('.chernobylAccident').attr('data-value'))
            }
            else {

                t4=parseInt(obj2.find('.chernobylAccident').val());
            }


            var summedDays=parseInt(t1)+parseInt(t2)+parseInt(t3)+parseInt(t4);

            if((parseInt($(this).val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))>$(this).parent().parent().find('.mainVacationDayForPerson').val()) {

                var that=$(this).parent().parent();
                var relvalue=that.find('.vacationWorkPeriodFrom').val(), obj=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent();

                var commonExDay=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonExperienceDay').val();
                var commonChild14_2=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonChild14_2').val();
                var commonChild14_3=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonChild14_3').val();
                var commonWorkConditionDay=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonWorkConditionDay').val();

                var experienceDay=0, child14_2=0, child14_3=0, workConditionDay=0, experienceDayReminder=0, child14_2Reminder=0, child14_3Reminder=0, workConditionDayReminder=0;

                console.log(commonExDay+' commonExDay'+$(this).val()+'this value'+$(this).parent().parent().find('.additionalVacationDay').val()+' additionalVacationDay-in valuesi'+$(this).parent().parent().find('.mainRemainderVacationDay').val()+'mainRemainderVacationDay valuse '+$(this).parent().parent().find('.mainVacationDayForPerson').val()+' mainVacationDayForPerson value-si')

                console.log((parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val()));

                var compare=parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val());

                console.log(compare);

                if(compare>parseInt(commonExDay)){

                    experienceDay=commonExDay;
                    experienceDayReminder=parseInt(commonExDay)-experienceDay;

                    if(commonChild14_2>0){
                        console.log(parseInt($(this).val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val()))
                        if((parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=parseInt(commonChild14_2)+parseInt(experienceDay)) {

                            child14_2 = commonChild14_2;
                        }
                        else {
                            child14_2=(parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt(that.find('.mainVacationDayForPerson').val())-parseInt(experienceDay);
                            child14_2Reminder=parseInt(commonChild14_2)-parseInt(child14_2);
                        }
                    }

                    if(commonChild14_3>0){
                        if((parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=parseInt(commonChild14_3)+parseInt(experienceDay)) {

                            child14_3 = commonChild14_3;
                        }
                        else {

                            child14_3=(parseInt($(this).val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt(that.find('.mainVacationDayForPerson').val())-parseInt(experienceDay);
                            child14_3Reminder=parseInt(commonChild14_3)-parseInt(child14_3);
                        }
                    }

                    if(commonWorkConditionDay>0){
                        if((parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=parseInt(child14_2)+parseInt(child14_3)+parseInt(experienceDay)+parseInt(commonWorkConditionDay)) {

                            workConditionDay = commonWorkConditionDay;
                        }
                        else {

                            workConditionDay=parseInt($(this).val())-parseInt(that.find('.mainVacationDayForPerson').val())-parseInt(experienceDay)-parseInt(child14_2)-parseint(child14_3);
                            workConditionDayReminder=parseInt(commonWorkConditionDay)-parseInt(workConditionDay);
                        }
                    }

                    console.log(experienceDay+' experinece day-another')
                }
                else {
                    experienceDay=parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val());
                    experienceDay=experienceDay>0?experienceDay:'0';
                    experienceDayReminder=parseInt(commonExDay)-experienceDay;
                    child14_2Reminder=parseInt(commonChild14_2);
                    child14_3Reminder=parseInt(commonChild14_3);
                    workConditionDayReminder=parseInt(commonWorkConditionDay);

                }

                console.log(commonChild14_2, commonChild14_3, commonWorkConditionDay, commonExDay);
                console.log(experienceDay+' experinece day')
                obj.find('.experienceDay').val(experienceDay);
                obj.find('.child_14_12').val(child14_2);
                obj.find('.child_14_13').val(child14_3);
                obj.find('.workConditionDay').val(workConditionDay);

                obj.find('.remainderExperienceDay').val(experienceDayReminder);
                obj.find('.remainderChild_14_12').val(child14_2Reminder);
                obj.find('.remainderChild_14_13').val(child14_3Reminder);
                obj.find('.remainderWorkConditionDay').val(workConditionDayReminder);
            }
            if($(this).attr('rel')>1){

                if($(this).val()>=$(this).parent().parent().find('.currentMainVacation').data('value')){

                    $(this).parent().parent().find('.rmainVacation').val($(this).parent().parent().find('.currentMainVacation').data('value'))
                    $(this).parent().parent().find('.radditionalVacation').val(parseInt($(this).val())-parseInt($(this).parent().parent().find('.currentMainVacation').data('value')));

                    $(this).parent().parent().find('.mainRemainderVacationDay').val('0');
//                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).parent().parent().find('.currentMainVacation').data('value'));
//                $(this).parent().parent().find('.additionalVacationDay').val(($(this).val()-$(this).parent().parent().find('.currentMainVacation').data('value')))
                    $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value')-$(this).parent().parent().find('.additionalVacationDay').val())

                }
                else {

//                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).val());
//                $(this).parent().parent().find('.mainRemainderVacationDay').val($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).val());
                    $(this).parent().parent().find('.additionalVacationDay').val('0');
                    $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value'))
                    $(this).parent().parent().find('.rmainVacation').val($(this).val())
                    $(this).parent().parent().find('.radditionalVacation').val('0');
                }

            }
            else {

                if($(this).val()>=$(this).parent().parent().find('.currentMainVacation').data('value')){

                    $(this).parent().parent().find('.radditionalVacation').val(parseInt($(this).val())-parseInt($(this).parent().parent().find('.currentMainVacation').data('value')));

                    $(this).parent().parent().find('.rmainVacation').val($(this).parent().parent().find('.currentMainVacation').data('value'))
//                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).parent().parent().find('.mainRemainderVacationDay').data('value'));
//                $(this).parent().parent().find('.mainRemainderVacationDay').val($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).parent().parent().find('.mainVacationDayForPerson').val());

//                $(this).parent().parent().find('.additionalVacationDay').val(Math.abs($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).val()))

//                $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value')-Math.abs($(this).parent().parent().find('.additionalVacationDay').val()))

                }
                else {
//                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).val());
//                $(this).parent().parent().find('.mainRemainderVacationDay').val($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).val());
                    $(this).parent().parent().find('.rmainVacation').val($(this).val())
                    $(this).parent().parent().find('.radditionalVacation').val('0');
                    $(this).parent().parent().find('.additionalVacationDay').val('0');
//                $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value'))

                }


            }
            if([$('.mainVacationDate')[0]][0].value!='' && $(this).attr('data-rel')=='1') {


                var allDaySum1=parseInt($(this).val())+parseInt(summedDays);

                var thisval=$(this).val();
//                alert(summedDays)
                $.ajax({
                    method: 'GET',
                    url: '/orders/calculatevacationday/' + allDaySum1 + '/' + [$('.mainVacationDate')[0]][0].value+'/'+$('#userInVacationId').val(),
                    success: function (response) {

                        if(response.notselected){

                            swal('Diqqət!', response.notselected, 'info');

                        }

                        else if(relChosen==1){

                            $('#additionalVacation').val(response['data'])

                        }

                    },
                    error: function (err) {

                        throw new Error('Error getting vacation days: ' + err);

                    }
                });

            }

            else if([$('.mainVacationDate')[0]][0].value!='' && $(this).attr('data-rel')>1) {

                var dayStart='', that='', val=$(this).val();

                var say=$(this).attr('data-rel')-2;

                $('.additionalVacationDate').each(function (index, val1) {
                    if(index==say){
                        console.log($(this).val())
                        dayStart=$(this).val();
                        var date=new Date()

                    }
                    if(index==parseInt(say)+1){
                        that=$(this)
                    }
                });

                $('.mainVacationDate').each(function (index, val1) {

                    if(index==parseInt(say)+1){

                        var date = new Date(parseInt(dayStart.substring(6), 10),        // Year
                            parseInt(dayStart.substring(3, 5), 10) - 1, // Month (0-11)
                            parseInt(dayStart.substring(0, 2), 10)+1);
                        var newdate = new Date(date);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth()+1;
                        if(dd<10){
                            dd='0'+dd;
                        }
                        if(mm<10){
                            mm='0'+mm;
                        }
                        var changedDate=dd+'.'+mm+'.'+newdate.getFullYear();
                        $(this).val(changedDate)
                    }

                });

                var allDaySum=parseInt(val)+parseInt(summedDays)+1;
                $.ajax({
                    method: 'GET',
                    url: '/orders/calculatevacationday/' + allDaySum+'/' + dayStart+'/'+$('#userInVacationId').val(),
                    success: function (response) {

                        if(response.notselected){

                            swal('Diqqət!', response.notselected, 'info');

                        }
                        else {

                            that.val(response['data'])
                        }


                    },
                    error: function (err) {

                        throw new Error('Error getting vacation days: ' + err);

                    }
                });

            }
            else {

                swal('Diqqət!', 'Məzuniyyətin ilkin başlanğıc tarixini seçin!', 'info');

            }

        });

        $('body').on('change', '#listVacationTypeId', function () {



            $('.fillvacation').html('');
            $('.userList').html('');
            $('#sabbaticalLeaveDays').val('');
            $('#lastPossibleDate').remove();
            $('#lastPossibleDateh4').remove();
            $('.vacationForCollectiveAggrementTable').html('');
            $('.collectiveAggrementTypesTable').html('');

//        alert($(this).select2('data')[0].label);//collective_agreement

            if($(this).select2('data')[0].label=='labor_vacation') {

                $('.sabbaticalInputs').find('div').each(function () {

                    $(this).html('');

                });

                $('#listVacationTypeIdLabel').val('labor_vacation');

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationId" class="form-control select"  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationId').selectObj('userInVacationId', false, url);

                var vacationstr='<table class="table"><thead><tr><td colspan=3 style="width:15%">İş ili dövrü</td>'+
                    '<td style="width:7%">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</td>'+
                    '<td style="width:7%">İşçinin əlavə məzuniyyəti</td>'+
                    '<td style="width:7%">İstifadə etdiyi əsas məzuniyyət günləri</td>'+
                    '<td style="width:7%">Əsas məzuniyyət gününün qalığı</td>'+
                    '<td style="width:7%">İstifadə etdiyi əlavə məzuniyyət günləri</td>'+
                    '<td style="width:7%">Əlavə məzuniyyət gününün qalığı</td>'+
                        {{--<div class="col-md-1 mt-15 pull-l">Cari əlavə məzuniyyət (İşçinin vəzifəsinə uyğun əlavə məzuniyyət günü)</div>--}}
                        {{--<div class="col-md-1 mt-15 pull-l">Cəmi məzuniyyət</div>--}}
                    //                        '<td style="width:90px"><b>Əlavə məzuniyyət</b></td>'+
                    '<td style="width:7%">Ümumi istifadə olunan</td>'+
                    '<td style="width:7%">Cari məzuniyyət</td>'+
                    '<td style="width:7%">İşçinin əlavə məzuniyyəti K/m üzrə</td>'+
                    '<td style="width:7%">K/m üzrə (qalıq)</td>'+
                    '<td style="width:7%">K/m üzrə istifadə etdiyi</td>'+
                    '<td style="width:7%" colspan=2>Məzuniyyət aralığı</td></tr></thead>'+
                    '<tbody class="fillArch"></tbody>';

                $('.fillvacation').html(vacationstr);

                $('.mainVacationDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })

            }

            else if($(this).select2('data')[0].label=='sabbatical_leave' || $(this).select2('data')[0].label=='paid_social_vacation' || $(this).select2('data')[0].label=='paid_educational_vacation' || $(this).select2('data')[0].label=='partialpaid_social_vacation'){

                $('#listVacationTypeIdLabel').val('sabbatical_leave');

                $('.sabbaticalInputs').find('div').each(function () {

                    $(this).html('');
                });

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationIdY" class="form-control select "  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationIdY').selectObj('userInVacationIdY', false, url);

                var url2 = '/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select=root&';

                $('.sabbaticalLeaveVacation').html('<h4>Əlavə məzuniyyət tipləri:</h4><select id="sabbaticalLeave" name="sabbaticalLeaveName" class="form-control select" data-url="'+url2+'"></select>');

                $('#sabbaticalLeave').selectObj('sabbaticalLeave', false, url2);

                $('#sabbaticalLeave').on('select2:select', function () {

                    var id=$(this).select2('data')[0].id;

                    $('.sabbaticalLeaveVacationSecondRoot').html('<h4>Əlavə məzuniyyət alt tiplər:</h4><select id="sabbaticalLeaveSecond" name="sabbaticalLeaveName" class="form-control select" data-url="/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select='+id+'"></select>');
                    var url3 = "/orders/get-sabbatical-leave-search/"+$('#listVacationTypeId').val()+"/?select="+id;
                    $('#sabbaticalLeaveSecond').selectObj('sabbaticalLeaveSecond', false, url3);
                });


            }

            else if($(this).select2('data')[0].label=='nonpaid_vacation'){

                $('#listVacationTypeIdLabel').val('nonpaid_vacation');

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationIdY" class="form-control select "  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationIdY').selectObj('userInVacationIdY', false, url);

                var url2 = '/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select=root&';
                $('.sabbaticalInputs').find('div').each(function () {

                    $(this).html('');
                });

                $('.sabbaticalLeaveVacationDays').html('<h4>Günlər:</h4><input type="text" id="sabbaticalLeaveDays" class="form-control select pl-2 pr-0" name="vacationDay">')

                $('.vacationStart').html('<h4>Başlama vaxtı:</h4><input type="text" class="col-md-12 form-control" name="vacationStartDate" id="sabbaticalVacationStartDate">');
                $('.vacationEnd').html('<h4>Bitmə vaxtı:</h4><div id="vacationEndDate"><input type="text" class="col-md-12 form-control" name="vacationEndDate" id="sabbaticalVacationEndDate"></div>');
                $('.sabbaticalLeaveVacation').html('<h4>Işə başlama vaxtı:</h4><div id="workStartDate"><input type="text" class="col-md-8 form-control startDate" name="workStartDate"></div>')

                $('#sabbaticalVacationStartDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })
                $('#sabbaticalVacationEndDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })
                $('.startDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })
                $('#sabbaticalVacationStartDate ').datepicker({
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
            }

            else if($(this).select2('data')[0].label=='collective_agreement'){

                $('#listVacationTypeIdLabel').val('collective_agreement');

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationIdY" class="form-control select "  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationIdY').selectObj('userInVacationIdY', false, url);

                var url2 = '/orders/get-sabbatical-leave-search/'+$('#listVacationTypeId').val()+'/?select=root&';
                $('.sabbaticalInputs').find('div').each(function () {

                    $(this).html('');
                });

                $('.sabbaticalLeaveVacationDays').html('<h4>Günlər:</h4><input type="text" id="sabbaticalLeaveDays" class="form-control select pl-2 pr-0" name="vacationDay">')

                $('.vacationStart').html('<h4>Başlama vaxtı:</h4><input type="text" class="col-md-12 form-control" name="vacationStartDate" id="sabbaticalVacationStartDate">');
                $('.vacationEnd').html('<h4>Bitmə vaxtı:</h4><div id="vacationEndDate"><input type="text" class="col-md-12 form-control" name="vacationEndDate" id="sabbaticalVacationEndDate"></div>');
                $('.sabbaticalLeaveVacation').html('<h4>Işə başlama vaxtı:</h4><div id="workStartDate"><input type="text" class="col-md-8 form-control startDate" name="workStartDate"></div>')

                $('#sabbaticalVacationStartDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })
                $('#sabbaticalVacationEndDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })
                $('.startDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })
                $('#sabbaticalVacationStartDate ').datepicker({
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
            }

        });

        $('body').on('change', '#userInVacationIdY', function () {

            $('#sabbaticalLeave').val('');
            $('#sabbaticalLeaveDays').val('');

            $('#lastPossibleDateInput').val('');

        });

        $('body').on('change', '#sabbaticalLeave', function () {

            $('.sabbaticalLeaveVacationDays').html('<h4>Günlər:</h4><input type="text" id="sabbaticalLeaveDays" class="form-control select pl-2 pr-0" name="vacationDay">');

            $('.listDurationType').html('<div  style="margin-top: 35px"><div id="durationType"></div><input type="hidden" name="durationTypeHidden" id="durationTypeHidden"></div>');

            $('.vacationStart').html('<h4>Başlama vaxtı:</h4><div  id="vacationStartDate"><input type="text" class="col-md-12 form-control" name="vacationStartDate" id="sabbaticalVacationStartDate"></div>');

            $('.vacationEnd').html('<h4>Bitmə vaxtı:</h4><div  id="vacationEndDate"><input type="text" class="col-md-12 form-control" name="vacationEndDate" id="sabbaticalVacationEndDate"></div>');

            if($(this).select2('data')[0].vacationTypeId=='partialpaid_social_vacation'){

                $('.workStartDate').html('<div style="float:left; margin-right: 20px" id="lastPossibleDate"><h4 id="lastPossibleDateh4">Məzuniyyət üçün son tarix:</h4><div><input type="text" class="form-control lastPossibleDate" id="lastPossibleDateInput" name="lastPossibleDate"></div></div><div style="float:left"><h4>Işə başlama vaxtı:</h4><div  id="workStartDate"><input type="text" class="col-md-8 form-control startDate" name="workStartDate"></div></div>');

                $.ajax({
                    method: 'GET',
                    url: '/orders/partialpaid-social-vacation/' + $('#userInVacationIdY').val(),
                    async:false,
                    success: function (response) {

                        $('.lastPossibleDate').val(response);
                    },
                    error: function (err) {

                        throw new Error('Error getting vacation days: ' + err);

                    }
                });



            }
            else {
                $('.workStartDate').html('<h4>Işə başlama vaxtı:</h4><div  id="workStartDate"><input type="text" class="col-md-8 form-control startDate" name="workStartDate"></div>');


            }

//        $('.sabbaticalLeaveFromPeriod').html('<h4>İlkin dövr:</h4><div  id="sabbaticalLeaveFromPeriod"><input type="text" class="col-md-12 form-control LeaveFromPeriod" name="sabbaticalLeaveFromPeriod"></div>');
//
//        $('.sabbaticalLeaveToPeriod').html('<h4>Son dövr:</h4><div  id="sabbaticalLeaveToPeriod"><input type="text" class="col-md-12 form-control LeaveToPeriod" name="sabbaticalLeaveToPeriod"></div>');

            var val=$(this).val(), userId=$('#userInVacationIdY').val();

            var selectStr='';
            $.ajax({
                method: 'GET',
                url: '/orders/get-sabbatical-child-count/' + val,
                success: function (response) {


                    if(response.data[0]){


//                   alert('child lari var');
                        $('.sabbaticalLeaveVacationSecondRoot').show();

                    }
                    else {

                        $('.sabbaticalLeaveVacationSecondRoot').hide();
                        $('.sabbaticalLeaveVacationSecondRoot').html('');
//                   $('.sabbaticalLeaveVacationSecondRoot').find('#sabbaticalLeaveSecond').attr('disabled');
                        $.ajax({
                            method: 'GET',
                            url: '/orders/get-sabbatical-vacation-days/' + val+'/'+userId,
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

            $('#sabbaticalVacationStartDate ').datepicker({
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
            $('.startDate').datepicker({
                orientation: "top",
                format: 'dd.mm.yyyy',
                autoclose: true,
                todayHighlight: true,

            });

        });

        $('body').on('change', '#userInVacationId', function () {

            var options='', additionalDays='<h4>Əlavə məzuniyyət növləri:</h4>';
            var periodArray=[];
            var userId=$(this).val();
            var tableStr='', tableHead='<table class="table"><thead><tr><td colspan="14"><h3>Əmək qanunvericiliyinə uyğun əlavə məzuniyyət günləri</h3></td></tr><tr>' +
                '<td></td>' +
                '<td style="width:7%">Başlanğıc dövr</td>' +
                '<td style="width:7%">Son dövr</td>' +
                '<td>İş stajına görə düşən (ümumi)</td>' +
                '<td>İş stajına görə istifadə</td>' +
                '<td>İş stajına görə qalıq</td>' +
                '<td>İş şəraitinə görə düşən (ümumi)</td>' +
                '<td>İş şəraitinə görə istifadə</td>' +
                '<td>İş şəraitinə görə qalıq</td>' +
                '<td>14 yaşına qədər 2 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 2 uşağı olan (istifadə)</td>' +
                '<td>14 yaşına qədər 2 uşağı olan (qalıq)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (istifadə)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (qalıq)</td>' +
                '</tr></thead>', tableBody='<tbody>';
            var tableCollectiveHead='<table class="table"><thead><tr><td colspan="14"><h3>Kollektiv müqaviləyə uyğun əlavə məzuniyyət günləri</h3></td></tr><tr>' +
                '<td></td>' +
                '<td style="width:7%">Başlanğıc dövr</td>' +
                '<td style="width:7%">Son dövr</td>' +
                '<td>Bütün qadınlara (ümumi)</td>' +
                '<td>Bütün qadınlara (istifadə)</td>' +
                '<td>Bütün qadınlara (qalıq)</td>' +
                '<td>14 yaşına qədər 2 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 2 uşağı olan (istifadə)</td>' +
                '<td>14 yaşına qədər 2 uşağı olan (qalıq)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (istifadə)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (qalıq)</td>' +
                '<td>Çernobıl əlilləri üçün (ümumi)</td>' +
                '<td>Çernobıl əlilləri üçün (istifadə)</td>' +
                '<td>Çernobıl əlilləri üçün (qalıq)</td>' +

                '</tr></thead>', tableBodyCollective='<tbody>';
            $.ajax({
                method: 'GET',
                url: '/orders/getarch/'+ $(this).val(),
                async:false,
                success: function (response) {

                    /* response code is OK */

                    var data='', klass='', hiddenForKm='', selectedMaxData='', con='', currentAdditionalVacation, chosenData='', currentVacation='', mainRemainderVacationday='';

                    if (response.code == 200)
                    {
                        response.data.forEach(function (element, index) {

                            klass = index > 0 ? 'multi' : 'first';

//                        if(response.data[index].months>=6) {
//                        con = response.data[index].con == 1?response.data[index].mainRemainderVacationDay!='0'?parseInt(response.data[index].mainVacationDay)-parseInt(response.data[index].mainRemainderVacationDay) : '0':response.data[index].mainVacationDay;
                            if(response.data[index].con == 1){

                                if(response.data[index].mainRemainderVacationDay!='0' || response.data[index].additionalRemainderVacationDay!='0' || response.data[index].remaindeAllWomenDay!='0' || response.data[index].remaindeChernobylAccidenDay!='0' || response.data[index].kvRemaindeChild142!='0' || response.data[index].kvRemaindeChild143!='0'){

                                    con=parseInt(response.data[index].mainRemainderVacationDay);
                                }
                                else {

                                    con=response.data[index].mainVacationDay;
                                }
                            }
                            else {

                                con=response.data[index].mainVacationDay;
                            }

                            currentAdditionalVacation = response.data[index].con == 1 ? response.data[index].additionalRemainderVacationDay : response.data[index].additionalVacationDay;
                            currentVacation= response.data[index].con == 1 ?response.data[index].additionalRemainderVacationDay: (con/12)*response.data[index].months.toFixed(2);
                            if(response.data[index].con == 1){
                                if(response.data[index].mainRemainderVacationDay!='0' || response.data[index].additionalRemainderVacationDay!='0' || response.data[index].remaindeAllWomenDay!='0' || response.data[index].remaindeChernobylAccidenDay!='0' || response.data[index].kvRemaindeChild142!='0' || response.data[index].kvRemaindeChild143!='0'){

                                    mainRemainderVacationday=parseInt(response.data[index].mainVacationDay)-parseInt(response.data[index].mainRemainderVacationDay);

                                }
                                else {
//                                mainRemainderVacationday='0';

                                    mainRemainderVacationday=parseInt(response.data[index].mainRemainderVacationDay);

                                }
                            }
                            else {
                                mainRemainderVacationday='0';
                            }

                            if(response.data[index].additionalRemainderVacationDay=='0' && response.data[index].mainRemainderVacationDay!='0'){

                                var totalRemainder =parseInt(response.data[index].mainRemainderVacationDay) +parseInt(response.data[index].additionalVacationDay);
                            }
                            else if(response.data[index].additionalRemainderVacationDay!='0' && response.data[index].mainRemainderVacationDay=='0'){

                                var totalRemainder =parseInt(response.data[index].mainRemainderVacationDay) +parseInt(response.data[index].additionalRemainderVacationDay);
                            }
                            else if(response.data[index].additionalRemainderVacationDay=='0' && response.data[index].mainRemainderVacationDay=='0' && response.data[index].remaindeAllWomenDay=='0' && response.data[index].kvRemaindeChild143=='0' && response.data[index].kvRemaindeChild142=='0' && response.data[index].remaindeChernobylAccidenDay=='0'){

                                var totalRemainder = parseInt(response.data[index].mainVacationDay) + parseInt(response.data[index].additionalVacationDay);

                            }

                            else {

                                var totalRemainder=parseInt(response.data[index].mainRemainderVacationDay) + parseInt(response.data[index].additionalRemainderVacationDay);
                                if(response.data[index].remaindeAllWomenDay>0){

                                    var totalRemainder = parseInt(response.data[index].mainRemainderVacationDay) + parseInt(response.data[index].additionalRemainderVacationDay)+parseInt(response.data[index].remaindeAllWomenDay);

                                }
                                if(response.data[index].kvRemaindeChild142>0){

                                    var totalRemainder = totalRemainder+(parseInt(response.data[index].kvChild142)-parseInt(response.data[index].kvRemaindeChild142));

                                }
                                if(response.data[index].kvRemaindeChild143>0){

                                    var totalRemainder = totalRemainder+(parseInt(response.data[index].kvChild143)-parseInt(response.data[index].kvRemaindeChild143));

                                }
                                if(response.data[index].remaindeChernobylAccidenDay>0){

                                    var totalRemainder = totalRemainder+(parseInt(response.data[index].chernobylAccidenDay)-parseInt(response.data[index].remaindeChernobylAccidenDay));

                                }

                            }

                            var totalVacation = parseInt(response.data[index].mainVacationDay) + parseInt(response.data[index].additionalVacationDay);

                            if(response.data[index].con == 1){

                                if(parseInt(response.data[index].mainRemainderVacationDay)>0){
                                    var elaveMezuniyyetQaliq='0';
                                    console.log(elaveMezuniyyetQaliq+' Elave mezuniyyetin qaliqi---')
                                }
                                else {
                                    var elaveMezuniyyetQaliq=parseInt(response.data[index].additionalVacationDay)-parseInt(response.data[index].additionalRemainderVacationDay);

                                }
                            }
                            else {
                                var elaveMezuniyyetQaliq=response.data[index].additionalRemainderVacationDay;

                            }
                            var allWomanDay=0;
                            if(response.data[index].allWomenDay!=null){
                                allWomanDay=parseInt(response.data[index].allWomenDay)-parseInt(response.data[index].remaindeAllWomenDay);
                            }

                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && (response.data[index].remaindeAllWomenDay=='0' && response.data[index].kvRemaindeChild142=='0' && response.data[index].kvRemaindeChild143=='0' && response.data[index].remaindeChernobylAccidenDay=='0')){

                                allWomanDay='0';
                            }

                            var child142=parseInt(response.data[index].kvChild142)-parseInt(response.data[index].kvRemaindeChild142);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && (response.data[index].remaindeAllWomenDay=='0' && response.data[index].kvRemaindeChild142=='0' && response.data[index].kvRemaindeChild143=='0' && response.data[index].remaindeChernobylAccidenDay=='0')){

                                child142='0';
                            }

                            var child143=parseInt(response.data[index].kvChild143)-parseInt(response.data[index].kvRemaindeChild143);

                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && (response.data[index].remaindeAllWomenDay=='0' && response.data[index].kvRemaindeChild142=='0' && response.data[index].kvRemaindeChild143=='0' && response.data[index].remaindeChernobylAccidenDay=='0')){

                                child143='0';
                            }

                            var chernobylAccident=parseInt(response.data[index].chernobylAccidenDay)-parseInt(response.data[index].remaindeChernobylAccidenDay);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && (response.data[index].remaindeAllWomenDay=='0' && response.data[index].kvRemaindeChild142=='0' && response.data[index].kvRemaindeChild143=='0' && response.data[index].remaindeChernobylAccidenDay=='0')){

                                chernobylAccident='0';
                            }

                            if(response.data[index].con != '1' && response.data[index].additionalRemainderVacationDay=='0' && (response.data[index].mainRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay=='0') && (parseInt(response.data[index].kvRemaindeChild142)+parseInt(response.data[index].kvRemaindeChild143)+parseInt(response.data[index].remaindeAllWomenDay)+parseInt(response.data[index].remaindeChernobylAccidenDay))=='0'){

                                response.data[index].additionalRemainderVacationDay=parseInt(response.data[index].additionalVacationDay);
                            }


                            if(response.data[index].additionalRemainderVacationDay=='0' && response.data[index].mainRemainderVacationDay=='0' && (response.data[index].remaindeAllWomenDay!='0' || response.data[index].kvRemaindeChild143!='0' || response.data[index].kvRemaindeChild142!='0' || response.data[index].remaindeChernobylAccidenDay!='0')){

                                hiddenForKm ='<input type="text" name="hiddenForKm" value="editkm">';
                            }
                            else {

                                hiddenForKm='';
                            }

                            selectedMaxData = totalRemainder > 0 ? totalRemainder : totalVacation;

                            periodArray.push({fdate:response.data[index].fromDate, tdate:response.data[index].toDate});
                            var commonExperienceDay=parseInt(response.data[index].experienceDay);
                            var commonChild14_2=parseInt(response.data[index].child_14_12);
                            var commonChild14_3=parseInt(response.data[index].child_14_13);
                            var commonWorkConditionDay=parseInt(response.data[index].workConditionDay);
                            if(response.data[index].con==1){
                                var experienceDayVal=parseInt(response.data[index].experienceDay)-parseInt(response.data[index].remainderExperienceDay);

                                var reminderExperienceDay=response.data[index].remainderExperienceDay;
                            }
                            else {
                                var reminderExperienceDay=response.data[index].experienceDay;

                                var experienceDayVal='0';
                            }

                            var child_14_12Val=parseInt(response.data[index].child_14_12)-parseInt(response.data[index].remainderChild_14_12);
                            var child_14_13Val=parseInt(response.data[index].child_14_13)-parseInt(response.data[index].remainderChild_14_13);
                            var workConditionDayVal=parseInt(response.data[index].workConditionDay)-parseInt(response.data[index].remainderWorkConditionDay);
                            tableBody=tableBody+'<tr>' +
                                '<td><input type="checkbox" class="fromDateCheck" rel="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 fromDate form-control p-2 pl-0" readonly value="'+response.data[index].fromDate+'" name="workPeriodFromAdd[]"></td>' +
                                '<td><input type="text" class="col-md-12 toDate form-control p-2 pl-0 pr-0" readonly value="'+response.data[index].toDate+'" name="workPeriodToAdd[]"></td>' +
                                '<td><input type="number" class="commonExperienceDay col-md-12 form-control p-2" readonly value="'+commonExperienceDay+'" readonly name="totalExperienceDay[]"></td>' +
                                '<td><input type="number" class="experienceDay col-md-12 form-control p-2" readonly value="'+experienceDayVal+'" name="experienceDay[]"></td>' +
                                '<td><input type="number" class="remainderExperienceDay col-md-12 form-control p-2" readonly value="'+reminderExperienceDay+'" name="remaindeExperienceDay[]"></td>' +
                                '<td><input type="number" class="commonWorkConditionDay col-md-12 form-control p-2" readonyl value="'+commonWorkConditionDay+'" readonly name="totalWorkConditionDay[]"></td>' +
                                '<td><input type="number" class="workConditionDay col-md-12 form-control p-2" readonly value="'+workConditionDayVal+'" name="workConditionDay[]"></td>' +
                                '<td><input type="number" class="remainderWorkConditionDay col-md-12 form-control p-2" readonly value="'+response.data[index].remainderWorkConditionDay+'" name="remaindeWorkConditionDay[]"></td>' +
                                '<td><input type="number" class="commonChild14_2 col-md-12 form-control p-2" readonly value="'+commonChild14_2+'" readonly name="totalChild142[]"></td>' +
                                '<td><input type="number" class="child_14_12 col-md-12 form-control p-2" readonly value="'+child_14_12Val+'" name="child142[]"></td>' +
                                '<td><input type="number" class="remainderChild_14_12 col-md-12 form-control p-2" readonly value="'+response.data[index].remainderChild_14_12+'" name="remaindeChild142[]"></td>' +
                                '<td><input type="number" class="commonChild14_3 col-md-12 form-control p-2" readonly value="'+commonChild14_3+'" readonly name="totalChild143[]"></td>' +
                                '<td><input type="number" class="child_14_13 col-md-12 form-control p-2" readonly value="'+child_14_13Val+'" name="child143[]"></td>' +
                                '<td><input type="number" class="remainderChild_14_13 col-md-12 form-control p-2" readonly value="'+response.data[index].remainderChild_14_13+'" name="remaindeChild143[]"></td>' +

                                '</tr>';
                            var commonAllWomenDay='0'
                            if(response.data[index].allWomenDay!=null){
                                commonAllWomenDay=parseInt(response.data[index].allWomenDay);
                            }

                            var commonKvChild142=parseInt(response.data[index].kvChild142);
                            var commonKvChild143=parseInt(response.data[index].kvChild143);
                            var commonChernobylAccident=parseInt(response.data[index].chernobylAccidenDay);
                            var allKm=commonAllWomenDay+commonKvChild142+commonKvChild143+commonChernobylAccident;
                            var allKmReminder=parseInt(response.data[index].remaindeChernobylAccidenDay)+parseInt(response.data[index].remaindeAllWomenDay)+parseInt(response.data[index].kvRemaindeChild142)+parseInt(response.data[index].kvRemaindeChild143);

                            var allKmUsed=0;

                            var readOnly='';

                            if(index!='0'){

                                readOnly='readonly'
                            }

                            if(parseInt(response.data[index].remaindeAllWomenDay)>0){

                                allKmUsed=allKmUsed+parseInt(response.data[index].allWomenDay)-parseInt(response.data[index].remaindeAllWomenDay);
                            }
                            if(parseInt(response.data[index].kvRemaindeChild142)>0){
                                allKmUsed=allKmUsed+parseInt(response.data[index].kvChild142)-parseInt(response.data[index].kvRemaindeChild142);
                            }
                            if(parseInt(response.data[index].kvRemaindeChild143)>0){
                                allKmUsed=allKmUsed+parseInt(response.data[index].kvChild143)-parseInt(response.data[index].kvRemaindeChild143);

                            }
                            if(parseInt(response.data[index].remaindeChernobylAccidenDay)>0){
                                allKmUsed=allKmUsed+parseInt(response.data[index].chernobylAccidenDay)-parseInt(response.data[index].remaindeChernobylAccidenDay);

                            }

                            tableBodyCollective=tableBodyCollective+'<tr>' +
                                '<td><input type="checkbox" style="display:none" class="fromDateCheckCollective" readonly data-rel="'+index+'" rel="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 fromDateCollective form-control p-2 pl-0" readonly  value="'+response.data[index].fromDate+'" name="workPeriodFromAddCollective[]"></td>' +
                                '<td><input type="text" class="col-md-12 toDateCollective form-control p-2 pl-0" readonly  value="'+response.data[index].toDate+'" name="workPeriodToAddCollective[]"></td>'+
                                '<td><input type="number" class="commonAllWomenDay col-md-12 form-control p-2" name="commonAllWomenDay[]" value="'+commonAllWomenDay+'" readonly></td>' +
                                '<td><input type="number" max="'+commonAllWomenDay+'" min="0" name="allwomenDay[]" readonly  class="col-md-12 allWomenDay form-control p-2 pl-0" rel="'+allWomanDay+'" data-value="'+allWomanDay+'" value="'+allWomanDay+'"></td>' +
                                '<td><input type="number" max="'+commonAllWomenDay+'" min="0" name="remaindeAllWomenDay[]" readonly class="col-md-12 remaindeAllWomenDay form-control p-2" rel="'+response.data[index].remaindeAllWomenDay+'" data-value="'+response.data[index].remaindeAllWomenDay+'" value="'+response.data[index].remaindeAllWomenDay+'"></td>' +
                                '<td><input type="number" class="commonKvChild142 col-md-12 form-control p-2" name="commonKvChild142[]" value="'+commonKvChild142+'" readonly></td>' +
                                '<td><input type="number" max="'+commonKvChild142+'" name="kvChild142[]" readonly min="0"class="col-md-12 kvChild142 form-control p-2" rel="'+child142+'" data-value="'+child142+'" value="'+child142+'"></td>' +
                                '<td><input type="number" max="'+commonKvChild142+'" min="0" name="kvRemaindeChild142[]" readonly class="col-md-12 kvRemaindeChild142 form-control p-2" rel="'+response.data[index].kvRemaindeChild142+'" data-value="'+response.data[index].kvRemaindeChild142+'" value="'+response.data[index].kvRemaindeChild142+'"></td>' +
                                '<td><input type="number" class="commonKvChild143 col-md-12 form-control p-2" name="commonKvChild143[]" value="'+commonKvChild143+'" readonly></td>' +
                                '<td><input type="number"  max="'+commonKvChild143+'" name="kvChild143[]" readonly min="0" class="col-md-12 kvChild143 form-control p-2" rel="'+child143+'" data-value="'+child143+'" value="'+child143+'"></td>' +
                                '<td><input type="number" max="'+commonKvChild143+'" min="0" name="kvRemaindeChild143[]" readonly class="col-md-12 kvRemaindeChild143 form-control p-2" rel="'+response.data[index].kvRemaindeChild143+'" data-value="'+response.data[index].kvRemaindeChild143+'" value="'+response.data[index].kvRemaindeChild143+'"></td>' +
                                '<td><input type="number" class="commonChernobylAccident col-md-12 form-control p-2" name="commonChernobylAccident[]" value="'+commonChernobylAccident+'" readonly></td>' +
                                '<td><input type="number" max="'+commonChernobylAccident+'" name="chernobylAccident[]" readonly  min="0" class="col-md-12 chernobylAccident form-control p-2" data-value="'+chernobylAccident+'" rel="'+chernobylAccident+'" value="'+chernobylAccident+'"></td>' +
                                '<td><input type="number" max="'+commonChernobylAccident+'" name="remaindeChernobylAccidenDay[]" readonly min="0" class="col-md-12 remaindeChernobylAccidenDay form-control p-2" rel="'+response.data[index].remaindeChernobylAccidenDay+'" data-value="'+response.data[index].remaindeChernobylAccidenDay+'" value="'+response.data[index].remaindeChernobylAccidenDay+'"></td>' +

                                '</tr>';
                            data = data + '<tr>';
                            data = data + '<td style="padding-left: 0px;padding-right: 0px;"><input type="checkbox" class="enableIt pl-1 pr-1 ' + klass + '" value="' + response.data[index].id + '" name="enableIt[]" rel="' + index + '"></td>';
                            data = data + '<td style="width:70px;padding-left: 0px;padding-right: 0px;"><input type="text" style="width:70px" class="col-md-12 form-control pl-0 pr-0 vacationWorkPeriodFrom" id="remainingDays" data-name="vacationWorkPeriodFrom[]" value="' + response.data[index].fromDate + '"></td>';

                            data = data + '<td style="width:70px;"><input type="text" style="width:70px" class="col-md-12 form-control pl-0 pr-0 vacationWorkPeriodTo" id="remainingDays" data-name="vacationWorkPeriodTo[]" value="' + response.data[index].toDate + '"></td>';

                            data = data + '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 mainVacationDayForPerson" data-name="mainVacationDayForPerson[]" data-value="' + response.data[index].mainVacationDay + '" readonly value="' + response.data[index].mainVacationDay + '"></td>';

                            data = data + '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 currentAdditionalVacation" data-name="currentAdditionalVacation[]" data-value="' + response.data[index].additionalVacationDay + '" required readonly value="' + response.data[index].additionalVacationDay + '"></td>';

                            data = data + '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 mainRemainderVacationDay" readonly data-name="mainRemainderVacationDay[]" data-value="' + mainRemainderVacationday + '" readonly value="' + mainRemainderVacationday+ '"></td>';
                            data = data + '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 currentMainVacation" readonly data-name="currentMainVacation[]" data-value="' + con + '" required value="' + con + '"></td>';

                            data = data + '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 additionalVacationDay" data-name="additionalVacationDay[]" data-value="' + elaveMezuniyyetQaliq + '"  value="' + elaveMezuniyyetQaliq + '" readonly></td>';
                            data = data + '<td><input type="number" class="col-md-12 form-control p-2 additionalRemainderVacationDay" readonly data-name="additionalRemainderVacationDay[]"  data-value="' + response.data[index].additionalRemainderVacationDay + '" value="' + response.data[index].additionalRemainderVacationDay + '"></td>';
//                        data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 totalVacation" data-name="totalVacation[]" data-value="' + selectedMaxData + '" readonly value="' + selectedMaxData + '"></div>';
                            data = data + '<td style="display:none" class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 radditionalVacation"  readonly data-name="radditionalVacation[]" data-rel="" value="0"  required rel=""></td>';

                            data = data + '<td><input type="number" class="col-md-12 form-control p-2 chosenAmount" data-name="chosenAmount[]" data-rel="' + (index + 1) + '" value="0" min="0" max="' + selectedMaxData + '" required disabled rel="' + (index + 1) + '"></td>';

                            data = data + '<td><input type="number" class="col-md-12 form-control p-2"  value="'+currentVacation+'"  required disabled rel="' + currentVacation + '"></td>';
                            data = data + '<td><input type="number" class="col-md-12 kmVacation form-control p-2"  value="'+allKm+'" readonly></td>';

                            data = data + '<td><input type="number" class="col-md-12 kmReminderVacation form-control p-2"  value="'+allKmReminder+'" readonly></td>';
                            data = data + '<td><input type="number" class="col-md-12 kmUsedVacation form-control p-2"  value="'+allKmUsed+'" readonly></td>';
                            if(readOnly==''){
                                data=data+'<td style="width:70px"><input type="text" rel="'+index+'" class="col-md-12 form-control p-2 pl-0 pr-0 mainVacationDate" id="startD" name="vacationStartDate[]" '+readOnly+'></td>';
                            }
                            else {

                                data=data+'<td style="width:70px"><input type="text" rel="'+index+'" class="col-md-12 form-control p-2 pl-0 pr-0 mainVacationDate" name="vacationStartDate[]" '+readOnly+'></td>';
                            }

                            data =data+   '<td><input type="text" rel="'+index+'" class="col-md-12 pl-0 pr-0 form-control p-2 additionalVacationDate" id="additionalVacation" name="vacationEndDate[]" readonly style="width:70px"></td>';
                            data = data + '<td style="display:none">'+hiddenForKm+'<input type="number" class="col-md-8 form-control p-2  rmainVacation" readonly data-name="rmainVacation[]" style="width:73px"></td>';
                            data = data + '<td style="display:none"><input type="number" class="col-md-8 form-control p-2" readonly style="width:73px"></td>';
                            data = data + '</tr>';

//                        if (index != 0) {

                            chosenData = chosenData + '<div class="row"><div class="col-md-4 row"><div class="col-md-6"><input type="text" class="col-md-12 form-control pl-1 pr-1 mt-35" readonly value="' + response.data[index].fromDate + '"></div><div class="col-md-6"><input type="text" class="col-md-12 form-control pl-1 pr-1 mt-35" readonly value="' + response.data[index].toDate + '"></div></div><div class="col-md-4"><h4>Məzuniyyətin başlama vaxtı:</h4><input type="text" class="col-md-12 form-control mainVacationDate" rel="'+index+'" name="vacationStartDate[]"></div>';

                            chosenData = chosenData + '<div class="col-md-4"><h4>Məzuniyyətin bitmə vaxtı:</h4><input type="text" class=" col-md-12 form-control additionalVacationDate" id="additionalVacation" name="vacationEndDate[]"></div></div>';

//                        }
//                        }

                        });

                        $('.fillArch').html(data+'<input type="hidden" id="hiddenEdit" value="hidden" name="hiddenEdit">');
                        $('.fillDates').html(chosenData);

                        $('#startD').datepicker({
                            orientation: "top",
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            todayHighlight: true,

                        });

                        var tableCollectiveAggrement='<table class="table"><tr><td colspan="2">Kollektiv müqaviləyə uyğun əlavə məzuniyyət növləri</td><td>Gün sayı</td></tr>';


                        $('.vacationForCollectiveAggrementTable').html(tableHead+tableBody+'</tbody></table>');


                        $('.collectiveAggrementTypes').html(tableCollectiveAggrement);

                        $('.collectiveAggrementTypesTable').html(tableCollectiveHead+tableBodyCollective+'</tbody></table><h4 class="ml-25 mr-25">İşə başlama tarixi:</h4><div id="workStartDate"><input type="text" class="col-md-8 form-control startDate" name="wsDate"></div>');

                        $('#workStartDate>input').datepicker({
                            orientation: "top",
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            todayHighlight: true,

                        });
                    }

                },
                error: function (err) {

                    throw new Error('Error getting vacation days: ' + err);

                }
            });


        });

        $('body').on('click', '.periodCheck', function(){

            var that=this;

            $(this).parent().parent().parent().find('.periodCheck').each(function(){

                if(that!=this){
                    $(this).attr('checked', false);
                    $(this).parent().parent().find('.periodValue').val('0')
                    $(this).parent().parent().find('.periodValue').removeAttr('name');
                }

            });

            if(this.checked==true){

                var val=0;

                $('.collectiveVac').each(function(){

                    if(this.checked==true){

                        val=parseInt(val)+parseInt($(this).parent().parent().find('.collectiveVacD').val());

                    }

                });
                $(this).parent().parent().find('.periodFromDate').attr('name', 'periodFromDate');
                $(this).parent().parent().find('.periodToDate').attr('name', 'periodToDate');
                $(this).parent().parent().find('.periodValue').attr('name', 'periodValue');
                $(this).parent().parent().find('.periodValue').val(val);
            }
            else {
                $(this).parent().parent().find('.periodToDate').removeAttr('name');
                $(this).parent().parent().find('.periodFromDate').removeAttr('name');
                $(this).parent().parent().find('.periodValue').val('0');
                $(this).parent().parent().find('.periodValue').removeAttr('name');
            }

        });

        $('body').on('change', '.kvChild142', function(){

            var inputVal=parseInt($(this).parent().parent().find('.kvRemaindeChild142').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.kvRemaindeChild142').val(inputVal)

        });

        $('body').on('change', '.kvRemaindeChild142', function(){

            var inputVal=parseInt($(this).parent().parent().find('.kvChild142').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.kvChild142').val(inputVal)

        });

        $('.collectiveAggrementTypesTable').on('change', '.allWomenDay', function(){

            var inputVal=parseInt($(this).parent().parent().find('.remaindeAllWomenDay').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.remaindeAllWomenDay').val(inputVal);
            var rel=$(this).parent().parent().find('.fromDateCheckCollective').attr('data-rel');
            $('.fillvacation').find('.chosenAmount').each(function(){

                if(parseInt($(this).attr('rel'))-1==parseInt(rel)){

                    $(this).trigger('blur');
                }

            });

        });

        $('body').on('change', '.remaindeAllWomenDay', function(){

            var inputVal=parseInt($(this).parent().parent().find('.allWomenDay').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.allWomenDay').val(inputVal)

        });

        $('body').on('change', '.kvChild143', function(){

            var inputVal=parseInt($(this).parent().parent().find('.kvRemaindeChild143').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.kvRemaindeChild143').val(inputVal)

        });
        $('body').on('change', '.kvRemaindeChild143', function(){

            var inputVal=parseInt($(this).parent().parent().find('.kvChild143').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.kvChild143').val(inputVal)

        });

        $('body').on('change', '.chernobylAccident', function(){

            var inputVal=parseInt($(this).parent().parent().find('.remaindeChernobylAccidenDay').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.remaindeChernobylAccidenDay').val(inputVal)

        });

        $('body').on('change', '.remaindeChernobylAccidenDay', function(){

            var inputVal=parseInt($(this).parent().parent().find('.сhernobylAccidenDay').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.сhernobylAccidenDay').val(inputVal)

        });

        function contains(arr, element) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] === element) {
                    return true;
                }
            }
            return false;
        }

        $('body').on('click', '.fromDateCheck', function () {

            if(this.checked==true) {
                $(this).parent().parent().find('.fromDate').attr('name', 'workPeriodFromAdd[]');

                $(this).parent().parent().find('.toDate').attr('name', 'workPeriodToAdd[]');

                $(this).parent().parent().find('.experienceDay').attr('name', 'experienceDay[]');

                $(this).parent().parent().find('.child_14_12').attr('name', 'child142[]');

                $(this).parent().parent().find('.child_14_13').attr('name', 'child143[]');

                $(this).parent().parent().find('.workConditionDay').attr('name', 'workConditionDay[]');

                $(this).parent().parent().find('.remainderExperienceDay').attr('name', 'remaindeExperienceDay[]');

                $(this).parent().parent().find('.remainderChild_14_12').attr('name', 'remaindeChild142[]');

                $(this).parent().parent().find('.remainderChild_14_13').attr('name', 'remaindeChild143[]');

                $(this).parent().parent().find('.remainderWorkConditionDay').attr('name', 'remaindeWorkConditionDay[]');

                $(this).parent().parent().find('.commonExperienceDay').attr('name', 'totalExperienceDay[]');

                $(this).parent().parent().find('.commonChild14_2').attr('name', 'totalChild142[]');

                $(this).parent().parent().find('.commonChild14_3').attr('name', 'totalChild143[]');

                $(this).parent().parent().find('.commonWorkConditionDay').attr('name', 'totalWorkConditionDay[]');
            }
            else {

                $(this).parent().parent().find('.fromDate').removeAttr('name');

                $(this).parent().parent().find('.toDate').removeAttr('name');

                $(this).parent().parent().find('.experienceDay').removeAttr('name');

                $(this).parent().parent().find('.child_14_12').removeAttr('name');

                $(this).parent().parent().find('.child_14_13').removeAttr('name');

                $(this).parent().parent().find('.workConditionDay').removeAttr('name');

                $(this).parent().parent().find('.remainderExperienceDay').removeAttr('name');

                $(this).parent().parent().find('.remainderChild_14_12').removeAttr('name');

                $(this).parent().parent().find('.remainderChild_14_13').removeAttr('name');

                $(this).parent().parent().find('.remainderWorkConditionDay').removeAttr('name');

                $(this).parent().parent().find('.commonExperienceDay').removeAttr('name');

                $(this).parent().parent().find('.commonChild14_2').removeAttr('name');

                $(this).parent().parent().find('.commonChild14_3').removeAttr('name');

                $(this).parent().parent().find('.commonWorkConditionDay').removeAttr('name');


            }
        });

        $('body').on('click', '.fromDateCheckCollective', function () {

            var allReminder='0';

            if($(this).parent().parent().prev()){
                var parentObj=$(this).parent().parent().prev();

                var relValue=parentObj.find('.fromDateCollective').val();
                var relCurrentVal=$(this).attr('rel');

                var firstTableReminderObj=$(".vacationWorkPeriodFrom").parent().parent().find("input[value='"+relValue+"']").parent().parent();

                var currentObject=$(".vacationWorkPeriodFrom").parent().parent().find("input[value='"+relCurrentVal+"']").parent().parent();

                console.log($(".vacationWorkPeriodFrom").parent().parent().find("input[value='"+relCurrentVal+"']").val());

//                    alert(relCurrentVal)
                var allFirstTableReminder=parseInt(firstTableReminderObj.find('.mainVacationDayForPerson').val())+parseInt(firstTableReminderObj.find('.currentAdditionalVacation').val())-parseInt(firstTableReminderObj.find('.chosenAmount').val())-parseInt(firstTableReminderObj.find('.mainRemainderVacationDay').val())-parseInt(firstTableReminderObj.find('.additionalVacationDay').val());

                allReminder=allFirstTableReminder+parseInt(allFirstTableReminder)+parseInt(parentObj.find('.kvRemaindeChild142').val())+parseInt(parentObj.find('.kvRemaindeChild143').val())+parseInt(parentObj.find('.remaindeChernobylAccidenDay').val())+parseInt(parentObj.find('.remaindeAllWomenDay').val())

            }

            if(this.checked==true) {

                var relvalue=$(this).attr('data-rel');

                if(relvalue>0) {
                    relvalue=parseInt(relvalue)-1;
                    var obj=$(this).parent().parent().parent().find("input[data-rel='" + relvalue + "']").parent().parent();
                    obj.find('.allWomenDay').prop("readonly", true);
                    obj.find('.kvChild142').prop("readonly", true);
                    obj.find('.kvChild143').prop("readonly", true);
                    obj.find('.chernobylAccident').prop("readonly", true);
                    obj.find('.remaindeAllWomenDay').prop("readonly", true);
                    obj.find('.kvRemaindeChild142').prop("readonly", true);
                    obj.find('.kvRemaindeChild143').prop("readonly", true);
                    obj.find('.remaindeChernobylAccidenDay').prop("readonly", true);
                }

//                alert($(".vacationWorkPeriodFrom").parent().parent().find("input[value='"+relCurrentVal+"']").val())
                if(!$(".vacationWorkPeriodFrom").parent().parent().find("input[value='"+relCurrentVal+"']").parent().parent().find('.enableIt').is(":checked")){

                    swal('Diqqət!', 'Seçim etmək olmaz!', 'info');
                    $(this).trigger('click')
                }
                if((allReminder>0 && $(this).attr('data-rel')>0)){
                    swal('Diqqət!', 'Əvvəlki qalıq silinməmiş yeni sətirə keçmək olmaz!', 'info');

                    $(this).trigger('click');

                }
                $(this).parent().parent().find('.fromDateCollective').attr('name', 'workPeriodFromAddCollective[]');

                $(this).parent().parent().find('.toDateCollective').attr('name', 'workPeriodToAddCollective[]');

                $(this).parent().parent().find('.allWomenDay').attr('name', 'allWomenDay[]');

                $(this).parent().parent().find('.kvChild142').attr('name', 'kvChild142[]');

                $(this).parent().parent().find('.kvChild143').attr('name', 'kvChild143[]');

                $(this).parent().parent().find('.chernobylAccident').attr('name', 'chernobylAccident[]');

                $(this).parent().parent().find('.remaindeAllWomenDay').attr('name', 'remaindeAllWomenDay[]');

                $(this).parent().parent().find('.kvRemaindeChild142').attr('name', 'kvRemaindeChild142[]');

                $(this).parent().parent().find('.kvRemaindeChild143').attr('name', 'kvRemaindeChild143[]');

                $(this).parent().parent().find('.remaindeChernobylAccidenDay').attr('name', 'remaindeChernobylAccidenDay[]');

                $(this).parent().parent().find('.commonAllWomenDay').attr('name', 'commonAllWomenDay[]');

                $(this).parent().parent().find('.commonKvChild142').attr('name', 'commonKvChild142[]');

                $(this).parent().parent().find('.commonKvChild143').attr('name', 'commonKvChild143[]');

                $(this).parent().parent().find('.commonChernobylAccident').attr('name', 'commonChernobylAccident[]');
            }
            else {

                var relvalue=$(this).attr('data-rel');

                if(relvalue>0) {
                    relvalue=parseInt(relvalue)-1;
                    var obj=$(this).parent().parent().parent().find("input[data-rel='" + relvalue + "']").parent().parent();
                    obj.find('.allWomenDay').prop("readonly", false);
                    obj.find('.kvChild142').prop("readonly", false);
                    obj.find('.kvChild143').prop("readonly", false);
                    obj.find('.chernobylAccident').prop("readonly", false);
                    obj.find('.remaindeAllWomenDay').prop("readonly", false);
                    obj.find('.kvRemaindeChild142').prop("readonly", false);
                    obj.find('.kvRemaindeChild143').prop("readonly", false);
                    obj.find('.remaindeChernobylAccidenDay').prop("readonly", false);
                }

                $(this).parent().parent().find('.fromDateCollective').removeAttr('name');

                $(this).parent().parent().find('.toDateCollective').removeAttr('name');

                $(this).parent().parent().find('.allWomenDay').removeAttr('name');

                $(this).parent().parent().find('.kvChild142').removeAttr('name');

                $(this).parent().parent().find('.kvChild143').removeAttr('name');

                $(this).parent().parent().find('.chernobylAccident').removeAttr('name');

                $(this).parent().parent().find('.remaindeAllWomenDay').removeAttr('name');

                $(this).parent().parent().find('.kvRemaindeChild142').removeAttr('name');

                $(this).parent().parent().find('.kvRemaindeChild143').removeAttr('name');

                $(this).parent().parent().find('.remaindeChernobylAccidenDay').removeAttr('name');

                $(this).parent().parent().find('.commonAllWomenDay').removeAttr('name');

                $(this).parent().parent().find('.commonChild142').removeAttr('name');

                $(this).parent().parent().find('.commonChild143').removeAttr('name');

                $(this).parent().parent().find('.commonChernobylAccidenDay').removeAttr('name');


            }


        });

        $('body').on('click', '.collectiveVac', function(){

            var periodArray=[], that=$(this), errorFlag=false, errorFlagForPeriod=false;

            $('.periodFromDate').each(function(){

                periodArray.push($(this).val());

            });

            if(this.checked==true) {

                $('.vacationWorkPeriodFrom').each(function(){

                    if($(this).parent().parent().find('.enableIt').is(":checked") && contains(periodArray, $(this).val())){
                        errorFlag=false;
                        return false;

                    }
                    else {
                        errorFlag=true
                    }

                });



                if(errorFlag){
                    that.trigger('click');
                    swal('Diqqət!', 'Bunun üçün cari period seçilməlidir!', 'info');

                }
                else {

                    $('.periodCheck').each(function(){

                        if($(this).is(":checked")){
                            errorFlagForPeriod=false;
                            return false;

                        }
                        else {
                            errorFlagForPeriod=true
                        }

                    });

                    if(errorFlagForPeriod){
                        that.trigger('click');
                        swal('Diqqət!', 'Xahiş olunur məzuniyyətin aid olduğu dövrü seçəsiniz!', 'info');

                    }
                }

                $(this).parent().parent().find('input[type=text]').attr('name', 'collectiveVacDay[]');

                if ($('.periodCheck:checkbox:checked')){

                    var val=0;

                    $('.collectiveVac').each(function(){

                        if(this.checked==true){

                            val=parseInt(val)+parseInt($(this).parent().parent().find('.collectiveVacD').val());

                        }

                    });

                    $('.periodCheck:checkbox:checked').parent().parent().find('.periodValue').val(val);

                }

            }
            else {

                $(this).parent().parent().find('input[type=text]').removeAttr('name');

                if ($('.periodCheck:checkbox:checked')) {
                    var oldvalue = parseInt($('.periodCheck:checkbox:checked').parent().parent().find('.periodValue').val()) - parseInt($(this).parent().parent().find('.collectiveVacD').val());
                    $('.periodCheck:checkbox:checked').parent().parent().find('.periodValue').val(oldvalue);
                }

            }

        });

        $('body').on('click', '.enableIt', function () {

            var that=$(this).parent().parent();

            var periodArray=[], errorFlag=false;

            $('.periodFromDate').each(function(){

                periodArray.push($(this).val());

            });

            var checkBoxRel=$(this).attr('rel');

            var obj=this;

            var relvalue=that.find('.vacationWorkPeriodFrom').val();

            $('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").each(function(){

                if($(this).attr('data-rel')==checkBoxRel && obj.checked==true){

                    $(this).parent().parent().find('.allWomenDay').prop('readonly', false);
                    $(this).parent().parent().find('.kvChild142').prop('readonly', false);
                    $(this).parent().parent().find('.kvChild143').prop('readonly', false);
                    $(this).parent().parent().find('.chernobylAccident').prop('readonly', false);
                    $(this).parent().parent().find('.remaindeAllWomenDay').prop('readonly', false);
                    $(this).parent().parent().find('.kvRemaindeChild142').prop('readonly', false);
                    $(this).parent().parent().find('.kvRemaindeChild143').prop('readonly', false);
                    $(this).parent().parent().find('.remaindeChernobylAccidenDay').prop('readonly', false);

                }
                else {
                    ;
                    $(this).parent().parent().find('.allWomenDay').prop('readonly', true);
                    $(this).parent().parent().find('.kvChild142').prop('readonly', true);
                    $(this).parent().parent().find('.kvChild143').prop('readonly', true);
                    $(this).parent().parent().find('.chernobylAccident').prop('readonly', true);
                    $(this).parent().parent().find('.remaindeAllWomenDay').prop('readonly', true);
                    $(this).parent().parent().find('.kvRemaindeChild142').prop('readonly', true);
                    $(this).parent().parent().find('.kvRemaindeChild143').prop('readonly', true);
                    $(this).parent().parent().find('.remaindeChernobylAccidenDay').prop('readonly', true);

                }

            });

            $('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").parent().find("input[rel='"+relvalue+"']").trigger('click');


            if(this.checked==true){

                that.find('.vacationWorkPeriodFrom').attr('name', that.find('.vacationWorkPeriodFrom').attr('data-name'))

                that.find('.vacationWorkPeriodTo').attr('name', $(this).parent().parent().find('.vacationWorkPeriodTo').attr('data-name'))

                that.find('.mainVacationDayForPerson').attr('name', that.find('.mainVacationDayForPerson').attr('data-name'))

                that.find('.mainRemainderVacationDay').attr('name', that.find('.mainRemainderVacationDay').attr('data-name'))

                that.find('.additionalVacationDay').attr('name', that.find('.additionalVacationDay').attr('data-name'))

                that.find('.additionalRemainderVacationDay').attr('name', that.find('.additionalRemainderVacationDay').attr('data-name'))

                that.find('.totalVacation').attr('name', that.find('.totalVacation').attr('data-name'))

                that.find('.chosenAmount').attr('name', that.find('.chosenAmount').attr('data-name'))

                that.find('.currentMainVacation').attr('name', that.find('.currentMainVacation').attr('data-name'))

                that.find('.currentAdditionalVacation').attr('name', that.find('.currentAdditionalVacation').attr('data-name'))

                that.find('.chosenAmount').attr('name', that.find('.chosenAmount').attr('data-name'));

                that.find('.chosenAmount').attr('name', that.find('.chosenAmount').attr('data-name'));

                that.find('.radditionalVacation').attr('name', that.find('.radditionalVacation').attr('data-name'));

                that.find('.rmainVacation').attr('name', that.find('.rmainVacation').attr('data-name'));

                if(that.next().find('.enableIt').prop('checked')==true){

                    swal('Diqqət!', 'Sonrakı tarixlərdən seçimi ləğv edin!', 'info');

//                $(this).trigger('click');
                }
                else {

                    that.find('.chosenAmount').removeAttr('disabled');
                }

            }
            else {


                var foundRel=$(this).attr('rel');


                $('.mainVacationDate').each(function () {

                    if($(this).attr('rel')==foundRel){

                        $(this).val('');

                        that.find('.additionalVacationDate').val('');
                    }

                });

                that.find('.vacationWorkPeriodFrom').removeAttr('name');

                that.find('.vacationWorkPeriodTo').removeAttr('name')

                that.find('.mainVacationDayForPerson').removeAttr('name')

                that.find('.mainRemainderVacationDay').removeAttr('name')

                that.find('.additionalVacationDay').removeAttr('name')

                that.find('.additionalRemainderVacationDay').removeAttr('name')

                that.find('.totalVacation').removeAttr('name')

                that.find('.chosenAmount').removeAttr('name')

                that.find('.currentMainVacation').removeAttr('name')

                that.find('.currentAdditionalVacation').removeAttr('name')

                that.find('.chosenAmount').removeAttr('name');

                that.find('.radditionalVacation').removeAttr('name');
                that.find('.rmainVacation').removeAttr('name');

                if(that.next().find('.enableIt').prop('checked')==true){

                    $(this).trigger('click');

                }
                else {

                    that.find('.mainVacationDayForPerson').val(that.find('.mainVacationDayForPerson').attr('data-value'))

                    that.find('.mainRemainderVacationDay').val(that.find('.mainRemainderVacationDay').attr('data-value'))

                    that.find('.additionalVacationDay').val(that.find('.additionalVacationDay').attr('data-value'))

                    that.find('.additionalRemainderVacationDay').val(that.find('.additionalRemainderVacationDay').attr('data-value'))

                    that.find('.totalVacation').val(that.find('.totalVacation').attr('data-value'))

                    that.find('.chosenAmount').val('0')

                    that.find('.currentMainVacation').val(that.find('.currentMainVacation').attr('data-value'))

                    that.find('.currentAdditionalVacation').val(that.find('.currentAdditionalVacation').attr('data-value'))

                    that.find('.chosenAmount').attr('disabled', 'true');
                }

            }

//                $('.enableIt').unbind('click');
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

            $('#userInVacationId').empty('');

            var url = $('#userInVacationPositionNameId').data('url') + '/' + $(this).val();


            $('#userInVacationPositionNameId').selectObj('userInVacationPositionNameId', false, url);

        });

        /*
         *
         * When position name is chosen pass its id and get employees
         * trigger select2
         * */


        /*
         $('#userInVacationPositionNameId').on('select2:select', function () {

         var url = $('#userInVacationId').data('url') + '/' + $(this).val();

         $('#userInVacationId').selectObj('userInVacationId', false, url);

         var url = $('#userInVacationId').data('url') + '/' + $(this).val();

         });
         /*
         Azer commented it
         */

        $('#userInVacationId').selectObj('userInVacationId', false, url);

        var url = $('#userInVacationId').data('url');

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
            let user = $('#userInVacationId').val();
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
//            $(this).trigger('click');////
//        }

        });


    })


</script>
<script src="{{asset('js/custom/pages/orders/vacation/vacation.js')}}"></script>