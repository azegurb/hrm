@php($uniqid = uniqid())
<?php

//dd($objwhole);
?>
<style>
    .fillArch td, .fillArch table td{
        padding-left: 1px !important;
        padding-right: 1px !important;

    }

</style>
<div class="mt-20" id="vacation">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="orderTypeLabel" value="vacation">
            @if(isset($array))
                <input type="hidden" name="orderVacationId" value="{{ $array->orderVacationId }}">
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="alert dark alert-alt alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php
                        //                        dd($objwhole->enable);
                        if($objwhole->enable==true){

                        $enableMessage='Bu əmr redaktə edilə bilər';
                        ?>
                        <script>

                            $(document).ready(function(){

                                $('#ordersModal_form').find(':submit').removeAttr('disabled');

                            })

                        </script>
                        <?php
                        }
                        else {
                        $enableMessage='Bu əmr redaktə edilə bilməz';
                        ?>
                        <script>

                            $(document).ready(function(){

                                $('.clearVacation').remove();
                                $('#ordersModal_form').find(':submit').prop('disabled', true);

                            })

                        </script>

                        <?php

                        }
                        ?>
                        {{ $message or 'Bu bölmə təmir edilir. ' }}
                        {{$enableMessage}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h4>Məzuniyyətin tipi: (edit)</h4>
                    <select name="listVacationTypeId" id="listVacationTypeId" class="form-control select"
                            data-url="{{ route('vacation-types.list') }}">
                        @if(isset($array))
                            <option value="{{ $array->listVacationTypeIdId }}"
                                    selected>{{ $array->listVacationTypeIdName }}</option>
                        @endif
                    </select>
                </div>
                {{--<div class="col-md-2">--}}
                {{--<h4>Struktur:</h4>--}}
                {{--<select id="userInVacationStructureId" name="userInVacationStructureId" class="form-control select"--}}
                {{--data-url="{{ route('structures.list') }}">--}}
                {{--@if(isset($array))--}}
                {{--<option value="{{ $array->structureIdId }}" selected>{{ $array->structureIdName }}</option>--}}
                {{--@endif--}}
                {{--</select>--}}
                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                {{--<h4>Vəzifə:</h4>--}}
                {{--<select id="userInVacationPositionNameId" name="positionId" class="form-control select"--}}
                {{--data-url="{{ route('position-names.list') }}">--}}
                {{--@if(isset($array))--}}
                {{--<option value="{{ $array->posNameIdId }}" selected>{{ $array->posNameIdName}}</option>--}}
                {{--@endif--}}
                {{--</select>--}}
                {{--</div>--}}
                <?php
                $period_array=[];

                $footer_str='<table class="table"><thead><tr><td colspan=3 style="width:220px">İş ili dövrü</td>';
                $footer_str.='<td style="width:85px">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</td>';
                $footer_str.='<td style="width:90px">İşçinin əlavə məzuniyyəti</td>';
                $footer_str.='<td style="width:90px">istifadə etdiyi əsas məzuniyyət günləri</td>';
                $footer_str.='<td style="width:90px">Əsas məzuniyyət gününün qalığı</td>';
                $footer_str.='<td style="width:90px">Istifadə etdiyi əlavə məzuniyyət günləri</td>';
                $footer_str.='<td style="width:90px">Əlavə məzuniyyət gününün qalığı</td>';
                $footer_str.='<td style="width:80px">Ümumi istifadə olunan</td>';
                $footer_str.='<td style="width:80px">Cari məzuniyyət</td>';
                $footer_str.='<td style="width:85px">İşçinin əlavə məzuniyyəti K/m üzrə</td>';
                $footer_str.='<td style="width:80px">K/m üzrə (qaliq)</td>';
                $footer_str.='<td style="width:80px">K/m üzrə istifadə etdiyi</td>';
                $footer_str.='<td colspan=2>Məzuniyyət aralığı<input type="hidden" value="temizle" class="clearVacation" name="sil"><input type="button" class="btn btn-default clearVacation" value="Təmizlə" name="temizle" id="'.$objwhole->ordercommonid.'" rel="'.$array->userIdId.'"></td></tr></thead>';

                //                $footer_str='<div class="row ml-15">';
                //                $footer_str.='<div class="col-md-2 mt-15 pull-l">İş ili dövrü</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">İşçinin əlavə məzuniyyəti</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">istifadə etdiyi əsas məzuniyyət günləri</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">Əsas məzuniyyət gününün qalığı</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">Istifadə etdiyi əlavə məzuniyyət günləri</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">Əlavə məzuniyyət gününün qalığı</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l"><b>Əlavə məzuniyyət</b></div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">Ümumi istifadə olunan</div>';
                //                $footer_str.='<div class="col-md-1 mt-15 pull-l">Cari məzuniyyət</div>';
                //                $footer_str.='<div><input type="hidden" value="temizle" class="clearVacation" name="sil"><input type="button" class="btn btn-default clearVacation" value="Təmizlə" name="temizle" id="'.$objwhole->ordercommonid.'" rel="'.$array->userIdId.'"></div>';
                //                $footer_str.='</div>';

                foreach($objwhole->vacation->data as $period_one){

                    if(count($period_array)=='0'){

                        $period_array[$period_one->vacationWorkPeriodFrom]=[];
                        $period_array[$period_one->vacationWorkPeriodFrom][]=$period_one->totalVacationDay;
                    }
                    else {
                        foreach ($period_array as $key=>$val){

                            if($key!=$period_one->vacationWorkPeriodFrom){

                                $period_array[$period_one->vacationWorkPeriodFrom]=[];
                                $period_array[$period_one->vacationWorkPeriodFrom][]=$period_one->totalVacationDay;
                            }
                            else {
                                $period_array[$period_one->vacationWorkPeriodFrom][]=$period_one->totalVacationDay;

                            }
                        }
                    }
                }


                $footer_str.='<tbody class="fillArchInner">';

                foreach($objwhole->vacation->data as $period){

                    $periodDay=$period->totalAdditionVacationDay==null?"0":$period->totalAdditionVacationDay;
//                    dd($period);
                    if(isset($period->usedVacationDayForSamePeriod)){


                        $mainRemainderVacationDay=abs($period->totalMainVacationDay-$period->mainVacationDay-$period->usedVacationDayForSamePeriod);
                    }
                    else {
//                        dd('az');
                        $mainRemainderVacationDay=abs($period->totalMainVacationDay-$period->mainVacationDay);
                    }

                    if($period->totalVacationDay>$period->totalMainVacationDay){


                    }
                    $additionalVacation=$period->totalAdditionVacationDay-$period->additionRemainderVacationDay;

                    $reminderMainVacation=$period->totalMainVacationDay-$mainRemainderVacationDay;
                    $vacationReminder=$period->totalVacationDay;

                    //     if()

                    $footer_str.='<tr>';
                    $footer_str.='<td style="padding-left: 0px;padding-right: 0px;"></td>';
                    $footer_str.='<td style="width:70px;padding-left: 0px;padding-right: 0px;"><input type="hidden" value="'.$period->id.'" name="hiddenDetail[]"><input type="text" style="width:70px" class="col-md-12 form-control pl-0 pr-0 vacationWorkPeriodFrom" id="remainingDays" data-name="vacationWorkPeriodFrom[]" name="vacationWorkPeriodFrom[]" value="'.$period->vacationWorkPeriodFrom.'"></td>';

                    $footer_str.='<td style="width:70px;"><input type="text" style="width:70px" class="col-md-12 form-control pl-0 pr-0 vacationWorkPeriodTo" id="remainingDays" data-name="vacationWorkPeriodTo[]" name="vacationWorkPeriodTo[]" value="'.$period->vacationWorkPeriodTo.'"></td>';

                    $footer_str.='<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 mainVacationDayForPerson" data-name="mainVacationDayForPerson[]" name="mainVacationDayForPerson[]" data-value="'.$period->totalMainVacationDay.'" readonly value="'.$period->totalMainVacationDay.'"></td>';

                    $footer_str.='<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 currentAdditionalVacation" data-name="currentAdditionalVacation[]" name="currentAdditionalVacation[]" data-value="'.$period->totalAdditionVacationDay.'" required readonly value="'.$period->totalAdditionVacationDay.'"></td>';

                    $footer_str.='<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 mainRemainderVacationDay" readonly data-name="mainRemainderVacationDay[]" name="mainRemainderVacationDay[]" data-value="'.$period->mainVacationDay.'" readonly value="'.$period->mainVacationDay.'"></td>';
                    $footer_str.='<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 currentMainVacation" data-name="currentMainVacation[]" name="currentMainVacation[]" data-value="'.$period->mainRemainderVacationDay.'" required value="'.$period->mainRemainderVacationDay.'" readonly></td>';

                    $footer_str.='<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 additionalVacationDay" data-name="additionalVacationDay[]" name="additionalVacationDay[]" data-value="'.$period->additionVacationDay.'"  value="'.$period->additionVacationDay.'" readonly></td>';
                    $footer_str.='<td><input type="number" class="col-md-12 form-control p-2 additionalRemainderVacationDay" readonly data-name="additionalRemainderVacationDay[]"  name="additionalRemainderVacationDay[]" data-value="'.$period->additionRemainderVacationDay.'" value="'.$period->additionRemainderVacationDay.'"></td>';
//                        data = data + '<div class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 totalVacation" data-name="totalVacation[]" data-value="' + selectedMaxData + '" readonly value="' + selectedMaxData + '"></div>';
                    $footer_str.= '<td style="display:none" class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 radditionalVacation"  value="'.$period->additionRemainderVacationDay.'" readonly data-name="radditionalVacation[]" name="radditionalVacation[]" data-rel="" value="0"  required rel=""></td>';

                    $footer_str.= '<td><input type="number" class="col-md-12 form-control p-2 chosenAmount" data-name="chosenAmount[]" name="chosenAmount[]" min="0" data-rel="" data-value="'.$period->totalVacationDay.'" value="'.$period->totalVacationDay.'"  max="" required disabled rel=""></td>';

                    $footer_str.= '<td><input type="number" class="col-md-12 form-control p-2"  value=""  required disabled rel=""></td>';
                    $footer_str.= '<td><input type="number" class="col-md-12 kmVacation form-control p-2"  readonly value=""></td>';

                    $footer_str.= '<td><input type="number" class="col-md-12 kmReminderVacation form-control p-2"  readonly value=""></td>';
                    $footer_str.= '<td><input type="number" class="col-md-12 kmUsedVacation form-control p-2"  readonly value=""></td>';
                    $footer_str.= '<td style="width:70px"><input type="text" rel="" class="col-md-12 form-control p-2 pl-0 pr-0 mainVacationDate" name="vacationStartDate[]" style="width:70px" value="'.$period->startDate.'"></td>';
                    $footer_str.= '<td><input type="text" rel="" class="col-md-12 pl-0 pr-0 form-control p-2 additionalVacationDate" id="additionalVacation" name="vacationEndDate[]" style="float:right;width:70px" value="'.$period->endDate.'"></td>';
                    $footer_str.='<td style="display:none"><input type="number" class="col-md-8 form-control p-2  rmainVacation" readonly data-name="rmainVacation[]" style="width:73px"></td>';

                    $footer_str.='</tr>';


                }

                $footer_str.='</tbody></table>';
                ?>
                <?php
                //                    dd($objwhole->vacation->data);
                ?>
                <div class="col-md-9 row vacationTypes">

                    <div class="col-md-3"><h4>Əməkdaş:</h4>

                        <input type="hidden" id="userOldId" value="{{ $array->userIdId }}" data-value="{{$footer_str}}">
                        <select name="userId" id="userInVacationIdL" class="form-control select userInVacationIdL"  data-url="{{ route('users', 'select') }}"> @if(isset($array)) <option value="{{ $array->userIdId }}" selected>{{ $array->userIdLastName }} {{ $array->userIdFirstName }}</option> @endif  </select>
                    </div>




                </div>


            </div>
        </div>


        <div class="col-md-12">

            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-12 vacation-dates">

                        <div class="row">
                            @php($id = uniqid())

                        </div>
                        <!-- /dynamicly added vacation details -->


                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12 fillvacation">
                        {{--<div class="row ml-15"> <div class="col-md-2 mt-15 pull-l">İş ili dövrü</div><div class="col-md-1 mt-15 pull-l">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</div><div class="col-md-1 mt-15 pull-l">İşçinin əlavə məzuniyyəti</div><div class="col-md-1 mt-15 pull-l">istifadə etdiyi əsas məzuniyyət günləri</div><div class="col-md-1 mt-15 pull-l">Əsas məzuniyyət gününün qalığı</div><div class="col-md-1 mt-15 pull-l">Istifadə etdiyi əlavə məzuniyyət günləri</div><div class="col-md-1 mt-15 pull-l">Əlavə məzuniyyət gününün qalığı</div><div class="col-md-1 mt-15 pull-l"><b>Əlavə məzuniyyət</b></div><div class="col-md-1 mt-15 pull-l">Ümumi istifadə olunan</div><div class="col-md-1 mt-15 pull-l">Cari məzuniyyət</div><div class="col-md-1 mt-15 pull-l"><b>(əsas m)</b></div></div>--}}
                        {{--<div class="fillArch">--}}
                        <?php

                        $period_array=[];

                        foreach($objwhole->vacation->data as $period_one){

                        if(count($period_array)=='0'){

                        $period_array[$period_one->vacationWorkPeriodFrom]=[];
                        $period_array[$period_one->vacationWorkPeriodFrom][]=$period_one->totalVacationDay;
                        }
                        else {
                        foreach ($period_array as $key=>$val){

                        if($key!=$period_one->vacationWorkPeriodFrom){

                        $period_array[$period_one->vacationWorkPeriodFrom]=[];
                        $period_array[$period_one->vacationWorkPeriodFrom][]=$period_one->totalVacationDay;
                        }
                        else {
                        $period_array[$period_one->vacationWorkPeriodFrom][]=$period_one->totalVacationDay;

                        }
                        }
                        }
                        }

                        ?>

                        {!! $footer_str !!}

                        <?php

                        //                                dd($objwhole->vacation->data, $period_array);
                        ?>

                        {{--</div>--}}
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 row ml-0 pl-0 mr-0 pr-0">

                    <div class="col-md-8">
                        <?php
                        //                        dd($objwhole)   ;
                        ?>
                        {{--<div class="fillDates">--}}

                        {{--@foreach($objwhole->vacation->data as $period)--}}

                        {{--<div class="row">--}}
                        {{--<div class="col-md-2">--}}
                        {{--<input type="text" readonly class="col-md-12 mt-35 form-control pl-1 pr-1 vacationWorkPeriodFrom valid" value="{{$period->vacationWorkPeriodTo}}" aria-invalid="false">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-2">--}}
                        {{--<input type="text" readonly class="col-md-12 mt-35 form-control pl-1 pr-1 vacationWorkPeriodTo valid"  value="{{$period->vacationWorkPeriodFrom}}" aria-invalid="false">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4"><h4>Məzuniyyətin başlama vaxtı:</h4><input type="text" class="col-md-12 form-control mainVacationDate" rel="1" name="vacationStartDate[]" readonly value="{{$period->startDate}}"></div>--}}
                        {{--<div class="col-md-4"><h4>Məzuniyyətin bitmə vaxtı:</h4><input type="text" class="col-md-12 form-control additionalVacationDate" readonly id="additionalVacation" name="vacationEndDate[]" value="{{$period->endDate}}"></div>--}}
                        {{--</div>--}}
                        {{--@endforeach--}}


                        {{--</div>--}}
                    </div>
                    <div class="col-md-4 fillAdditionalVacationTypes"></div>

                    <?php

                    //                      dd($objwhole);
                    ?>
                    <div class="col-md-6 pt-10 collectiveAggrement">


                    </div>

                    <?php

                    //                        dd($objwhole->vacation);
                    ?>



                    @if(isset($objwhole->vacation->orderVacationDetailAddArray))
                        <div class="col-md-12 dovrClass">

                            <table class="table"><tr><td class="pl-0" colspan="2">Dövr</td><td class="pl-0">İş stajı</td><td class="pl-0">14 yaşa qədər 2 uşağı olan</td><td>14 yaşa qədər 3 uşağı olan</td><td>İş şəraiti</td><td>İş stajı (qalıq)</td><td>14 yaşa qədər 2 uşağı olan (qalıq)</td><td>14 yaşa qədər 3 uşağı olan (qalıq)</td><td>İş şəraiti (qalıq)</td><td>İş stajı (ümumi)</td><td>14 yaşa qədər 2 uşağı olan (ümumi)</td><td>14 yaşa qədər 3 uşağı olan (ümumi)</td><td>İş şəraiti (ümumi)</td></tr>
                                @foreach($objwhole->vacation->orderVacationDetailAddArray as $orderVacationAdd)

                                    <tr>
                                        <td style="width:80px" class="pl-0"><input type="hidden" name="hiddenAdd[]" value="{{$orderVacationAdd->id}}"><input type="text" readonly name="workPeriodFromAdd[]" class="col-md-12 mt-10 form-control pl-0 pr-0 valid" value="{{$orderVacationAdd->orderVacationDetailIdVacationWorkPeriodFrom}}"></td>
                                        <td style="width:80px" class="pl-0"><input type="text" readonly name="workPeriodToAdd[]" class="col-md-12 mt-10 form-control pl-0 pr-0 valid" value="{{$orderVacationAdd->orderVacationDetailIdVacationWorkPeriodTo}}"></td>
                                        <td style="width:50px" class="pl-0"><input type="text" readonly name="experienceDay[]" class="col-md-12 mt-10 form-control pl-5 pr-0 valid" value="{{$orderVacationAdd->experienceDay}}"></td>
                                        <td class="pl-0"><input type="text" readonly name="child142[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->child142}}"></td>
                                        <td class="pl-0"><input type="text" readonly name="child143[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->child143}}"></td>
                                        <td style="width:80px" class="pl-0"><input type="text" readonly name="workConditionDay[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->workConditionDay}}"></td>
                                        <td style="width:100px" class="pl-0"><input type="text" readonly name="remaindeExperienceDay[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->remaindeExperienceDay}}"></td>
                                        <td><input type="text" readonly name="remaindeChild142[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->remaindeChild142 }}"></td>
                                        <td><input type="text" readonly name="remaindeChild143[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->remaindeChild143 }}"></td>
                                        <td><input type="text" readonly name="remaindeWorkConditionDay[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->remaindeWorkConditionDay }}"></td>
                                        <td><input type="text" readonly name="totalExperienceDay[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->totalExperienceDay }}"></td>
                                        <td><input type="text" readonly name="totalChild142[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->totalChild142 }}"></td>
                                        <td><input type="text" readonly name="totalChild143[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->totalChild143 }}"></td>
                                        <td><input type="text" readonly name="totalWorkConditionDay[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->totalWorkConditionDay }}"></td>
                                        <td><input type="text" readonly name="orderVacationDetailId[]" class="col-md-12 mt-10 form-control pl-1 pr-1 valid" value="{{$orderVacationAdd->orderVacationDetailIdId }}"></td>
                                    </tr>

                                @endforeach
                            </table>

                        </div>
                    @endif


                </div>

            </div>
        </div>

        <div class="fillArchTable">


        </div>


        <table class="table beginning"><thead><tr><td style="width:230px" colspan=2>Başlanğıc</td>
                <td style="width:90px">Son period</td>
                <td>Butun qadınlara</td><td>14 yaşına qədər 2 uşağı olan</td>
                <td>14 yaşına qədər 3 uşağı olan</td><td>Çernobıl əlilləri üçün</td>
                <td>Butun qadınlara (qalıq)</td><td>14 yaşına qədər 2 uşağı olan (qalıq)</td>
                <td>14 yaşına qədər 3 uşağı olan (qalıq)</td><td>Çernobıl əlilləri üçün (qalıq)</td>
                <td>Butun qadınlara (ümumi)</td><td>14 yaşına qədər 2 uşağı olan (ümumi)</td>
                <td>14 yaşına qədər 3 uşağı olan (ümumi)</td><td>Çernobıl əlilləri üçün (ümumi)</td>
            </tr></thead>
            <tbody>
            @foreach($objwhole->vacation->orderVacationDetailCollectiveArray as $orderVacationCollective)

                <tr><td></td>
                    <td><input type="hidden" name="hiddenCollective[]" value="{{$orderVacationCollective->id}}"><input type="text" class="col-md-12 fromDateCollective form-control p-2 pl-0" name="workPeriodFromAddCollective[]" value="{{$orderVacationCollective->orderVacationDetailIdVacationWorkPeriodFrom}}" readonly></td>
                    <td><input type="text" class="col-md-12 toDateCollective form-control p-2 pl-0" name="workPeriodToAddCollective[]" value="{{$orderVacationCollective->orderVacationDetailIdVacationWorkPeriodTo}}" readonly></td>
                    <td><input type="number" class="col-md-9 allWomenDay form-control p-2 pl-0" name=allWomenDay[] value="{{(int)$orderVacationCollective->totalAllWomenDay}}" readonly></td>
                    <td><input type="number" class="col-md-9 kvChild142 form-control p-2" name="kvChild142[]" value="{{$orderVacationCollective->totalChild142}}" readonly></td>
                    <td><input type="number"  class="col-md-9 kvChild143 form-control p-2" name="kvChild143[]" value="{{$orderVacationCollective->totalChild143}}" readonly></td>
                    <td><input type="number"  class="col-md-9 chernobylAccident form-control p-2" name="chernobylAccident[]" value="{{$orderVacationCollective->totalChernobylAccidenDay}}" readonly></td>
                    <td><input type="number"  class="col-md-9 remaindeAllWomenDay form-control p-2" name="remaindeAllWomenDay[]" value="{{$orderVacationCollective->remaindeAllWomenDay}}" readonly></td>
                    <td><input type="number"  class="col-md-9 kvRemaindeChild142 form-control p-2" name="kvRemaindeChild142[]" value="{{$orderVacationCollective->remaindeChild142}}" readonly></td>
                    <td><input type="number"  class="col-md-9 kvRemaindeChild143 form-control p-2" name="kvRemaindeChild143[]" value="{{$orderVacationCollective->remaindeChild143}}" readonly></td>
                    <td><input type="number"  class="col-md-12 remaindeChernobylAccidenDay form-control p-2" name="remaindeChernobylAccidenDay[]" value="{{$orderVacationCollective->remaindeChernobylAccidenDay}}" readonly></td>
                    <td><input type="number" class="commonAllWomenDay col-md-12 form-control p-2" name="commonAllWomenDay[]" value="{{$orderVacationCollective->allWomenDay}}" readonly></td>
                    <td><input type="number" class="commonKvChild142 col-md-9 form-control p-2" name="commonKvChild142[]" value="{{$orderVacationCollective->child142}}" readonly></td>
                    <td><input type="number" class="commonKvChild143 col-md-9 form-control p-2" name="commonKvChild143[]" value="{{$orderVacationCollective->child143}}" readonly></td>
                    <td><input type="number" class="commonChernobylAccident col-md-9 form-control p-2" name="commonChernobylAccident[]" value="{{$orderVacationCollective->chernobylAccidenDay}}" readonly></td>
                </tr>

            @endforeach

            </tbody></table>

        <div class="col-md-12">

            <div class="row vacationForCollectiveAggrementTable">



            </div>
        </div>

        <div class="col-md-12">

            <div class="row collectiveAggrementTypesTable">



            </div>
        </div>

        <div class="col-md-4 pull-l workStart">
            <h4>İşə çıxma tarixi:</h4>
            <div class="input-group">
                <input type="text" id="" class="order-related-date date_id form-control" name="wsDate"
                       value="@if(isset($array)){{date('d.m.Y', strtotime($array->wsDate))}}@endif" data-plugin="datepicker">
                <span class="input-group-addon">
                                <i class="icon md-calendar" aria-hidden="true"></i>
                            </span>
            </div>
            <div class="col-md-12 mt-20">
                <h4>Qeyd:</h4>
                <textarea name="vacationComment" cols="30" rows="5" class="form-control"
                          value="@if(isset($array)){{$array->vacationComment}}@endif"></textarea>
            </div>
        </div>

    </div>
</div>

<script>

    $(document).ready(function () {
        $('body').on('changeDate', '.mainVacationDate', function () {

            var rel=parseInt($(this).attr('rel'))+1;

            $('.chosenAmount').each(function () {

                if($(this).attr('data-rel')==rel){

                    $(this).trigger('blur');
                }

            })

        });

        $('body').on('blur', '.chosenAmount', function () {

            var totalall=0, relChosen=$(this).attr('data-rel');

            $('.chosenAmount').each(function (element, index) {

                totalall=parseInt(totalall)+parseInt(this.value);

            });
            var that=$(this).parent().parent();
            var relvalue=that.find('.vacationWorkPeriodFrom').val()

            var obj2=$('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").parent().find("input[rel='"+relvalue+"']").parent().parent();

            var summedDays=parseInt(obj2.find('.allWomenDay').val())+parseInt(obj2.find('.kvChild142').val())+parseInt(obj2.find('.kvChild143').val())+parseInt(obj2.find('.chernobylAccident').val());


            if((parseInt($(this).val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))>$(this).parent().parent().find('.mainVacationDayForPerson').val()) {

                var that=$(this).parent().parent();
                var relvalue=that.find('.vacationWorkPeriodFrom').val(), obj=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent();

                var commonExDay=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonExperienceDay').val();
                var commonChild14_2=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonChild14_2').val();
                var commonChild14_3=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonChild14_3').val();
                var commonWorkConditionDay=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonWorkConditionDay').val();

                var experienceDay=0, child14_2=0, child14_3=0, workConditionDay=0, experienceDayReminder=0, child14_2Reminder=0, child14_3Reminder=0, workConditionDayReminder=0;
                if((parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val()))-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=commonExDay){

                    var experienceDay=commonExDay;
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

                            workConditionDay=parseInt($(this).val())-parseInt(that.find('.mainVacationDayForPerson').val())-parseint(experienceDay)-parseInt(child14_2)-parseint(child14_3);
                            workConditionDayReminder=parseInt(commonWorkConditionDay)-parseInt(workConditionDay);
                        }
                    }


                }
                else {
                    var experienceDay=parseInt($(this).val())+parseInt($(this).parent().parent().find('.additionalVacationDay').val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val());
                    experienceDay=experienceDay>0?experienceDay:'0';
                    experienceDayReminder=parseInt(commonExDay)-experienceDay;
                    child14_2Reminder=parseInt(commonChild14_2);
                    child14_3Reminder=parseInt(commonChild14_3);
                    workConditionDayReminder=parseInt(commonWorkConditionDay);

                }

                console.log(commonChild14_2, commonChild14_3, commonWorkConditionDay, commonExDay);
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

                $.ajax({
                    method: 'GET',
                    url: '/orders/calculatevacationday/' + allDaySum1 + '/' + [$('.mainVacationDate')[0]][0].value,
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
                    }
                    if(index==parseInt(say)+1){
                        that=$(this)
                    }
                });

                $('.mainVacationDate').each(function (index, val1) {

                    if(index==parseInt(say)+1){

                        $(this).val(dayStart)
                    }

                });
                var allDaySum=parseInt(val)+parseInt(summedDays);
                $.ajax({
                    method: 'GET',
                    url: '/orders/calculatevacationday/' + allDaySum+'/' + dayStart,
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

//        $('body').on('blur', '.chosenAmount', function () {
//
//            var totalall=0, relChosen=$(this).attr('data-rel');
//
//            $('.chosenAmount').each(function (element, index) {
//
//                totalall=parseInt(totalall)+parseInt(this.value);
//
//            });
//            var that=$(this).parent().parent();
//            var relvalue=that.find('.vacationWorkPeriodFrom').val()
//
//            var obj2=$('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").parent().find("input[rel='"+relvalue+"']").parent().parent();
//
//            var summedDays=parseInt(obj2.find('.allWomenDay').val())+parseInt(obj2.find('.kvChild142').val())+parseInt(obj2.find('.kvChild143').val())+parseInt(obj2.find('.chernobylAccident').val());
//
//
//            if($(this).val()>$(this).parent().parent().find('.mainVacationDayForPerson').val()) {
//
//                var that=$(this).parent().parent();
//                var relvalue=that.find('.vacationWorkPeriodFrom').val(), obj=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent();
//
//
//
//                var commonExDay=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonExperienceDay').val();
//                var commonChild14_2=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonChild14_2').val();
//                var commonChild14_3=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonChild14_3').val();
//                var commonWorkConditionDay=$('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").parent().parent().find('.commonWorkConditionDay').val();
//
//                var experienceDay=0, child14_2=0, child14_3=0, workConditionDay=0, experienceDayReminder=0, child14_2Reminder=0, child14_3Reminder=0, workConditionDayReminder=0;
//                if(parseInt($(this).val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=commonExDay){
//
//                    var experienceDay=commonExDay;
//                    experienceDayReminder=parseInt(commonExDay)-experienceDay;
//
//                    if(commonChild14_2>0){
//                        console.log(parseInt($(this).val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val()))
//                        if(parseInt($(this).val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=parseInt(commonChild14_2)+parseInt(experienceDay)) {
//
//                            child14_2 = commonChild14_2;
//                        }
//                        else {
//
//
//                            child14_2=parseInt($(this).val())-parseInt(that.find('.mainVacationDayForPerson').val())-parseInt(experienceDay);
//                            child14_2Reminder=parseInt(commonChild14_2)-parseInt(child14_2);
//
//                        }
//                    }
//
//                    if(commonChild14_3>0){
//                        if(parseInt($(this).val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=parseInt(commonChild14_3)+parseInt(experienceDay)) {
//
//                            child14_3 = commonChild14_3;
//                        }
//                        else {
//
//                            child14_3=parseInt($(this).val())-parseInt(that.find('.mainVacationDayForPerson').val())-parseInt(experienceDay);
//                            child14_3Reminder=parseInt(commonChild14_3)-parseInt(child14_3);
//                        }
//                    }
//
//                    if(commonWorkConditionDay>0){
//                        if(parseInt($(this).val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val())>=parseInt(child14_2)+parseInt(child14_3)+parseInt(experienceDay)+parseInt(commonWorkConditionDay)) {
//
//                            workConditionDay = commonWorkConditionDay;
//                        }
//                        else {
//
//                            workConditionDay=parseInt($(this).val())-parseInt(that.find('.mainVacationDayForPerson').val())-parseint(experienceDay)-parseInt(child14_2)-parseint(child14_3);
//                            workConditionDayReminder=parseInt(commonWorkConditionDay)-parseInt(workConditionDay);
//                        }
//                    }
//
//
//                }
//                else {
//
//                    var experienceDay=parseInt($(this).val())+parseInt($(this).parent().parent().find('.mainRemainderVacationDay').val())-parseInt($(this).parent().parent().find('.mainVacationDayForPerson').val());
//                    experienceDay=experienceDay>0?experienceDay:'0';
//                    experienceDayReminder=parseInt(commonExDay)-experienceDay;
//                    child14_2Reminder=parseInt(commonChild14_2);
//                    child14_3Reminder=parseInt(commonChild14_3);
//                    workConditionDayReminder=parseInt(commonWorkConditionDay);
//
//                }
//
//                console.log(commonChild14_2, commonChild14_3, commonWorkConditionDay, commonExDay);
//                obj.find('.experienceDay').val(experienceDay);
//                obj.find('.child_14_12').val(child14_2);
//                obj.find('.child_14_13').val(child14_3);
//                obj.find('.workConditionDay').val(workConditionDay);
//
//                obj.find('.remainderExperienceDay').val(experienceDayReminder);
//                obj.find('.remainderChild_14_12').val(child14_2Reminder);
//                obj.find('.remainderChild_14_13').val(child14_3Reminder);
//                obj.find('.remainderWorkConditionDay').val(workConditionDayReminder);
//            }
//            if($(this).attr('rel')>1){
//
//                if($(this).val()>=$(this).parent().parent().find('.currentMainVacation').data('value')){
//
//                    $(this).parent().parent().find('.rmainVacation').val($(this).parent().parent().find('.currentMainVacation').data('value'))
//                    $(this).parent().parent().find('.radditionalVacation').val(parseInt($(this).val())-parseInt($(this).parent().parent().find('.currentMainVacation').data('value')));
//
//                    $(this).parent().parent().find('.mainRemainderVacationDay').val('0');
////                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).parent().parent().find('.currentMainVacation').data('value'));
////                $(this).parent().parent().find('.additionalVacationDay').val(($(this).val()-$(this).parent().parent().find('.currentMainVacation').data('value')))
//                    $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value')-$(this).parent().parent().find('.additionalVacationDay').val())
//
//                }
//                else {
//
////                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).val());
////                $(this).parent().parent().find('.mainRemainderVacationDay').val($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).val());
//                    $(this).parent().parent().find('.additionalVacationDay').val('0');
//                    $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value'))
//                    $(this).parent().parent().find('.rmainVacation').val($(this).val())
//                    $(this).parent().parent().find('.radditionalVacation').val('0');
//                }
//
//            }
//            else {
//
//                if($(this).val()>=$(this).parent().parent().find('.currentMainVacation').data('value')){
//
//                    $(this).parent().parent().find('.radditionalVacation').val(parseInt($(this).val())-parseInt($(this).parent().parent().find('.currentMainVacation').data('value')));
//
//                    $(this).parent().parent().find('.rmainVacation').val($(this).parent().parent().find('.currentMainVacation').data('value'))
////                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).parent().parent().find('.mainRemainderVacationDay').data('value'));
////                $(this).parent().parent().find('.mainRemainderVacationDay').val($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).parent().parent().find('.mainVacationDayForPerson').val());
//
////                $(this).parent().parent().find('.additionalVacationDay').val(Math.abs($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).val()))
//
////                $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value')-Math.abs($(this).parent().parent().find('.additionalVacationDay').val()))
//
//                }
//                else {
////                $(this).parent().parent().find('.mainVacationDayForPerson').val($(this).val());
////                $(this).parent().parent().find('.mainRemainderVacationDay').val($(this).parent().parent().find('.currentMainVacation').data('value')-$(this).val());
//                    $(this).parent().parent().find('.rmainVacation').val($(this).val())
//                    $(this).parent().parent().find('.radditionalVacation').val('0');
//                    $(this).parent().parent().find('.additionalVacationDay').val('0');
////                $(this).parent().parent().find('.additionalRemainderVacationDay').val($(this).parent().parent().find('.currentAdditionalVacation').data('value'))
//
//                }
//
//
//            }
//            if([$('.mainVacationDate')[0]][0].value!='' && $(this).attr('data-rel')=='1') {
//
//                var allDaySum1=parseInt($(this).val())+parseInt(summedDays);
//
//                var thisval=$(this).val();
//
//                $.ajax({
//                    method: 'GET',
//                    url: '/orders/calculatevacationday/' + allDaySum1 + '/' + [$('.mainVacationDate')[0]][0].value,
//                    success: function (response) {
//
//                        if(response.notselected){
//
//                            swal('Diqqət!', response.notselected, 'info');
//
//
//                        }
//
//                        else if(relChosen==1){
//
//                            $('#additionalVacation').val(response['data'])
//
//                        }
//
//                    },
//                    error: function (err) {
//
//                        throw new Error('Error getting vacation days: ' + err);
//
//                    }
//                });
//
//            }
//
//            else if([$('.mainVacationDate')[0]][0].value!='' && $(this).attr('data-rel')>1) {
//
//                var dayStart='', that='', val=$(this).val();
//
//                var say=$(this).attr('data-rel')-2;
//
//                $('.additionalVacationDate').each(function (index, val1) {
//                    if(index==say){
//                        console.log($(this).val())
//                        dayStart=$(this).val();
//                    }
//                    if(index==parseInt(say)+1){
//                        that=$(this)
//                    }
//                });
//
//                $('.mainVacationDate').each(function (index, val1) {
//
//                    if(index==parseInt(say)+1){
//
//                        $(this).val(dayStart)
//                    }
//
//                });
//                var allDaySum=parseInt(val)+parseInt(summedDays);
//                $.ajax({
//                    method: 'GET',
//                    url: '/orders/calculatevacationday/' + allDaySum+'/' + dayStart,
//                    success: function (response) {
//
//                        if(response.notselected){
//
//                            swal('Diqqət!', response.notselected, 'info');
//
//                        }
//                        else {
//
//                            that.val(response['data'])
//                        }
//
//
//                    },
//                    error: function (err) {
//
//                        throw new Error('Error getting vacation days: ' + err);
//
//                    }
//                });
//
//            }
//            else {
//
//                swal('Diqqət!', 'Məzuniyyətin ilkin başlanğıc tarixini seçin!', 'info');
//
//            }
//
//        });


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

        $('body').on('change', '.allWomenDay', function(){

            var inputVal=parseInt($(this).parent().parent().find('.remaindeAllWomenDay').attr('rel'))-(parseInt($(this).val())-parseInt($(this).attr('rel')))
            $(this).parent().parent().find('.remaindeAllWomenDay').val(inputVal)

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

        $('.fromDateCheckCollective').on('click', 'checkbox', function () {

            if($(this).parent().parent().prev()){
                var parentObj=$(this).parent().parent().prev();
                var allReminder=parseInt(parentObj.find('.kvRemaindeChild142').val())+parseInt(parentObj.find('.kvRemaindeChild143').val())+parseInt(parentObj.find('.remaindeChernobylAccidenDay').val())+parseInt(parentObj.find('.remaindeAllWomenDay').val())

            }

            if(this.checked==true) {

                if(allReminder>0 && $(this).attr('data-rel')>0){
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

            $(".fromDateCheckCollective").off("click");

//            $('.fromDateCheckCollective').off('click','span');

        });

        $('body').on('click', '.enableIt', function () {

            var that=$(this).parent().parent();

            var periodArray=[], errorFlag=false;

            $('.periodFromDate').each(function(){

                periodArray.push($(this).val());

            });

            var relvalue=that.find('.vacationWorkPeriodFrom').val();

            $('.vacationForCollectiveAggrementTable').find('table').find('tbody').find(".fromDateCheck").parent().find("input[rel='"+relvalue+"']").trigger('click');

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

                    that.find('.chosenAmount').val(that.find('.chosenAmount').attr('data-value'))

                    that.find('.currentMainVacation').val(that.find('.currentMainVacation').attr('data-value'))

                    that.find('.currentAdditionalVacation').val(that.find('.currentAdditionalVacation').attr('data-value'))

                    that.find('.chosenAmount').attr('disabled', 'true');
                }

            }
        });

        $('body').on('click', '.collectiveAggrementTick', function () {

            if($(this).is(":checked")){


                $(this).parent().parent().find('.dayValue').attr('name', $(this).attr('rel')+'_day[]');
            }
            else {

                $(this).parent().parent().removeAttr('name');
            }


        });

        $('.fillArchTable').on('click', '.multi', function () {

            console.log($(this).parent().parent().prev().find('.enableIt').is(":checked"))
            var thatCollective=$(this).parent().parent();
            var relvalue=thatCollective.find('.vacationWorkPeriodFrom').val();

            var collectiveObj=$('.collectiveAggrementTypesTable').find('table').find('tbody').find(".fromDateCheckCollective").parent().find("input[rel='"+relvalue+"']").parent().parent().prev();

            var collectiveObjCommons=parseInt(collectiveObj.find('.commonAllWomenDay').val())+parseInt(collectiveObj.find('.commonKvChild142').val())+parseInt(collectiveObj.find('.commonKvChild143').val())+parseInt(collectiveObj.find('.commonChernobylAccident').val());
            var collectiveObjGiven=parseInt(collectiveObj.find('.allWomenDay').val())+parseInt(collectiveObj.find('.kvChild142').val())+parseInt(collectiveObj.find('.kvChild143').val())+parseInt(collectiveObj.find('.chernobylAccident').val());
            if($(this).attr('rel')==1) {

//            alert(collectiveObjGiven);
                console.log(collectiveObj.find('.allWomenDay').val());
                if ($('.first').is(":checked") && $(this).is(":checked")) {

                    var that=$(this).parent().parent().prev();

                    var chosenVal = $(this).parent().parent().prev().find('.chosenAmount').val()!=''?parseInt($(this).parent().parent().prev().find('.chosenAmount').val()):'0';

                    var totalReminderDay = parseInt(that.find('.mainVacationDayForPerson').val())+parseInt(that.find('.currentAdditionalVacation').val())-parseInt(that.find('.mainRemainderVacationDay').val())-parseInt(that.find('.additionalVacationDay').val())
                    console.log('---');
                    console.log(chosenVal);
                    console.log( parseInt(that.find('.mainVacationDayForPerson').val())+parseInt(that.find('.currentAdditionalVacation').val())-parseInt(that.find('.mainRemainderVacationDay').val())-parseInt(that.find('.additionalVacationDay').val()));
                    if (chosenVal < totalReminderDay) {

                        swal('Diqqət!', 'Əvvəlki qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');

                        $(this).trigger('click');
                    }

                    else {

                        if((parseInt(chosenVal)+parseInt(collectiveObjGiven))<(parseInt(totalReminderDay)+parseInt(collectiveObjCommons))){

                            swal('Diqqət!', 'Kollektiv müqaviləyə uyğun qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');

                            $(this).trigger('click');

                        }
                        else {

                            $('.first').parent().parent().find('.chosenAmount').prop("readonly", true);

                        }

                    }
                    console.log(totalReminderDay);
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

                        if((parseInt(chosenVal)+parseInt(collectiveObjGiven))<(parseInt(totalReminderDay)+parseInt(collectiveObjCommons))){

                            swal('Diqqət!', 'Kollektiv müqaviləyə uyğun qalığı tam yazmamış yenisinə keçmək olmaz!', 'info');

                            $(this).trigger('click');

                        }
                        else {
                            $(this).parent().parent().prev().find('.chosenAmount').prop("readonly", true);

                        }


                    }
                    console.log(totalReminderDay);
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



            $('.fillvacation').html('');
            $('.userList').html('');
            $('#sabbaticalLeaveDays').val('');
            $('#lastPossibleDate').remove();
            $('#lastPossibleDateh4').remove();
            $('.vacationForCollectiveAggrementTable').html('');

//        alert($(this).select2('data')[0].label)

            if($(this).select2('data')[0].label=='labor_vacation') {

                $('.sabbaticalInputs').find('div').each(function () {

                    $(this).html('');

                });

                $('#listVacationTypeIdLabel').val('labor_vacation');

                $('.userList').html('<h4>Əməkdaş:</h4><select name="userId" id="userInVacationId" class="form-control select"  data-url="{{ route('users', 'select') }}"> <option value="" selected></option> </select>');

                var url = '{{ route('users', 'select') }}';

                $('#userInVacationId').selectObj('userInVacationId', false, url);

                var vacationstr='<table class="table"><thead><tr><td colspan=3 style="width:220px">İş ili dövrü</td>'+
                    '<td style="width:85px">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</td>'+
                    '<td style="width:90px">İşçinin əlavə məzuniyyəti</td>'+
                    '<td style="width:90px">istifadə etdiyi əsas məzuniyyət günləri</td>'+
                    '<td style="width:90px">Əsas məzuniyyət gününün qalığı</td>'+
                    '<td style="width:90px">Istifadə etdiyi əlavə məzuniyyət günləri</td>'+
                    '<td style="width:90px">Əlavə məzuniyyət gününün qalığı</td>'+
                        {{--<div class="col-md-1 mt-15 pull-l">Cari əlavə məzuniyyət (İşçinin vəzifəsinə uyğun əlavə məzuniyyət günü)</div>--}}
                        {{--<div class="col-md-1 mt-15 pull-l">Cəmi məzuniyyət</div>--}}
                    //                        '<td style="width:90px"><b>Əlavə məzuniyyət</b></td>'+
                    '<td style="width:80px">Ümumi istifadə olunan</td>'+
                    '<td style="width:80px">Cari məzuniyyət</td>'+
                    '<td style="width:85px">İşçinin əlavə məzuniyyəti K/m üzrə</td>'+
                    '<td style="width:80px">K/m üzrə (qaliq)</td>'+
                    '<td style="width:80px">K/m üzrə istifadə etdiyi</td>'+
                    '<td colspan=2>Məzuniyyət aralığı</td>'+
                    '<tbody class="fillArch"></tbody>';

                $('.fillvacation').html(vacationstr);

                $('.mainVacationDate').datepicker({
                    orientation: "top",
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayHighlight: true,

                })

            }

            else if($(this).select2('data')[0].label=='sabbatical_leave' || $(this).select2('data')[0].label=='paid_social_vacation' || $(this).select2('data')[0].label=='paid_educational_vacation' || $(this).select2('data')[0].label=='nonpaid_vacation' || $(this).select2('data')[0].label=='partialpaid_social_vacation'){

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

        /*
         *
         * When position name is chosen pass its id and get employees
         * trigger select2
         * */


        /*
         $('#userInVacationPositionNameId').on('select2:select', function () {

         var url = $('#userInVacationIdL').data('url') + '/' + $(this).val();

         $('#userInVacationIdL').selectObj('userInVacationIdL', false, url);

         var url = $('#userInVacationIdL').data('url') + '/' + $(this).val();

         });
         /*
         Azer commented it
         */

        $('#userInVacationIdL').selectObj('userInVacationIdL', false, url);

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


        });

        $('body').on('change', '#userInVacationIdL', function () {

            $('.fillVacationHr').remove();

            $('.beginning').remove();

            $('.dovrClass').remove();

            $('.tt').remove();
            $('.fillvacation').parent().parent().parent().remove();
            $('.fillDates').parent().parent().parent().parent().remove();

            var options='', additionalDays='<h4>Əlavə məzuniyyət növləri:</h4>';
            var periodArray=[];
            var userId=$(this).val();
            var tableStr='', tableHead='<table class="table"><thead><tr><td style="width:230px" colspan=2>Başlanğıc</td><td style="width:90px">Son period</td>' +
                '<td>İş stajına görə</td><td>14 yaşına qədər 2 uşağı olan</td>' +
                '<td>14 yaşına qədər 3 uşağı olan</td><td>İş şəraitinə görə</td>' +
                '<td>İş stajı (qalıq)</td><td>14 yaşına qədər 2 uşağı olan (qalıq)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (qalıq)</td><td>İş şəraitinə görə (qalıq)</td>' +
                '<td>İş stajına görə (ümüumi)</td><td>14 yaşına qədər 2 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (ümumi)</td><td>İş şəraitinə görə (ümumi)</td>' +
                '</tr></thead>', tableBody='<tbody>';
            var tableCollectiveHead='<table class="table"><thead><tr><td style="width:230px" colspan=2>Başlanğıc</td><td style="width:90px">Son period</td>' +
                '<td>Butun qadınlara</td><td>14 yaşına qədər 2 uşağı olan</td>' +
                '<td>14 yaşına qədər 3 uşağı olan</td><td>Çerbobıl əlilləri üçün</td>' +
                '<td>Butun qadınlara (qalıq)</td><td>14 yaşına qədər 2 uşağı olan (qalıq)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (qalıq)</td><td>Çerbobıl əlilləri üçün (qalıq)</td>' +
                '<td>Butun qadınlara (ümumi)</td><td>14 yaşına qədər 2 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (ümumi)</td><td>Çerbobıl əlilləri üçün (ümumi)</td>' +

                '</tr></thead>', tableBodyCollective='<tbody>';

            {{--var  data='<table class="table"><thead><tr><td colspan=3 style="width:220px">İş ili dövrü</td>'+--}}
                {{--'<td style="width:85px">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</td>'+--}}
                {{--'<td style="width:90px">İşçinin əlavə məzuniyyəti</td>'+--}}
                {{--'<td style="width:90px">istifadə etdiyi əsas məzuniyyət günləri</td>'+--}}
                {{--'<td style="width:90px">Əsas məzuniyyət gününün qalığı</td>'+--}}
                {{--'<td style="width:90px">Istifadə etdiyi əlavə məzuniyyət günləri</td>'+--}}
                {{--'<td style="width:90px">Əlavə məzuniyyət gününün qalığı</td>'+--}}
                    {{--<div class="col-md-1 mt-15 pull-l">Cari əlavə məzuniyyət (İşçinin vəzifəsinə uyğun əlavə məzuniyyət günü)</div>--}}
                    {{--<div class="col-md-1 mt-15 pull-l">Cəmi məzuniyyət</div>--}}
                {{--//                        '<td style="width:90px"><b>Əlavə məzuniyyət</b></td>'+--}}
                {{--'<td style="width:80px">Ümumi istifadə olunan</td>'+--}}
                {{--'<td style="width:80px">Cari məzuniyyət</td>'+--}}
                {{--'<td style="width:85px">İşçinin əlavə məzuniyyəti K/m üzrə</td>'+--}}
                {{--'<td style="width:80px">K/m üzrə (qaliq)</td>'+--}}
                {{--'<td style="width:80px">K/m üzrə istifadə etdiyi</td>'+--}}
                {{--'<td colspan=2>Məzuniyyət aralığı</td></tr></thead>';--}}
            $.ajax({
                method: 'GET',
                url: '/orders/getarch/'+ $(this).val(),
                async:false,
                success: function (response) {

                    /* response code is OK */


                    var klass='', hiddenForKm='', dataStr='', selectedMaxData='', con='', currentAdditionalVacation, chosenData='', currentVacation='', mainRemainderVacationday='';
                    var data='<table class="table"><thead><tr><td colspan=3 style="width:220px">İş ili dövrü</td><td style="width:85px">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</td>'+
                        '<td style="width:90px">İşçinin əlavə məzuniyyəti</td>'+
                        '<td style="width:90px">istifadə etdiyi əsas məzuniyyət günləri</td>'+
                        '<td style="width:90px">Əsas məzuniyyət gününün qalığı</td>'+
                        '<td style="width:90px">Istifadə etdiyi əlavə məzuniyyət günləri</td>'+
                        '<td style="width:90px">Əlavə məzuniyyət gününün qalığı</td>'+
                        '<td style="width:80px">Ümumi istifadə olunan</td>'+
                        '<td style="width:80px">Cari məzuniyyət</td>'+
                        '<td style="width:85px">İşçinin əlavə məzuniyyəti K/m üzrə</td>'+
                        '<td style="width:80px">K/m üzrə (qaliq)</td>'+
                        '<td style="width:80px">K/m üzrə istifadə etdiyi</td>'+
                        '<td colspan=2>Məzuniyyət aralığı</td></tr></thead>';
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

                                if(response.data[index].additionalRemainderVacationDay=='0'){
                                    var elaveMezuniyyetQaliq='0';
                                }
                                else {
                                    var elaveMezuniyyetQaliq=parseInt(response.data[index].additionalVacationDay)-parseInt(response.data[index].additionalRemainderVacationDay);

                                }
                            }
                            else {
                                var elaveMezuniyyetQaliq=response.data[index].additionalRemainderVacationDay;

                            }

                            var allWomanDay=parseInt(response.data[index].allWomenDay)-parseInt(response.data[index].remaindeAllWomenDay);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].remaindeAllWomenDay=='0'){

                                allWomanDay='0';
                            }

                            var child142=parseInt(response.data[index].kvChild142)-parseInt(response.data[index].kvRemaindeChild142);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].kvRemaindeChild142=='0'){

                                child142='0';
                            }

                            var child143=parseInt(response.data[index].kvChild143)-parseInt(response.data[index].kvRemaindeChild143);

                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].kvRemaindeChild143=='0'){

                                child143='0';
                            }

                            var chernobylAccident=parseInt(response.data[index].chernobylAccidenDay)-parseInt(response.data[index].remaindeChernobylAccidenDay);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].remaindeChernobylAccidenDay=='0'){

                                chernobylAccident='0';
                            }

                            if(response.data[index].additionalRemainderVacationDay=='0' && response.data[index].mainReminderVacationDay!='0'){

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
                            var commonExperienceDay=parseInt(response.data[index].remainderExperienceDay)+parseInt(response.data[index].experienceDay);
                            var commonChild14_2=parseInt(response.data[index].remainderChild_14_12)+parseInt(response.data[index].child_14_12);
                            var commonChild14_3=parseInt(response.data[index].remainderChild_14_13)+parseInt(response.data[index].child_14_13);
                            var commonWorkConditionDay=parseInt(response.data[index].workConditionDay)+parseInt(response.data[index].workConditionDay);

                            var experienceDayVal=parseInt(response.data[index].experienceDay)-parseInt(response.data[index].remainderExperienceDay);
                            var child_14_12Val=parseInt(response.data[index].child_14_12)-parseInt(response.data[index].remainderChild_14_12);
                            var child_14_13Val=parseInt(response.data[index].child_14_13)-parseInt(response.data[index].remainderChild_14_13);
                            var workConditionDayVal=parseInt(response.data[index].workConditionDay)-parseInt(response.data[index].remainderWorkConditionDay);


                            tableBody=tableBody+'<tr>' +
                                '<td><input type="checkbox" class="fromDateCheck" rel="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 fromDate form-control p-2 pl-0" value="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 toDate form-control p-2 pl-0 pr-0" value="'+response.data[index].toDate+'"></td>' +
                                '<td><input type="number"  class="experienceDay col-md-9 form-control p-2" value="'+experienceDayVal+'"></td>' +
                                '<td><input type="number"  class="child_14_12 col-md-9 form-control p-2" value="'+child_14_12Val+'"></td>' +
                                '<td><input type="number"  class="child_14_13 col-md-9 form-control p-2" value="'+child_14_13Val+'"></td>' +
                                '<td><input type="number"  class="workConditionDay col-md-9 form-control p-2" value="'+workConditionDayVal+'"></td>' +
                                '<td><input type="number" class="remainderExperienceDay col-md-9 form-control p-2" value="'+response.data[index].remainderExperienceDay+'"></td>' +
                                '<td><input type="number" class="remainderChild_14_12 col-md-9 form-control p-2" value="'+response.data[index].remainderChild_14_12+'"></td>' +
                                '<td><input type="number" class="remainderChild_14_13 col-md-9 form-control p-2" value="'+response.data[index].remainderChild_14_13+'"></td>' +
                                '<td><input type="number" class="remainderWorkConditionDay col-md-9 form-control p-2" value="'+response.data[index].remainderWorkConditionDay+'"></td>' +
                                '<td><input type="number" class="commonExperienceDay col-md-12 form-control p-2" value="'+commonExperienceDay+'"></td>' +
                                '<td><input type="number" class="commonChild14_2 col-md-9 form-control p-2" value="'+commonChild14_2+'"></td>' +
                                '<td><input type="number" class="commonChild14_3 col-md-9 form-control p-2" value="'+commonChild14_3+'"></td>' +
                                '<td><input type="number" class="commonWorkConditionDay col-md-9 form-control p-2" value="'+commonWorkConditionDay+'"></td>' +

                                '</tr>';
                            var commonAllWomenDay=parseInt(response.data[index].allWomenDay);
                            var commonKvChild142=parseInt(response.data[index].kvChild142);
                            var commonKvChild143=parseInt(response.data[index].kvChild143);
                            var commonChernobylAccident=parseInt(response.data[index].chernobylAccidenDay);
                            var allKm=commonAllWomenDay+commonKvChild142+commonKvChild143+commonChernobylAccident;
                            var allKmReminder=parseInt(response.data[index].remaindeChernobylAccidenDay)+parseInt(response.data[index].remaindeAllWomenDay)+parseInt(response.data[index].kvRemaindeChild142)+parseInt(response.data[index].kvRemaindeChild143);
                            var allKmUsed=0;

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
                                '<td><input type="checkbox" class="fromDateCheckCollective" data-rel="'+index+'" rel="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 fromDateCollective form-control p-2 pl-0" value="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 toDateCollective form-control p-2 pl-0" value="'+response.data[index].toDate+'"></td>'+
                                '<td><input type="number" max="'+commonAllWomenDay+'" min="0" class="col-md-9 allWomenDay form-control p-2 pl-0" rel="'+allWomanDay+'" value="'+allWomanDay+'"></td>' +
                                '<td><input type="number" max="'+commonKvChild142+'" min="0"class="col-md-9 kvChild142 form-control p-2" rel="'+child142+'" value="'+child142+'"></td>' +
                                '<td><input type="number"  max="'+commonKvChild143+'" min="0" class="col-md-9 kvChild143 form-control p-2" rel="'+child143+'" value="'+child143+'"></td>' +
                                '<td><input type="number" max="'+commonChernobylAccident+'" min="0" class="col-md-9 chernobylAccident form-control p-2" rel="'+chernobylAccident+'" value="'+chernobylAccident+'"></td>' +
                                '<td><input type="number" max="'+commonAllWomenDay+'" min="0" class="col-md-9 remaindeAllWomenDay form-control p-2" rel="'+response.data[index].remaindeAllWomenDay+'" value="'+response.data[index].remaindeAllWomenDay+'"></td>' +
                                '<td><input type="number" max="'+commonKvChild142+'" min="0" class="col-md-9 kvRemaindeChild142 form-control p-2" rel="'+response.data[index].kvRemaindeChild142+'" value="'+response.data[index].kvRemaindeChild142+'"></td>' +
                                '<td><input type="number" max="'+commonKvChild143+'" min="0" class="col-md-9 kvRemaindeChild143 form-control p-2" rel="'+response.data[index].kvRemaindeChild143+'" value="'+response.data[index].kvRemaindeChild143+'"></td>' +
                                '<td><input type="number" max="'+commonChernobylAccident+'" min="0" class="col-md-12 remaindeChernobylAccidenDay form-control p-2" rel="'+response.data[index].remaindeChernobylAccidenDay+'" value="'+response.data[index].remaindeChernobylAccidenDay+'"></td>' +
                                '<td><input type="number" class="commonAllWomenDay col-md-12 form-control p-2" value="'+commonAllWomenDay+'"></td>' +
                                '<td><input type="number" class="commonKvChild142 col-md-9 form-control p-2" value="'+commonKvChild142+'"></td>' +
                                '<td><input type="number" class="commonKvChild143 col-md-9 form-control p-2" value="'+commonKvChild143+'"></td>' +
                                '<td><input type="number" class="commonChernobylAccident col-md-9 form-control p-2" value="'+commonChernobylAccident+'"></td>' +

                                '</tr>';

                            dataStr =dataStr+'<tr>'+
                                '<td style="padding-left: 0px;padding-right: 0px;"><input type="checkbox" class="enableIt pl-1 pr-1 ' + klass + '" value="' + response.data[index].id + '" name="enableIt[]" rel="' + index + '"></td>'+
                                '<td style="width:70px;padding-left: 0px;padding-right: 0px;"><input type="text" style="width:70px" class="col-md-12 form-control pl-0 pr-0 vacationWorkPeriodFrom" id="remainingDays" data-name="vacationWorkPeriodFrom[]" value="' + response.data[index].fromDate + '"></td>'+

                                '<td style="width:70px;"><input type="text" style="width:70px" class="col-md-12 form-control pl-0 pr-0 vacationWorkPeriodTo" id="remainingDays" data-name="vacationWorkPeriodTo[]" value="' + response.data[index].toDate + '"></td>'+

                                '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 mainVacationDayForPerson" data-name="mainVacationDayForPerson[]" data-value="' + response.data[index].mainVacationDay + '" readonly value="' + response.data[index].mainVacationDay + '"></td>'+

                                '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 currentAdditionalVacation" data-name="currentAdditionalVacation[]" data-value="' + response.data[index].additionalVacationDay + '" required readonly value="' + response.data[index].additionalVacationDay + '"></td>'+

                                '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 mainRemainderVacationDay" readonly data-name="mainRemainderVacationDay[]" data-value="' + mainRemainderVacationday + '" readonly value="' + mainRemainderVacationday+ '"></td>'+
                                '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 currentMainVacation" data-name="currentMainVacation[]" data-value="' + con + '" required value="' + con + '"></td>'+

                                '<td style="width:70px;"><input type="number" class="col-md-12 form-control p-2 additionalVacationDay" data-name="additionalVacationDay[]" data-value="' + elaveMezuniyyetQaliq + '"  value="' + elaveMezuniyyetQaliq + '" readonly></td>'+
                                '<td><input type="number" class="col-md-12 form-control p-2 additionalRemainderVacationDay" readonly data-name="additionalRemainderVacationDay[]"  data-value="' + response.data[index].additionalRemainderVacationDay + '" value="' + response.data[index].additionalRemainderVacationDay + '"></td>'+

                                '<td style="display:none" class="col-md-1 mt-15 pull-l"><input type="number" class="col-md-12 form-control p-2 radditionalVacation"  readonly data-name="radditionalVacation[]" data-rel="" value="0"  required rel=""></td>'+

                                '<td><input type="number" class="col-md-12 form-control p-2 chosenAmount" data-name="chosenAmount[]" data-rel="' + (index + 1) + '" value="0" min="0" max="' + selectedMaxData + '" required disabled rel="' + response.data[index].con + '"></td>'+

                                '<td><input type="number" class="col-md-12 form-control p-2"  value="'+currentVacation+'"  required disabled rel="' + currentVacation + '"></td>'+
                                '<td><input type="number" class="col-md-12 kmVacation form-control p-2"  value="'+allKm+'"></td>'+

                                '<td><input type="number" class="col-md-12 kmReminderVacation form-control p-2"  value="'+allKmReminder+'"></td>'+
                                '<td><input type="number" class="col-md-12 kmUsedVacation form-control p-2"  value="'+allKmUsed+'"></td>'+
                                '<td style="width:70px"><input type="text" rel="'+index+'" class="col-md-12 form-control p-2 pl-0 pr-0 mainVacationDate" name="vacationStartDate[]"></td>' +
                                '<td><input type="text" rel="'+index+'" class="col-md-12 pl-0 pr-0 form-control p-2 additionalVacationDate" id="additionalVacation" name="vacationEndDate[]" style="float:right;width:70px"></td>'+
                                '<td style="display:none">'+hiddenForKm+'<input type="number" class="col-md-8 form-control p-2  rmainVacation" readonly data-name="rmainVacation[]" style="width:73px"></td>'+
                                '<td><input type="number" class="col-md-8 form-control p-2" readonly style="width:73px"></td>'+
                                '</tr>';


                        });

                        $('.fillArchTable').html(data+'<tbody>'+dataStr+'</tbody></table><input type="hidden" id="hiddenEdit" value="hidden" name="hiddenEdit">');

                        console.log(data)


                        $('.fillDates').html(chosenData);

                        $('.mainVacationDate').datepicker({
                            orientation: "top",
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            todayHighlight: true,

                        });


                        $('.vacationForCollectiveAggrementTable').html(tableHead+tableBody+'</tbody></table>');

                        $('.collectiveAggrementTypesTable').html(tableCollectiveHead+tableBodyCollective+'</tbody></table>');

                    }

                },
                error: function (err) {

                    throw new Error('Error getting vacation days: ' + err);

                }
            });


        });

        $('body').on('click', '.clearVacation', function () {

            var thatD=$(this);
            var periodArray=[];
            $('.dovrClass').remove();
            $('.beginning').remove();

            var userId=$('#userInVacationIdL').val();
            var tableStr='', tableHead='<table class="table"><thead><tr><td style="width:230px" colspan=2>Başlanğıc</td><td style="width:90px">Son period</td>' +
                '<td>İş stajına görə</td><td>14 yaşına qədər 2 uşağı olan</td>' +
                '<td>14 yaşına qədər 3 uşağı olan</td><td>İş şəraitinə görə</td>' +
                '<td>İş stajı (qalıq)</td><td>14 yaşına qədər 2 uşağı olan (qalıq)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (qalıq)</td><td>İş şəraitinə görə (qalıq)</td>' +
                '<td>İş stajına görə (ümüumi)</td><td>14 yaşına qədər 2 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (ümumi)</td><td>İş şəraitinə görə (ümumi)</td>' +
                '</tr></thead>', tableBody='<tbody>';
            var tableCollectiveHead='<table class="table"><thead><tr><td style="width:230px" colspan=2>Başlanğıc</td><td style="width:90px">Son period</td>' +
                '<td>Butun qadınlara</td><td>14 yaşına qədər 2 uşağı olan</td>' +
                '<td>14 yaşına qədər 3 uşağı olan</td><td>Çernobıl əlilləri üçün</td>' +
                '<td>Butun qadınlara (qalıq)</td><td>14 yaşına qədər 2 uşağı olan (qalıq)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (qalıq)</td><td>Çernobıl əlilləri üçün (qalıq)</td>' +
                '<td>Butun qadınlara (ümumi)</td><td>14 yaşına qədər 2 uşağı olan (ümumi)</td>' +
                '<td>14 yaşına qədər 3 uşağı olan (ümumi)</td><td>Çernobıl əlilləri üçün (ümumi)</td>' +

                '</tr></thead>', tableBodyCollective='<tbody>';
            $.ajax({
                method: 'GET',
                url: 'orders/get-last-vacation-days/'+$(this).attr('rel')+'/'+ $(this).attr('id'),
                async:false,
                success: function (response) {


                    var  data='<table class="table"><thead><tr><td colspan=3 style="width:220px">İş ili dövrü</td>'+
                        '<td style="width:85px">İşçinin vəzifəsinə uyğun əsas məzuniyyət günü</td>'+
                        '<td style="width:90px">İşçinin əlavə məzuniyyəti</td>'+
                        '<td style="width:90px">istifadə etdiyi əsas məzuniyyət günləri</td>'+
                        '<td style="width:90px">Əsas məzuniyyət gününün qalığı</td>'+
                        '<td style="width:90px">Istifadə etdiyi əlavə məzuniyyət günləri</td>'+
                        '<td style="width:90px">Əlavə məzuniyyət gününün qalığı</td>'+
                            {{--<div class="col-md-1 mt-15 pull-l">Cari əlavə məzuniyyət (İşçinin vəzifəsinə uyğun əlavə məzuniyyət günü)</div>--}}
                            {{--<div class="col-md-1 mt-15 pull-l">Cəmi məzuniyyət</div>--}}
                        //                        '<td style="width:90px"><b>Əlavə məzuniyyət</b></td>'+
                        '<td style="width:80px">Ümumi istifadə olunan</td>'+
                        '<td style="width:80px">Cari məzuniyyət</td>'+
                        '<td style="width:85px">İşçinin əlavə məzuniyyəti K/m üzrə</td>'+
                        '<td style="width:80px">K/m üzrə (qaliq)</td>'+
                        '<td style="width:80px">K/m üzrə istifadə etdiyi</td>'+
                        '<td colspan=2>Məzuniyyət aralığı</td></tr></thead>';

                    var klass='', hiddenForKm='', selectedMaxData='', con='', currentAdditionalVacation, chosenData='', currentVacation='', mainRemainderVacationday='';

                    if (response.code == 200)
                    {
                        $('.fillvacation').parent().parent().remove();
                        $('.fillDates').parent().parent().remove();
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

                                if(response.data[index].additionalRemainderVacationDay=='0'){
                                    var elaveMezuniyyetQaliq='0';
                                }
                                else {
                                    var elaveMezuniyyetQaliq=parseInt(response.data[index].additionalVacationDay)-parseInt(response.data[index].additionalRemainderVacationDay);

                                }
                            }
                            else {
                                var elaveMezuniyyetQaliq=response.data[index].additionalRemainderVacationDay;

                            }

                            var allWomanDay=parseInt(response.data[index].allWomenDay)-parseInt(response.data[index].remaindeAllWomenDay);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].remaindeAllWomenDay=='0'){

                                allWomanDay='0';
                            }

                            var child142=parseInt(response.data[index].kvChild142)-parseInt(response.data[index].kvRemaindeChild142);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].kvRemaindeChild142=='0'){

                                child142='0';
                            }

                            var child143=parseInt(response.data[index].kvChild143)-parseInt(response.data[index].kvRemaindeChild143);

                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].kvRemaindeChild143=='0'){

                                child143='0';
                            }

                            var chernobylAccident=parseInt(response.data[index].chernobylAccidenDay)-parseInt(response.data[index].remaindeChernobylAccidenDay);
                            if((response.data[index].additionalRemainderVacationDay!='0' || response.data[index].mainRemainderVacationDay!='0') && response.data[index].remaindeChernobylAccidenDay=='0'){

                                chernobylAccident='0';
                            }

                            if(response.data[index].additionalRemainderVacationDay=='0' && response.data[index].mainReminderVacationDay!='0'){

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
                            var commonChild14_2=parseInt(response.data[index].child142);
                            var commonChild14_3=parseInt(response.data[index].child143);
                            var commonWorkConditionDay=parseInt(response.data[index].workConditionDay);
                            var maxExperinceDay=parseInt(response.data[index].experienceDay)+parseInt(response.data[index].remaindeExperienceDay);
                            tableBody=tableBody+'<tr>' +
                                '<td><input type="checkbox" class="fromDateCheck" rel="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 fromDate form-control p-2 pl-0" value="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 toDate form-control p-2 pl-0 pr-0" value="'+response.data[index].toDate+'"></td>' +
                                '<td><input type="number"  class="experienceDay col-md-12 form-control p-2" min="0" max="'+maxExperinceDay+'" value="'+(parseInt(response.data[index].experienceDay)-parseInt(response.data[index].remaindeExperienceDay))+'"></td>' +
                                '<td><input type="number"  class="child_14_12 col-md-12 form-control p-2" min="0" value="'+(parseInt(response.data[index].child142)-parseInt(response.data[index].remaindeChild142))+'"></td>' +
                                '<td><input type="number"  class="child_14_13 col-md-12 form-control p-2" min="0" value="'+response.data[index].child143+'"></td>' +
                                '<td><input type="number"  class="workConditionDay col-md-12 form-control p-2" min="0" value="'+response.data[index].workConditionDay+'"></td>' +
                                '<td><input type="number" class="remainderExperienceDay col-md-12 form-control p-2" min="0" max="'+maxExperinceDay+'" value="'+response.data[index].remaindeExperienceDay+'"></td>' +
                                '<td><input type="number" class="remainderChild_14_12 col-md-12 form-control p-2" min="0" value="'+response.data[index].remaindeChild142+'"></td>' +
                                '<td><input type="number" class="remainderChild_14_13 col-md-12 form-control p-2" min="0" value="'+response.data[index].remaindeChild143+'"></td>' +
                                '<td><input type="number" class="remainderWorkConditionDay col-md-12 form-control p-2"  min="0" value="'+response.data[index].remaindeWorkConditionDay+'"></td>' +
                                '<td><input type="number" class="commonExperienceDay col-md-12 form-control p-2" readonly value="'+commonExperienceDay+'"></td>' +
                                '<td><input type="number" class="commonChild14_2 col-md-9 form-control p-2" readonly value="'+commonChild14_2+'"></td>' +
                                '<td><input type="number" class="commonChild14_3 col-md-9 form-control p-2" readonly value="'+commonChild14_3+'"></td>' +
                                '<td><input type="number" class="commonWorkConditionDay col-md-9 form-control p-2" readonly value="'+commonWorkConditionDay+'"></td>' +

                                '</tr>';
                            var commonAllWomenDay=parseInt(response.data[index].allWomenDay);
                            var commonKvChild142=parseInt(response.data[index].kvChild142);
                            var commonKvChild143=parseInt(response.data[index].kvChild143);
                            var commonChernobylAccident=parseInt(response.data[index].chernobylAccidenDay);
                            var allKm=commonAllWomenDay+commonKvChild142+commonKvChild143+commonChernobylAccident;
                            var allKmReminder=parseInt(response.data[index].remaindeChernobylAccidenDay)+parseInt(response.data[index].remaindeAllWomenDay)+parseInt(response.data[index].kvRemaindeChild142)+parseInt(response.data[index].kvRemaindeChild143);

                            var allKmUsed=0;

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

                            var maxAllWomenDay=parseInt(allWomanDay)+parseInt(response.data[index].remaindeAllWomenDay);
                            tableBodyCollective=tableBodyCollective+'<tr>' +
                                '<td><input type="checkbox" class="fromDateCheckCollective" rel="'+response.data[index].fromDate+'"></td>' +
                                '<td><input type="text" class="col-md-12 fromDateCollective form-control p-2 pl-0" value="'+response.data[index].fromDate+'" readonly></td>' +
                                '<td><input type="text" class="col-md-12 toDateCollective form-control p-2 pl-0" value="'+response.data[index].toDate+'" readonly></td>'+
                                '<td><input type="number" class="col-md-9 allWomenDay form-control p-2 pl-0" min="0" max="'+maxAllWomenDay+'" rel="'+allWomanDay+'" value="'+allWomanDay+'" readonly></td>' +
                                '<td><input type="number" class="col-md-9 kvChild142 form-control p-2" min="0" max="'+commonKvChild142+'" rel="'+child142+'" value="'+child142+'" readonly></td>' +
                                '<td><input type="number" class="col-md-9 kvChild143 form-control p-2" min="0" max="'+commonKvChild143+'" rel="'+child143+'" value="'+child143+'" readonly></td>' +
                                '<td><input type="number" class="col-md-9 chernobylAccident form-control p-2" min="0" max="'+commonChernobylAccident+'" rel="'+chernobylAccident+'" value="'+chernobylAccident+'" readonly></td>' +
                                '<td><input type="number" class="col-md-9 remaindeAllWomenDay form-control p-2" min="0" max="'+commonAllWomenDay+'" rel="'+response.data[index].remaindeAllWomenDay+'" value="'+response.data[index].remaindeAllWomenDay+'" readonly></td>' +
                                '<td><input type="number" class="col-md-9 kvRemaindeChild142 form-control p-2" min="0" max="'+commonKvChild142+'" rel="'+response.data[index].kvRemaindeChild142+'" value="'+response.data[index].kvRemaindeChild142+'" readonly></td>' +
                                '<td><input type="number" class="col-md-9 kvRemaindeChild143 form-control p-2" min="0" max="'+commonKvChild143+'" rel="'+response.data[index].kvRemaindeChild143+'" value="'+response.data[index].kvRemaindeChild143+'" readonly></td>' +
                                '<td><input type="number" class="col-md-12 remaindeChernobylAccidenDay form-control p-2" min="0" max="'+commonChernobylAccident+'" rel="'+response.data[index].remaindeChernobylAccidenDay+'" value="'+response.data[index].remaindeChernobylAccidenDay+'" readonly></td>' +
                                '<td><input type="number" class="commonAllWomenDay col-md-12 form-control p-2" readonly rel="'+commonAllWomenDay+'" value="'+commonAllWomenDay+'" readonly></td>' +
                                '<td><input type="number" class="commonKvChild142 col-md-9 form-control p-2" readonly rel="'+commonKvChild142+'" value="'+commonKvChild142+'" readonly></td>' +
                                '<td><input type="number" class="commonKvChild143 col-md-9 form-control p-2" readonly rel="'+commonKvChild143+'" value="'+commonKvChild143+'" readonly></td>' +
                                '<td><input type="number" class="commonChernobylAccident col-md-9 form-control p-2" readonly rel="'+commonChernobylAccident+'" value="'+commonChernobylAccident+'" readonly></td>' +

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

                            data = data + '<td><input type="number" class="col-md-12 form-control p-2 chosenAmount" data-name="chosenAmount[]" data-rel="' + (index + 1) + '" min="0"  value="0"  max="' + selectedMaxData + '" required disabled rel="' + response.data[index].con + '"></td>';

                            data = data + '<td><input type="number" class="col-md-12 form-control p-2"  value="'+currentVacation+'"  required disabled rel="' + currentVacation + '"></td>';
                            data = data + '<td><input type="number" class="col-md-12 kmVacation form-control p-2"  readonly value="'+allKm+'"></td>';

                            data = data + '<td><input type="number" class="col-md-12 kmReminderVacation form-control p-2"  readonly value="'+allKmReminder+'"></td>';
                            data = data + '<td><input type="number" class="col-md-12 kmUsedVacation form-control p-2"  readonly value="'+allKmUsed+'"></td>';
                            data=data+'<td style="width:70px"><input type="text" rel="'+index+'" class="col-md-12 form-control p-2 pl-0 pr-0 mainVacationDate" name="vacationStartDate[]"></td>' +
                                '<td><input type="text" rel="'+index+'" class="col-md-12 pl-0 pr-0 form-control p-2 additionalVacationDate" id="additionalVacation" name="vacationEndDate[]" style="float:right;width:70px"></td>';
                            data = data + '<td style="display:none">'+hiddenForKm+'<input type="number" class="col-md-8 form-control p-2  rmainVacation" readonly data-name="rmainVacation[]" style="width:73px"></td>';
                            data = data + '<td><input type="number" class="col-md-8 form-control p-2" readonly style="width:73px"></td>';
                            data = data + '</tr>';

//                        if (index != 0) {

                            chosenData = chosenData + '<div class="row"><div class="col-md-4 row"><div class="col-md-6"><input type="text" class="col-md-12 form-control pl-1 pr-1 mt-35" readonly value="' + response.data[index].fromDate + '"></div><div class="col-md-6"><input type="text" class="col-md-12 form-control pl-1 pr-1 mt-35" readonly value="' + response.data[index].toDate + '"></div></div><div class="col-md-4"><h4>Məzuniyyətin başlama vaxtı:</h4><input type="text" class="col-md-12 form-control mainVacationDate" rel="'+index+'" name="vacationStartDate[]"></div>';

                            chosenData = chosenData + '<div class="col-md-4"><h4>Məzuniyyətin bitmə vaxtı:</h4><input type="text" class=" col-md-12 form-control additionalVacationDate" id="additionalVacation" name="vacationEndDate[]"></div></div>';

//                        }
//                        }

                        });
                        $('.fillArchTable').html('');
                        $('.fillArchTable').html(data+'<input type="hidden" id="hiddenEdit" value="hidden" name="hiddenEdit">');
                        $('.fillDates').html(chosenData);

                        $('.mainVacationDate').datepicker({
                            orientation: "top",
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            todayHighlight: true,

                        });

                        var tableCollectiveAggrement='<table class="table"><tr><td colspan="2">Kollektiv müqaviləyə uyğun əlavə məzuniyyət növləri</td><td>Gün sayı</td></tr>';


                        $('.vacationForCollectiveAggrementTable').html(tableHead+tableBody+'</tbody></table>');


                        $('.collectiveAggrementTypesTable').html(tableCollectiveHead+tableBodyCollective+'</tbody></table>');


                    }
                    thatD.replaceWith('<input type="hidden" id="hiddenEdit" value="hidden" name="hiddenEdit">');
                },
                error: function (err) {

                    throw new Error('Error getting additional days: ' + err);

                }
            });
        })

    })

</script>
<script src="{{asset('js/custom/pages/orders/vacation/vacation.js')}}"></script>