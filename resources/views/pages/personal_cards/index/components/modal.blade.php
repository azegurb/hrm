{{--<script>--}}

    {{--$(document).ready(function(){--}}


        {{--var bul='{{ json_encode($data->permission[0]->accesible) }}';--}}
        {{--if(bul=='false'){--}}

            {{--$('#usersModal_form').find('button[type="submit"]').html('Təsdiqə göndər')--}}
        {{--}--}}

    {{--})--}}
{{--</script>--}}

<link rel="stylesheet" href="{{ asset('core/global/vendor/switchery/switchery.css') }}">
<div class="row">
    <div class="col-md-12">
        <div class="row pl-20 pr-20" id="doc-area">
            <div class="panel col-md-12  float-left p-0">
                <div class="col-md-4 pr-5" style="display: inline-block">
                    <label class="col-md-12 pl-0"><h4>Şəxsiyyət vəsiqəsinin seriyası və nömrəsi:</h4></label>

                    <div class="form-group">
                        <div class="col-md-2 pl-0 pr-0 float-left">
                            <input type="text" class="form-control" name="docSeries" id="inpPassportSerial" value="{{ !empty($data->data) && !empty($data->data->docSeries) ? $data->data->docSeries : 'AZE' }}"
                                   placeholder="AZE">
                        </div>
                        <div class="input-group pl-0 pr-0 col-md-10 float-left" id="serialAreaa">
                            <input type="number" class="form-control" name="docNumber" placeholder="1234567" value="{{ !empty($data->data) && !empty($data->data->docNumber) ? $data->data->docNumber : '' }}">

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary waves-effect" id="getUserData"><i class="icon md-search" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                {{--@php(dd($data->permission[0]->accesible))--}}
                <div class="col-md-6 float-right">
                    <div class="col-md-4 pl-0 pr-10 float-left">
                        <label class="col-md-12 pl-0"><h4>Vəsiqəni verən orqan:</h4></label>
                        <div class="form-group">
                            <input type="text" id="get_from" class="form-control" name="docOrgan" placeholder="ASAN-1" required="required" value="{{ !empty($data->data) && !empty($data->data->docOrgan) ? $data->data->docOrgan : '' }}">
                        </div>
                    </div>
                    <div class="col-md-4 pl-0 pr-5 float-left">
                        <label class="col-md-12 pl-0"><h4>Tarix:</h4></label>
                        <div class=" input-group">
                            <input type="text" class="date_id form-control" name="docIssueDate" id="issue_date required="required""
                            data-plugin="datepicker" value="{{ !empty($data->data) && !empty($data->data->docIssueDate) ? $data->data->docIssueDate : '' }}">
                        </div>
                    </div>
                    <div class="col-md-4 pl-5 pr-5 float-left">
                        <label class="col-md-12 pl-0"><h4>FİN:</h4></label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="pin" id="fin" placeholder="AZE1234" required="required" {{ !empty($data->data) && !empty($data->data->pin) ? 'readonly' : '' }} value="{{ !empty($data->data) && !empty($data->data->pin) ? $data->data->pin : '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ml-1 mr-1 mt-20" id="users_personal_info_container">
            <div class="col-md-12 col-lg-12 col-sm-12 pl-5 pr-5">
                <!-- Şəxsiyyəti təsdiq edən sənəd haqqında məlumatlar -->
                <div class="panel panel-primary panel-line mb-5">
                    <div class="panel-body m-0 p-0">
                        <div class="col-md-6 float-left border-r">
                            <div class="row mb-5">
                                <div class="col-md-4 pr-5">
                                    <h4>Soyadı:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="last" placeholder="Soyad" name="lastName" required="required" value="{{ !empty($data->data) && !empty($data->data->lastName) ? $data->data->lastName : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-0 pr-0">
                                    <h4>Adı:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="first" placeholder="Ad" name="firstName" required="required" value="{{ !empty($data->data) && !empty($data->data->firstName) ? $data->data->firstName : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-5 pr-0">
                                    <h4>Atasının adı:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="patronymic" placeholder="Ata adı" name="patronymic" required="required" value="{{ !empty($data->data) && !empty($data->data->patronymic) ? $data->data->patronymic : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-3 pr-5">
                                    <h4>Doğum tarixi:</h4>
                                    <div class=" input-group">
                                        <input type="text" class="date_id form-control" id="birth" name="birthDate" required="required" value="{{ !empty($data->data) && !empty($data->data->birthDate) ? $data->data->birthDate : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-0 pr-5">
                                    <h4>Doğum yeri:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <input type="text" class="form-control" id="bplace" placeholder="Azərbaycan, Bakı şəh." name="birthPlace" required="required" value="{{ !empty($data->data) && !empty($data->data->birthPlace) ? $data->data->birthPlace : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2 pl-0 pr-5">
                                    <div class="form-group mb-5 pr-5">
                                        <h4>Cinsi:</h4>
                                        <select class="form-control " id="genderi" name="gender" data-url="" required="required">
                                            <option value="F" {{ !empty($data->data) && !empty($data->data->gender) && $data->data->gender == false ? 'selected' : '' }}>Qadın</option>
                                            <option value="M" {{ !empty($data->data) && !empty($data->data->gender) && $data->data->gender == true ? 'selected' : '' }}>Kişi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-0 pl-0">
                                    <h4>Ailə vəziyyəti:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <select class="form-control select" id="closedi" data-url="{{route('family')}}" name="familyStatusId" required="required">
                                            @if(!empty($data) && !empty($data->data->familyStatusIdId))
                                                <option value="{{$data->data->familyStatusIdId}}" selected>{{$data->data->familyStatusIdName}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pr-5">
                                    <h4>Milliyəti:</h4>
                                    <div class="form-group mb-5 pr-5">
                                        <select class="form-control " id="nationalityi" name="listNationalityId" required="required" data-url="{{route('nationality')}}">
                                            @if(!empty($data) && !empty($data->data->listNationalityIdId))
                                                <option value="{{$data->data->listNationalityIdId}}" selected>{{$data->data->listNationalityIdName}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 pr-0 pl-0">
                                    <h4>Qeydiyyat ünvanı:</h4>
                                    <div class="form-group mb-30 pr-5">
                                        <input type="text" class="form-control" id="regResidence" name="registrationAddress" placeholder="Azərbaycan, Bakı şəh." required="required" value="{{ !empty($data->data) && !empty($data->data->registrationAddress) ? $data->data->registrationAddress : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pl-15 pr-0">
                                    <h4 class="float-left mr-15">Cinayət məsuliyyətinə cəlb edilmisinizsə nə zaman və hansı səbəbə görə:</h4>
                                    <input type="checkbox" class="js-switch-small float-left" name="criminalType" id="checkBox" required="required" {{ !empty($data->data) && $data->data->criminalType != null ? 'checked' : '' }}/>
                                    <div class="form-group mb-10 pr-5">
                                        <input type="text" class="form-control" id="busted" placeholder="..." data-inner="" name="criminalNote"  {{ !empty($data->data) && !empty($data->data->criminalNote) && $data->data->criminalType != null ? 'required="required"' : 'disabled="disabled"' }} value="{{ !empty($data->data) && !empty($data->data->criminalNote) && $data->data->criminalType != null ? $data->data->criminalNote : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 float-left right-panel pr-0">
                            <div class="row mb-5">
                                <div class="col-md-4 pl-5 pr-5">
                                    <h4>SSN:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" id="ssn" class="form-control" name="ssn" placeholder="00000000000000000" required="required"v value="{{ !empty($data->data) && !empty($data->data->ssn) ? $data->data->ssn : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 pl-5 pr-5">
                                    <h4>Bank hesabı:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" id="bankaccount" class="form-control" name="bankaccount" placeholder="0" required="required"v value="{{ !empty($data->data) && !empty($data->data->bankAccount) ? $data->data->bankAccount : '' }}">
                                    </div>
                                </div>

                            </div>


                            <div class="row mb-5">
                                <div class="col-md-12 pl-5 pr-5" >
                                    <h4 class="float-left mr-10">Soyadınızı, adınızı dəyişmisinizsə, nə vaxt və hansı səbəbə:</h4>
                                    <input type="checkbox" class="js-switch-small float-left" id="lastNameBefore" name="lastNameBeforeType" required="required" {{ !empty($data->data) && $data->data->lastNameBeforeType != null ? 'checked' : '' }}/>
                                    <div class="form-group mb-5">
                                        <input type="text" class="form-control" data-inner="" name="lastNameBefore" id="isChanged" placeholder="..." {{ !empty($data->data) && !empty($data->data->lastNameBefore) && $data->data->lastNameBeforeType != null ? 'required="required' : 'disabled="disabled"' }} value="{{ !empty($data->data) && !empty($data->data->lastNameBefore) && $data->data->lastNameBeforeType != null ? $data->data->lastNameBefore : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pl-5 pr-5">
                                    <h4>Yaşadığı ünvan:</h4>
                                    <div class="form-group mb-5">
                                        <input type="text" class="form-control" id="actualResidence" name="residenceAddress" placeholder="Az. Bakı şəh." required="required" value="{{ !empty($data->data) && !empty($data->data->residenceAddress) ? $data->data->residenceAddress : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 pl-5 pr-5">
                                    <h4>H.İ üzvü:</h4>
                                    <div class="form-group mb-5">
                                        <input type="checkbox" class="js-switch-small1 float-left" id="isTradeUnion" name="isTradeUnion" required="required" {{ !empty($data->data) && $data->data->totalCountAttached>0 ? 'checked' : '' }}>
                                        {!!  isset($data->data->startDateId) ? '<input type="hidden" style="display:none" name="startDateId" id="startDateId" value="'. $data->data->startDateId.'">' : '' !!}
                                    </div>
                                </div>
                                <div class="col-md-3 pl-5 pr-5">
                                    <h4 class="tradeuniniondiv">Başlama tarixi</h4>
                                    <div class="form-group mb-5" id="startdiv">
                                        {!!  !empty($data->data) && $data->data->totalCountAttached>0 ? '<input type="text" class="start_date_id form-control" id="startDate" name="startDate" required="required" value="'. $data->data->startDate.'">' : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 float-right pl-5 pr-10 mt-30 img-container">
                            <label for="changedPhoto" class="photo-label">
                                <span id="photo-label-text">Şəkil seçimi</span>
                                <img class="img-rounded img-bordered img-bordered-primary personal-img"
                                     src="{{!empty($data->data) && $data->data->photo != null ?'data:image/png;base64,'.$data->data->photo : asset('media/noavatar.png')}}" id="userPicture" alt="">
                            </label>
                            <input type="file" style="display: none" id="changedPhoto" name="changedPhoto">
                            <input type="hidden" name="photo" value="{{!empty($data->data) && $data->data->photo != null ? $data->data->photo : ''}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('core/global/vendor/switchery/switchery.min.js')}}"></script>
<script src="{{ asset('js/custom/pages/personal_cards/getUserData.js')}}"></script>
<script src="{{ asset('js/custom/pages/personal_cards/modal-statements.js')}}"></script>
<script src="{{asset('core/global/vendor/moment/moment.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var elem = document.querySelector('.js-switch-small1');

        var init = new Switchery(elem , {size : 'small', color :'#3f51b5'});

        $('body').on('change', '#isTradeUnion', function () {
            if(this.checked==true){

                $('.tradeuniniondiv').html('Başlama tarixi');
                $('#startdiv').html('<input type="text" class="start_date_id form-control" id="birth" name="startDate" required="required" value="">');

                $(".start_date_id").datepicker({
                    orientation: "left bottom",
                    format: 'dd.mm.yyyy',
                    weekStart: 1
                });
            }
            else {

                if($('#startDateId').length>0){
                    $('.tradeuniniondiv').html('Bitmə tarixi');

                    $('#startdiv').html('<input type="text" class="end_date_id form-control" id="endDate" name="endDate" required="required" value="">');

                    $(".end_date_id").datepicker({
                        orientation: "left bottom",
                        format: 'dd.mm.yyyy',
                        weekStart: 1
                    });
                }
                else {

                    $('#startdiv').html('');

                }


            }
        });


    });


        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
    $('body').on('focus', '.start_date_id', function () {

        $(this).datepicker({orientation: "left bottom", format: 'dd.mm.yyyy, weekstart: 1'});

    })


    $('#gender').select2();
    $('#nationalityi').selectObj('nationalityi');
    $('#closedi').selectObj('closedi');
    @if(!empty($data->data))
        modalFormUrl('{{route('users.update' , $data->data->id)}}');
    @else
        modalFormUrl();
    @endif
    // Variable to store your files
    var files;
    // Add events
    $('input#changedPhoto').on('change', prepareUpload);
    // Grab the files and set them to our variable
    function prepareUpload(event) {
        var reader = new FileReader();

        reader.onload = function (e) {
            console.log('got image ');
            $('#userPicture').attr('src', e.target.result);
        };

        reader.readAsDataURL(event.target.files[0]);
        files = event.target.files[0];
    }
</script>
</script>