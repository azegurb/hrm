<section id="links">
    {{--<link rel="stylesheet" href="{{ asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.css')}}">--}}
    {{--<link rel="stylesheet" href="{{ asset('core/global/vendor/dropify/dropify.css')}}">--}}
</section>

<section id="content">

    <div class="col-lg-12 col-xs-12" id="qualification-degree">
        <div class="alert alert-info">
            <strong>Qeyd: </strong>
            Biliklər/Sertifikatlar bölməsinə - əməkdaşın dil və kompüter bilikləri, həmçinin müvafiq sahələr üzrə sertifikatları barədə məlumatlar qeyd edilir.
            Biliklər/Sertifikatlar bölməsi dil və kompüter bilikləri, həmçinin müvafiq sahələr üzrə sertifikatlar barədə məlumatlara baxmaq, əlavə etmək, dəyişmək və silməkdən ibarətdir.
        </div>
        <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
            <div class="panel-heading panel-heading-tab">
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#langpanelTab1"
                                            aria-controls="panelTab1" onclick="refresh()" role="tab" aria-expanded="true">Dil bilikləri</a>
                    </li>
                    <li class="nav-item"><a class="nav-link load-link" data-toggle="tab" href="#langpanelTab2" data-url="{{route('it-knowledge.index')}}" aria-controls="langpanelTab2"
                                            role="tab">Kompüter bilikləri</a>
                    </li>
                    <li class="nav-item"><a class="nav-link load-link" data-toggle="tab" href="#langpanelTab3" data-url="{{route('certificates.index')}}" aria-controls="langpanelTab3" role="tab">Sertifikatlar</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content" >
                    <div class="tab-pane active m-t-20" id="langpanelTab1" role="tabpanel">
                        {{--Filters--}}
                        @include('components.filter-bar' , ['sid' => 'language-search','sname' => 'l-search' , 'pid' => 'language_pagination' , 'pname' => 'l-pagination'])
                        {{--End Filters--}}

                        {{--@if(count($new) > 0)--}}
                            {{--<table class="table">--}}
                                {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th class="table-width-5">№</th>--}}
                                        {{--<th>Dillər</th>--}}
                                        {{--<th>Bacarıq səviyyəsi</th>--}}
                                        {{--<th class="text-right table-width-8"></th>--}}
                                    {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($new as $newNC)--}}
                                    {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['listLanguageId.name','listKnowledgeLevelId.name']])--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--@endif--}}

                        {{--Table--}}
                        <table class="table table-hover dataTable w-full">
                            <thead >
                                <tr>
                                    <th class="table-width-5">№</th>
                                    <th>Dillər</th>
                                    <th>Bacarıq səviyyəsi</th>
                                    <th class="text-right table-width-8"></th>
                                </tr>
                            </thead>
                            <tbody id="mainTbodyy" class="tr-pro">
                                @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
                                    @foreach($data->data as $key => $value)
                                        <tr id="{{$value->id}}">
                                        <td>{{++$key}}</td>
                                        <td>{{$value->listLanguageId->name}}</td>
                                        <td>{{$value->listKnowledgeLevelId->name}}</td>
                                        <td class="text-nowrap text-right">
                                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('language.edit' , $value->id)}}' , 'language-skills')">
                                                <i class="icon md-edit" aria-hidden="true"></i>
                                                <span class="tptext tpedit">Düzəliş et</span>
                                            </div>
                                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('language.destroy' , $value->id)}}" )'>
                                                <i class="icon md-delete" aria-hidden="true"></i>
                                                <span class="tptext tpdel">Sil</span>
                                            </div>
                                        </td>
                                        {{--@if(!is_null($value->nc))--}}
                                            {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['listLanguageId.name','listKnowledgeLevelId.name']])--}}
                                        {{--@endif--}}
                                    @endforeach
                                @else
                                    <tr align="center"><td colspan="4" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                                @endif
                            </tbody>
                        </table>
                        {{--/Table--}}
                        {{-- Pagination load more button --}}
                        @include('components.pagination' , ['id' => 'language_pagination','url' => route('language.index') , 'totalCount' => $data->totalCount,'page' => $page])
                        {{-- /Pagination load more button --}}
                        {{--Slide Panel Trigger--}}
                        <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
                             data-selectable="selectable">
                            <button type="button" class="btn btn-floating btn-info waves-effect"
                                    data-toggle="modal" id="language-modal-init" data-target="#language-skills">
                                <i class="icon md-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                        {{--Slide Panel Trigger--}}
                    </div>
                    <div class="tab-pane m-t-20" id="langpanelTab2" role="tabpanel"></div>
                    <div class="tab-pane m-t-20" id="langpanelTab3" role="tabpanel"></div>
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
    {{--@include('pages.personal_cards.common', ['modalid'=>'language-skills_form'])--}}
    @include('components.modal-footer')



</section>

<section id="scripts">
    <script src="{{asset('core/global/js/Plugin/responsive-tabs.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/tabs.js')}}"></script>
    {{--<script src="{{asset('core/global/vendor/jquery-ui/jquery-ui.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-tmpl/tmpl.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-load-image/load-image.all.min.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-process.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-image.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-validate.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-ui.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/dropify/dropify.min.js')}}"></script>--}}
    {{--<script src="{{asset('core/assets/examples/js/forms/uploads.js')}}"></script>--}}
    <script src="{{asset('js/custom/plugins/loader.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/language-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/refresh.js')}}"></script>
    <script>
        function confirmation(elem,isC,id){
            $.ajax({
                url:'/personal-cards/contact-confirm/'+id+'/'+isC+'/',
                type: 'GET',
                success: function(response){
                    if(response == 200){
                        $('[href="/personal-cards/contacts"]').click();
                    }
                }
            });
        }
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