<header class="slidePanel-header bg-purple-600">
    <div class="slidePanel-actions custom-x" aria-label="actions" role="group">
        <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon md-close" style="line-height: 0"
                aria-hidden="true"></button>
    </div>
    <h1>{{!empty($userInfo->data) && !empty($userInfo->data->firstName) ? $userInfo->data->firstName.' '.$userInfo->data->lastName : ''}}</h1>
</header>
@if(!empty($userInfo->data))
<div class=" container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-lg-12 col-xs-12 loader_panel">
            <div class="panel">
                <div class="example-wrap">
                    <div class="example">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-fluid" src="{{asset('media/noavatar.png')}}" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Ad:&nbsp; </h4>
                                    <h4 class="float-left"> {{$userInfo->data->firstName}}</h4>
                                </div>
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Soyad:&nbsp; </h4>
                                    <h4 class="float-left"> {{$userInfo->data->lastName}}</h4>
                                </div>
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Ata adı:&nbsp; </h4>
                                    <h4 class="float-left"> {{$userInfo->data->patronymic}}</h4>
                                </div>
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Doğum tarixi:&nbsp; </h4>
                                    <h4 class="float-left"> {{$userInfo->data->birthDate}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-md-12">
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Anadan olduğu yer:&nbsp; </h4>
                                    <h4 class="float-left"> {{$userInfo->data->birthPlace}}</h4>
                                </div>
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Ailə vəziyyəti: &nbsp;</h4>
                                    <h4 class="float-left"> {{$userInfo->data->familyStatusIdName}}</h4>
                                </div>
                                <div class="col-md-12 float-left">
                                    <h4 class="float-left"> Qeydiyyat ünvanı: &nbsp;</h4>
                                    <h4 class="float-left"> {{$userInfo->data->registrationAddress}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif