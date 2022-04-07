<style type="text/css">
    .bold {
        font-weight: bold !important;
    }

    .list-group-item > span {
        display: block;
        width: 100%;
    }

    .content-info {
        float: right;
        /*width: 600px;*/
    }

</style>

<div class="card card-inverse card-shadow bg-white mb-5">
    <div class="card-block p-30">
        <a class="avatar avatar-100 float-left mr-20" href="javascript:void(0)">
            @if($user->userIdPhoto)
                <img src="data:image/jpg;base64,{{$user->userIdPhoto}}" alt="emekdash">
            @else
                <img src="{{asset('media/noavatar.png')}}" alt="">
            @endif
        </a>
        <div class="vertical-align text-right text-truncate">
            <div class="vertical-align-middle">
                <div class="font-size-20 mb-5 blue-600 text-truncate">
                    {{ $user->userIdLastName . ' ' .$user->userIdFirstName . ' ' . $user->userIdPatronymic }}
                </div>
                <div class="font-size-15 mb-5 text-truncate">{{ $position->structureIdName }}</div>
                <div class="font-size-14 text-truncate">
                    <i class="icon md-account"></i> &nbsp;
                    {{ $position->posNameIdName }}
                </div>
                <div class="pdf-exp-div mt-10">
                    <a href="/accounting/export/get-individual-template?userId={{$user->userIdId}}&year={{$user->userPaymentsIdYear}}&month={{$user->userPaymentsIdMonth}}" target="_blank" class="export-pdf">
                        <i class="icon md-print"></i> Çap et
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-shadow mb-5">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-primary panel-line">
                <div class="panel-heading" style="cursor: pointer;" onclick="$('.table-work-details').slideToggle();">
                    <h3 class="panel-title">
                        <i class="icon fa fa-clock-o"></i>
                        İş günləri və saatları
                    </h3>
                </div>
                <div class="table-responsive table-work-details">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>Ümumi iş günləri</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">
                                    {{ $user->userPaymentsIdWorkDayNorm or 0 }} gün / {{ $user->userPaymentsIdWorkDayHourNorm or 0 }} saat
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>İşlədiyi günlər</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">
                                    {{ $user->userPaymentsIdWorkDayFact or 0 }} gün / {{ $user->userPaymentsIdWorkHourFact  or 0 }}  saat
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Bayram günləri</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">
                                    {{ $user->userPaymentsIdWorkHollidayDay or 0 }} gün / {{ $user->userPaymentsIdWorkHollidayHour  or 0 }}  saat
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Gecə növbəsi (axşam)</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">
                                    {{ $user->userPaymentsIdWorkNightHour1  or 0 }}  saat
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Gecə növbəsi (gecə)</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">
                                    {{ $user->userPaymentsIdWorkNightHour2  or 0 }}  saat
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Gecə növbəsi (cəmi)</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">
                                    {{ $user->userPaymentsIdWorkNightHour  or 0 }}  saat
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="card card-shadow mb-5">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-primary panel-line">
                <div class="panel-heading" style="cursor: pointer;" onclick="$('.table-payment-details').slideToggle();">
                    <h3 class="panel-title">
                        <i class="icon fa fa-money"></i>
                        Ödənişlər  ( {{ getMonth($user->userPaymentsIdMonth) }}, {{ $user->userPaymentsIdYear }} )
                        <span class="badge badge-outline pull-r badge-{{ $user->userPaymentsIdIsPaid ? 'success' : 'danger' }}">
                            {{ $user->userPaymentsIdIsPaid ? 'Ödənilib' : 'Ödənilməyib' }}
                        </span>
                    </h3>
                </div>
                <div class="table-responsive table-payment-details">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>Vəzifə maaşı</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->salary or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Güzəşt</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->privilegeSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Əlavə əmək haqqı</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->addPaymentSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Əmək şəraitinə görə əlavə əmək haqqı</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->laborConditionsSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Gecə növbəsinə görə</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->workNightHourSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Bayram günlərinə görə</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->workHollidaySum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-900">Cəmi hesablanıb</td>
                            <td class="font-weight-900 text-right">
                                {{ $user->endCalcSum or 0 }} AZN
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Avans</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->advanceSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Vergi</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->taxSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>DSMF</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->spfSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Həmkarlar ittifaqı</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-outline">{{ $user->tradeUnionSum or 0 }} AZN</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-900">Cəmi tutulmuşdur</td>
                            <td class="font-weight-900 text-right">
                                {{ $user->totalDeductSum or 0 }} AZN
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-900 font-size-20"> {{ $user->userPaymentsIdIsPaid ? 'Ödənilib' : 'Ödənilməlidir' }} </td>
                            <td class="font-weight-900 font-size-20 text-right">
                                {{ $user->totalPaymentSum or 0 }} AZN
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>