<section id="links">
    {{--<link rel="stylesheet" href="{{ asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.css')}}">--}}
    {{--<link rel="stylesheet" href="{{ asset('core/global/vendor/dropify/dropify.css')}}">--}}
</section>

<section id="content">
    {{--Tabs--}}
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-heading panel-heading-tab">
            <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#salarytab0" aria-controls="salary-panelTab0" role="tab" aria-expanded="true">
                        Əmək haqqı
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#salarytab1" aria-controls="salary-panelTab1" role="tab" aria-expanded="true">
                        Ödəniş tarixçəsi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#salarytab2" aria-controls="salary-panelTab2" role="tab" aria-expanded="true">
                        Ödəniş və tutulmalar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#salarytab3" aria-controls="salary-panelTab3" role="tab" aria-expanded="true">
                        Güzəştlər
                    </a>
                </li>
            </ul>
        </div>

        <div class="panel-body p-0 pt-20">
            <div class="tab-content">
                <div class="tab-pane active" id="salarytab0" role="tabpanel">
                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th>Vəzifə maaşı</th>
                            <th>Əlavə əmək haqqı</th>
                            <th>Əmək şəraitinə görə əlavə əmək haqqı</th>
                            <th>Cəmi</th>
                            <th class="table-width-8"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$data->payments->positionPayment or 0}} AZN</td>
                            <td>{{$data->payments->userPayment or 0}} AZN</td>
                            <td>{{$data->payments->conditionalPayment or 0}} AZN</td>
                            <td>{{$data->payments->totalIncome or 0}} AZN</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="salarytab1" role="tabpanel">
                    <table class="table w-full">
                        <tr>
                            <th>Ödəniş dövrü</th>
                            <th>İş günləri/saatları</th>
                            <th>İşlədiyi günlər/saatlar</th>
                            <th>Vəzifə maaşı</th>
                            <th>Avans</th>
                            <th>Əlavə əmək haqqı</th>
                            <th>Əmək şəraitinə görə</th>
                            <th>Cəmi hesablanıb</th>
                            <th>Güzəşt</th>
                            <th>Vergi</th>
                            <th>DSMF</th>
                            <th>Həmkarlar ittifaqı</th>
                            <th>Cəmi tutulmuşdur</th>
                            <th>Ödəniş</th>
                            <th>Status</th>
                        </tr>
                        <tbody>

                        @foreach($data->salaryU as $userPayment)
                            <tr>
                                <td>
                                    {{ getMonth($userPayment->userPaymentsIdMonth) }}, {{ $userPayment->userPaymentsIdYear }}
                                </td>
                                <td>
                                    {{ $userPayment->userPaymentsIdWorkDayNorm or 0 }} gün / {{ $userPayment->userPaymentsIdWorkDayHourNorm or 0 }} saat
                                </td>
                                <td>
                                    {{ $userPayment->userPaymentsIdWorkDayFact or 0 }} gün / {{ $userPayment->userPaymentsIdWorkHourFact  or 0 }} saat
                                </td>
                                <td>{{ $userPayment->salary or 0 }} AZN</td>
                                <td>{{ $userPayment->advanceSum or 0 }} AZN</td>
                                <td>{{ $userPayment->addPaymentSum or 0 }} AZN</td>
                                <td>{{ $userPayment->laborConditionsSum or 0 }} AZN</td>
                                <td>{{ $userPayment->endCalcSum   or 0 }} AZN</td>
                                <td>{{ $userPayment->privilegeSum or 0 }} AZN</td>
                                <td>{{ $userPayment->taxSum or 0 }} AZN</td>
                                <td>{{ $userPayment->spfSum or 0 }} AZN</td>
                                <td>{{ $userPayment->tradeUnionSum or 0 }} AZN</td>
                                <td>{{ $userPayment->totalDeductSum or 0 }} AZN</td>
                                <td>{{ $userPayment->totalPaymentSum or 0 }} AZN</td>
                                <td>
                                    <span class="badge badge-outline badge-{{ $userPayment->userPaymentsIdIsPaid ? 'success' :'danger' }}">
                                        {{ $userPayment->userPaymentsIdIsPaid ? 'Ödənilib' :'Ödənilməyib' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="site-action">
                        <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{--route()--}}', 'salary-modal')" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="tab-pane" id="salarytab2" role="tabpanel">
                    <table class="table w-full">
                        <tr>
                            <th class="table-width-5">№</th>
                            <th>Adı</th>
                            <th class="table-width-8"></th>
                        </tr>
                        <tbody>
                        <tr>
                            <td colspan="3"> @include('components.under-construction') </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="site-action">
                        <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{--route()--}}', 'salary-modal')" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="tab-pane" id="salarytab3" role="tabpanel">


                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th>Adı</th>
                            <th>Güzəşt məbləği</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            @if(isset($data->privileges) && isset($data->privileges->result) && $data->privileges->result == true)
                                <td>{{$data->privileges->privilegeIdName}}</td>
                                <td>{{$data->privileges->privilegeIdValue}} AZN</td>
                            @else
                                <td class="alert alert-warning" colspan="2"> Güzəşt yoxdur!</td>
                            @endif

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--Modals--}}
<!-- Modal Qualification Add/Edit Modal-->
    @include('components.modal-header' , ['id' => 'language-skills','mdlTitle' => 'Dil biliklərinin qeydiyyatı ekranı', 'mdUrl' => route('language.store'), 'tb' => 'mainTbodyy'])
    <div class="container">
        <div class="row">
            <div class="col-md-6 pull-l">
                <h4>Dillər: </h4>
                <select id="languages" class="form-control select" data-url="{{route('listLanguageController.get')}}" name="language" required="required">
                    <option> </option>
                </select>
            </div>
            <div class="col-md-6 pull-r">
                <h4>Bacarıq səviyyəsi: </h4>
                <select id="languageLevel" class="form-control select" data-url="{{route('listKnowledgeLevelController.get')}}" name="languageLevel" required="required">
                    <option> </option>
                </select>
            </div>
        </div>
    </div>
    @include('components.modal-footer')



</section>

<section id="scripts">
    <script src="{{asset('core/global/js/Plugin/responsive-tabs.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/tabs.js')}}"></script>
    <script src="{{asset('js/custom/plugins/loader.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/language-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/refresh.js')}}"></script>
    <script>
        $('#language-search').search('language-search','language_pagination');
        $('#language-pagination').pagination('load','language_pagination','language-search');
    </script>
    <script>$('#languages').selectObj('languages')</script>
    <script>$('#languageLevel').selectObj('languageLevel')</script>


    <script src="{{asset('js/custom/plugins/page-row/certificate-row.js')}}"></script>
    <script>
        $('#certificate-search').search('certificate-search','certificate_pagination');
        $('#certificate_pagination').pagination('load','certificate_pagination','certificate-search');
    </script>

    {{----}}
    <script>
        $('.date-picker').datepicker({
            format: 'dd.mm.yyyy',
            language: 'az',
            clearBtn: true,
            todayHighlight: true,
            weekStart: 1,
            autoclose: true
        });
        //        $('#exampleUploadForm').uploaderC('exampleUploadForm');


    </script>

</section>