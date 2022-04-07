<div class="container-salary">

    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <label for="searchField"></label>
                <div class="input-search">
                    <button type="submit" class="input-search-btn">
                        <i class="icon md-search" aria-hidden="true"></i>
                    </button>
                    <input type="text" id="searchField" class="form-control table-filter" name=""
                           placeholder="Axtarış...">
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="year"></label>
                <select id="year" class="form-control select">
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="month"></label>
                <select id="month" class="form-control select">
                    <option value="01"> Yanvar</option>
                    <option value="02"> Fevral</option>
                    <option value="03"> Mart</option>
                    <option value="04"> Aprel</option>
                    <option value="05"> May</option>
                    <option value="06"> İyun</option>
                    <option value="07"> İyul</option>
                    <option value="08"> Avqust</option>
                    <option value="09"> Sentyabr</option>
                    <option value="10"> Oktyabr</option>
                    <option value="11"> Noyabr</option>
                    <option value="12"> Dekabr</option>
                </select>
            </div>
        </div>

        <div class="col-md-6 text-right">

            <div class="btn-payment-action-group mt-20">

                <button type="button"
                        title="Hesablama prosesini başladın"
                        class="btn btn-success btn-calculate btn-payment-op ladda-button"
                        data-style="expand-right"
                        data-plugin="ladda">
                        <span class="ladda-label">
                            <i class="icon md-mail-send mr-10" aria-hidden="true"></i>Hesablamağa başla
                        </span>
                    <span class="ladda-spinner"></span>
                </button>

                <button type="button"
                        title="Cari ay üçün ödənişləri bağlayın"
                        class="btn btn-close btn-payment-op ladda-button"
                        data-style="slide-right"
                        data-plugin="ladda">
                        <span class="ladda-label">
                            <i class="icon md-close" aria-hidden="true"></i>Bağla
                        </span>
                    <span class="ladda-spinner"></span>
                </button>

                <button type="button" class="btn btn-icon btn-export-excel btn-primary waves-effect"
                        title="Məlumatları EXCEL fayla yükləyin">
                    <i class="icon md-download" aria-hidden="true"></i>
                </button>

            </div>

            <div class="pickerdate"></div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="table-responsive table-payments">
                <table class="table table-payments table-hover table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>A.S.A</th>
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
                    </thead>
                    <tbody>

                    @php $monthIsClosed = false; @endphp

                    @if(!empty($users))

                        @php $monthIsClosed = $users[0]->userPaymentsIdIsPaid; @endphp

                        @foreach($users as $key => $user)

                            <tr id="{{$user->userIdId}}" data-payment-date="{{$user->userPaymentsIdPaymentDate}}"
                                class="data-user">
                                <td>
                                    <div class="checkbox-custom checkbox-refresh checkbox-primary" style="margin-top: 0 !important;">
                                        <input type="checkbox" id="check-{{$key}}">
                                        <label for="check-{{$key}}"></label>
                                    </div>
                                </td>
                                <td>{{   $user->userIdLastName. ' '
                                        .$user->userIdFirstName.' '.
                                         $user->userIdPatronymic }}          </td>

                                <td>
                                    {{ $user->userPaymentsIdWorkDayNorm or 0 }} gün / {{ $user->userPaymentsIdWorkDayHourNorm or 0 }} saat
                                </td>
                                <td>
                                    {{ $user->userPaymentsIdWorkDayFact or 0 }} gün / {{ $user->userPaymentsIdWorkHourFact  or 0 }} saat
                                </td>
                                <td>{{ $user->salary or 0 }} AZN</td>
                                <td>{{ $user->advanceSum or 0 }} AZN</td>
                                <td>{{ $user->addPaymentSum or 0 }} AZN</td>
                                <td>{{ $user->laborConditionsSum or 0 }} AZN</td>
                                <td>{{ $user->endCalcSum   or 0 }} AZN</td>
                                <td>{{ $user->privilegeSum or 0 }} AZN</td>
                                <td>{{ $user->taxSum or 0 }} AZN</td>
                                <td>{{ $user->spfSum or 0 }} AZN</td>
                                <td>{{ $user->tradeUnionSum or 0 }} AZN</td>
                                <td>{{ $user->totalDeductSum or 0 }} AZN</td>
                                <td>{{ $user->totalPaymentSum or 0 }} AZN</td>
                                <td>
                                    <span class="badge badge-outline badge-{{ $user->userPaymentsIdIsPaid ? 'success' :'danger' }}">
                                        {{ $user->userPaymentsIdIsPaid ? 'Ödənilib' :'Ödənilməyib' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="22" class="text-center">Məlumat daxil edilməyib</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- site action -->
    <div class="site-action" style="display: none;">
        <button id="btn-refresh"
                title="Seçilmiş istifadəçiləri yeniləyin"
                class="btn btn-floating btn-primary waves-effect"
                type="button"
                data-style="slide-right">
            <span class="ladda-label">
                <i class="icon md-refresh" aria-hidden="true"></i>
            </span>
            <span class="ladda-spinner"></span>
        </button>
    </div>

    <div class="row mt-20">

        <nav class="col-md-12">

            <ul class="pagination salary-pagination" data-total="{{$total or 0}}" data-limit="{{$limit or 0}}"
                data-page="{{$page or 0}}"></ul>

        </nav>

    </div>

    <script src="{{asset('js/custom/pages/accounting/salary/scripts.js') }}"></script>
    <script src="{{asset('js/custom/pages/accounting/salary/functions.js') }}"></script>
    <script src="{{asset('js/custom/pages/accounting/salary/bindings.js') }}"></script>

    <script>
        monthIsClosed = '{{ $monthIsClosed }}';
        togglePaymentButtons();
    </script>

</div>