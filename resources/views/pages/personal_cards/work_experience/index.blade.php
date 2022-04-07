<section id="links">
    <link rel="stylesheet" href="{{asset('core/global/vendor/typeahead-js/typeahead.css')}}">
    <link rel="stylesheet" href="{{asset('css/external_plugins/print.min.css')}}">
</section>

<section id="content">
    {{--Is staji--}}
    <div class="row">
        <div class="col-lg-12  ">
            <div class="panel  ">
                {{--<div class="panel  panel-primary panel-line ">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h4 class="panel-title "><b>İş stajı</b></h4>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body ">--}}
                        {{--<table class="table table-bordered table-hover table-striped dataTable no-footer"--}}
                               {{--data-plugin="dataTable">--}}
                            {{--<thead>--}}

                            {{--</thead>--}}
                        {{--</table>--}}
                        {{--<hr></hr>--}}
                        {{--<div style="font-size:12px; color: #f44336">--}}
                            {{--<strong>Qeyd:</strong>--}}
                            {{--Əmək kitabçasına və ya stajı təsdiq edən müvafiq sənədlərə əsasən,--}}
                            {{--əməkdaşın iş yerləri, işə başladığı və işdən çıxdığı tarix,--}}
                            {{--təyin olunması barədə əmrin nömrəsi və tarixi, vəzifəsi,--}}
                            {{--əmək müqaviləsinin növü və müddəti,--}}
                            {{--dövlət qulluğu vəzifəsinə təyin olunduqda isə vəzifə təsnifatı barədə yeni məlumat daxil--}}
                            {{--edilməlidir.--}}
                            {{--Əmək fəaliyyəti haqqında məlumat daxil edildikdə sırada ilk olaraq birinci iş yeri və--}}
                            {{--axırıncı olaraq da cari iş yeri görsənir.--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            </div>
        </div>
    </div>

    {{--Tabs--}}
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-heading panel-heading-tab">
            <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#panelTab1" aria-controls="work-experience-panelTab1" role="tab" aria-expanded="true">
                        Əmək fəaliyyəti-
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body pt-20 pb-0">
            <div class="tab-content">
                <div class="tab-pane active" id="panelTab1" role="tabpanel">
                    @if(count($dataNC->data) > 0)
                        <table class="table" style="border: 1px solid #ffe0b2;border-radius: 3px">
                            <thead>
                            <tr>
                                <td colspan="12" class="text-center alert alert-warning" style="font-size: 20px">
                                    <strong>Təsdiqə göndərilmişlər</strong>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-width-5">№</th>
                                <th>Vəzifə</th>
                                <th>İş Yeri</th>
                                <th>Struktur</th>
                                <th>Əmrin növü</th>
                                <th>Əmrin nömrəsi</th>
                                <th>Əmrin Tarixi</th>
                                <th>Müqavilə</th>
                                <th>Başlama tarixi</th>
                                <th>Bitmə tarixi</th>
                                <th>Digər Struktur</th>
                                <th class="table-width-8"></th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($dataNC->data as $key => $valueNC)
                                {{--@php($valueNC->id = $valueNC->mainId->id != null ? $valueNC->mainId->id : (int)$valueNC->provisionId->id)--}}
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$valueNC->positionId->posNameId->name}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$valueNC->positionId->orderCommonId->listOrderTypeId->name}}</td>
                                    <td>{{$valueNC->positionId->orderCommonId->orderNum}}</td>
                                    <td>{{$valueNC->positionId->orderCommonId->orderDate}}</td>
                                    <td></td>
                                    <td>{{!empty($valueNC->startDate) ? $valueNC->startDate : ''}}</td>
                                    <td>{{!empty($valueNC->endDate) ? $valueNC->endDate : ''}}</td>
                                    <td>{{$valueNC->differentOrg ? 'Fərqli Struktur' : 'Cari Struktur'}}</td>
                                    <td>{{$valueNC->differentOrg ? 'Fərqli Struktur' : 'Cari Struktur'}}</td>
                                    <td>
                                        <div class="submit-confirm"  style="display: {{$nc ? '' : 'none'}};display: flex">
                                            <button type="button" class="btn btn-sm btn-success mr-5" onclick="confirmationWorkExp($(this),'true','{{$valueNC->id}}','{{$valueNC->customConfirmId}}')">Təsdiqlə</button>
                                            <button type="button" class="btn btn-sm btn-danger ml-5" onclick="confirmationWorkExp($(this),'false','{{$valueNC->id}}','{{$valueNC->customConfirmId}}')">İmtina</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                    <table class="table w-full">
                        <tr>
                            <th class="table-width-5">№</th>
                            <th>Vəzifə</th>
                            <th>İş Yeri</th>
                            <th>Struktur</th>
                            <th>Əmrin növü</th>
                            <th>Əmrin nömrəsi</th>
                            <th>Əmrin Tarixi</th>
                            <th>Müqavilə</th>
                            <th>Başlama tarixi</th>
                            <th>Bitmə tarixi</th>
                            <th>Digər Struktur</th>
                            <th class="table-width-8"></th>
                        </tr>
                        <tbody id="workExperience">
                        @if($data->totalCount > 0)
                            @foreach($data->data as $key => $value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$value->positionName}}</td>
                                    <td>{{$value->organizationName}}</td>
                                    <td>@if(isset($value->relOrganizationStructuresName))@if($value->relOrganizationStructuresName != null) {{$value->relOrganizationStructuresName->structuresNameId->name }}@endif @endif</td>
                                    <td>{{$value->orderTypeName}}</td>
                                    <td>{{$value->orderNum}}</td>
                                    <td>{{$value->orderDate}}</td>
                                    <td>{{$value->contractTypeName}}</td>
                                    <td>{{!empty($value->startDate) ? $value->startDate : ''}}</td>
                                    <td>{{!empty($value->endDate) ? $value->endDate : ''}}</td>
                                    <td>{{$value->differentOrg ? 'Fərqli Struktur' : 'Cari Struktur'}}</td>
                                    <td class="text-nowrap text-right">
                                        @if(!$value->differentOrg)
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="getFile('{{route('work-experiences.get-file' , [$value->id, selected()->userId ])}}')">
                                            <i class="icon md-file-text" aria-hidden="true"></i>
                                            <span class="tptext tpedit" style="width: 120px">Əmək müqaviləsi</span>
                                        </div>
                                        @endif
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal('{{route('work-experience.edit' , $value->id)}}{{$value->differentOrg? '?diff=true' : ''}}' , 'work-experiance-modal')">
                                            <i class="icon md-edit" aria-hidden="true"></i>
                                            <span class="tptext tpedit">Düzəliş et</span>
                                        </div>
                                        {{--<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this) , "{{route('work-experience.destroy' , $value->id)}}" )'>--}}
                                            {{--<i class="icon md-delete" aria-hidden="true"></i>--}}
                                            {{--<span class="tptext tpdel">Sil</span>--}}
                                        {{--</div>--}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr align="center"><td colspan="12" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="site-action">
                        <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{route('work-experience.create')}}', 'work-experiance-modal')" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <!-- Isden azadolunmalar -->
            </div>
        </div>
    </div>
    <!-- Modal -->

    @include('components.modal-header' , ['id' => 'work-experiance-modal', 'tb' => 'workExperience' ,'mdlTitle' => 'Əmək fəaliyyəti','custom' => 'postForm($(this) , "refresh")', 'mdUrl' => route('work-experience.store')])
    @include('components.modal-footer')
    <!-- Modal Ends Here -->
    @include('components.filedoc')
    @php($modalid='work-experiance-modal_form')
    {{--@include('pages.personal_cards.common', ['modalid'=>'work-experiance-modal_form'])--}}
</section>
<section id='scripts'>
    <script src="{{ asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script src="{{ asset('js/custom/pages/work-experience/modal-statements.js')}}"></script>
    <script src="{{ asset('js/custom/pages/work-experience/getFile.js')}}"></script>
    <script src="{{ asset('js/custom/plugins/refresh.js')}}"></script>

    <script>
        function confirmationWorkExp(elem,isC,id,ccid){
            $.ajax({
                url:'/personal-cards/work-exp-confirmation/'+id+'/'+isC+'/'+ccid,
                type: 'GET',
                success: function(response){
                    console.log(response);
                    if(response == 200){
                        $('[href="/personal-cards/work-experience"]').click();
                    }
                }
            });
        }
    </script>

</section>