<div class="panel mb-0">
    <a class="nav-link btn btn-default btn-sm float-right personal-info-exit" id="clearUser" data-toggle="tab" href="#panelTab1"
       aria-controls="panelTab1" role="tab" aria-expanded="true">
        <span class="text hidden-sm-down"><i class="icon md-close" style="font-size: 20px" aria-hidden="true"></i></span>
    </a>
    <div class="panel-body pb-0 pl-10 pr-10"  id="personalGeneralInfo">
        <div class="row ml-1 mr-1">
            <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                <!-- Şəxsiyyəti təsdiq edən sənəd haqqında məlumatlar -->
                <div class="panel panel-primary panel-line mb-5">
                    <div class="panel-heading">
                        <div class="row mb-5">
                            <div class="col-md-2 pr-5 pl-10">
                                <h4 class="panel-title pl-10 personal-info-title float-left">Şəxsi məlumatlar</h4>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect personal-info-edit float-left mt-15" id="users-edit-data" onclick="{{!empty(selected()->userId) ?  "openModal('/get-user-by-id/'.".selected()->userId.".'/responseHttp')' , 'usersModal')" : "" }}">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                </div>
                                <input type="hidden" id="userlongid">
                            </div>
                            <div class="col-md-2"></div>
                            <div class="pr-5 pl-10 mt-5 user-avatar-toggler" style="display: none">
                                    <span class="avatar">
                                        <img class="img-rounded img-bordered img-bordered-primary personal-img"
                                             src="" alt="" id="personal-img-t">
                                    </span>
                            </div>
                            <div class="col-md-3 pr-5 pl-10 user-avatar-toggler" style="display: none">
                                <h4 class="mt-20 float-left mr-10" id="first-t"></h4>
                                <h4 class="mt-20 float-left mr-10" id="last-t"></h4>
                                <h4 class="mt-20 float-left" id="patronymic-t"></h4>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="float-right pr-0">
                                <div class="panel-actions">
                                    <a style="font-weight: bold" class="panel-action icon md-minus" id="userInfoToggler" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body m-0 p-0">
                        <div class="col-md-6 float-left border-r pl-10">
                            <div class="row mb-5">
                                <div class="col-md-4 pr-5">
                                    <h4 class="example-title">Soyadı:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="last" placeholder="Soyad" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-0 pr-0">
                                    <h4 class="example-title">Adı:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="first" placeholder="Ad" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-5 pr-0">
                                    <h4 class="example-title">Atasının adı:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="patronymic" placeholder="Ata adı" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-3 pr-5">
                                    <h4 class="example-title">Doğum tarixi:</h4>
                                    <div class=" input-group">
                                        <input type="text" class="date_id form-control" id="birth" data-plugin="datepicker" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-0 pr-5">
                                    <h4 class="example-title">Doğum yeri:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="bplace" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-2 pl-0 pr-5">
                                    <div class="form-group mb-5 pr-5">
                                        <h4 class="example-title">Cinsi:</h4>
                                        <input type="text" class="form-control" id="genderin" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-3 pr-0 pl-0">
                                    <h4 class="example-title">Ailə vəziyyəti:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="closed" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pr-5">
                                    <h4 class="example-title">Milliyəti:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="nationality" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-8 pr-0 pl-0">
                                    <h4 class="example-title">Qeydiyyat ünvanı:</h4>
                                    <div class="form-group pr-5">
                                        <input type="text" class="form-control" id="regResidence" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pl-15 pr-0 mt-5">
                                    <h4 class="example-title">Cinayət məsuliyyətinə cəlb edilmisinizsə nə zaman və hansı səbəbə görə:</h4>
                                    <div class="form-group mb-10 pr-5">
                                        <input type="text" class="form-control" id="busted" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 float-left" style="max-width:36%">
                            <div class="row mb-5">
                                <div class="col-md-4 pl-5 pr-5">
                                    <h4 class="example-title">SSN:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" id="ssn" class="form-control" placeholder="00000000000000000" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-5 pl-5 pr-5">
                                    <h4 class="example-title">Bank hesabı:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" id="bankaccount" class="form-control" placeholder="00000000000000000" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-3 pl-5 pr-5">
                                    <h4 class="example-title">H.İ üzvü:</h4>
                                    <div class="form-group mb-5">
                                        <div class="tradediv">

                                        </div>

                                       <div style="display: none"> <input type="checkbox" class="js-switch-small float-left" id="isTradeUnion" name="isTradeUnion" disabled required="required" {{ !empty($data->data) && $data->data->totalCount != 1 ? 'checked' : '' }}/></div>

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-12 pl-5 pr-5">
                                    <h4 class="example-title">Soyadınızı, adınızı dəyişmisinizsə, nə vaxt və hansı səbəbə:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" class="form-control" id="isChanged" placeholder="..." disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pl-5 pr-5">
                                    <h4 class="example-title">Yaşadığı ünvan:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" class="form-control" id="actualResidence" placeholder="Az. Bakı şəh." disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 float-right pl-5 pr-10 img-container">
                            <img class="img-rounded img-bordered img-bordered-primary personal-img"
                                 id="personal-img" src="{{asset('media/noavatar.png')}}" alt="">

                        </div>
                        <div class="col-md-6 float-left mt-10">
                            <div class="row">
                                <div class="col-md-4 pl-5 pr-5">
                                    <h4 class="example-title">Ş.V. №:</h4>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="inpPassportSerial" disabled="disabled"
                                               placeholder="AZE">
                                        <input type="text" class="form-control" id="inpPassportNumber" disabled="disabled"
                                               placeholder="00000000">
                                    </div>
                                </div>
                                <div class="col-md-3 pl-0 pr-5">
                                    <h4 class="example-title">FİN:</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="fin" placeholder="AZE1234" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-2 pl-0 pr-5">
                                    <h4 class="example-title">Tarix:</h4>
                                    <div class=" input-group">
                                        <input type="text" class="date_id form-control" id="issue_date"
                                               data-plugin="datepicker" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-3 pl-0 pr-10">
                                    <h4 class="example-title">Vəsiqəni verən orqan:</h4>
                                    <div class="form-group">
                                        <input type="text" id="get_from" class="form-control" placeholder="ASAN-1" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


