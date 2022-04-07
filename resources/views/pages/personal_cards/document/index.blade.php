<section id='links'>
    {{--<link rel="stylesheet" href="{{ asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.css')}}">--}}
    {{--<link rel="stylesheet" href="{{ asset('core/global/vendor/dropify/dropify.css')}}">--}}
</section>
<section id='content'>
    <div class="col-lg-12 col-xs-12" id="qualification-degree">
        <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
            <div class="panel-body">
                <div class="tab-pane active m-t-20" id="panelTab1" role="tabpanel">
                    {{--Filters--}}
                    @include('components.filter-bar' , ['sid' => 'document-search','sname' => 'doc-search' , 'pid' => 'document_pagination' , 'pname' => 'doc-pagination'])
                    {{--End Filters--}}
                    {{--Table--}}
                    <table class="table table-hover dataTable w-full" data-plugin="dataTable">
                        <thead >
                        <tr>
                            <th class="table-width-5">№</th>
                            <th>Sənədin növü</th>
                            <th>Verilmə tarixi</th>
                            <th class="text-right table-width-8"></th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@if(count($new) > 0)--}}
                            {{--@foreach($new as $newNC)--}}
                                {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listDocumentTypeId.name','issueDate']])--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                        @if($data->totalCount > 0)
                            @foreach($data->data as $key => $value)
                                <tr id="{{$value->id}}">
                                    <td>{{++$key}}</td>
                                    <td>{{$value->listDocumentTypeId->name}}</td>
                                    <td>{{$value->issueDate}}</td>
                                    <td class="text-nowrap text-right">
                                        @if($value->file)
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="fileDownload('{{$value->id}}' , 'document')">
                                            <i class="icon md-file" aria-hidden="true"></i>
                                            <span class="tptext tpedit">Fayl</span>
                                        </div>
                                        @endif
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('document.edit' , $value->id)}}' , 'document')">
                                            <i class="icon md-edit" aria-hidden="true"></i>
                                        <span class="tptext tpedit">Düzəliş et</span>
                                        </div>
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('document.destroy' , $value->id)}}" )'>
                                            <i class="icon md-delete" aria-hidden="true"></i>
                                        <span class="tptext tpdel">Sil</span>
                                        </div>
                                    </td>
                                </tr>
                                {{--@if(!is_null($value->nc))--}}
                                    {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listDocumentTypeId.name','issueDate']])--}}
                                {{--@endif--}}
                            @endforeach
                        @else
                            <tr align="center"><td colspan="4" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                        @endif
                        </tbody>
                    </table>
                    {{-- Pagination load more button --}}
                    @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
                    @include('components.pagination' , ['id' => 'document_pagination','url' => route('document.index') , 'totalCount' => $data->totalCount,'page' => $page])
                    @endif
                    {{-- /Pagination load more button --}}
                    {{--/Table--}}
                    {{--Slide Panel Trigger--}}
                    <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
                         data-selectable="selectable" data-id="23">
                        <button type="button" class="btn btn-floating btn-info waves-effect"
                                data-toggle="modal" data-target="#document">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                    {{--Slide Panel Trigger--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Education Add/Edit Modal-->

    @include('components.modal-header' , ['id' => 'document','mdlTitle' => 'Sənədlərin qeydiyyatı ekranı' ,  'mdUrl' => route('document.store') , 'custom' => 'postForm($(this),"refresh",true)'])
    <div class="col-md-6 pull-l mt-20">
        <h4 >Sənədin növü: </h4>
        <select id="doc-type" name="doctype" class="form-control select" data-url="{{route('documtent-type')}}" required="required"></select>
    </div>
    <div class="col-md-6 pull-l mt-20">
        <h4 for="doc-number">Sənədin nömrəsi: </h4>
        <input type="text" id="doc-number" name="docnum" class="form-control" required="required">
    </div>
    <div class="col-lg-6 pull-l col-md-6 col-xl-6 float-left mt-20">
        <h4>Verildiyi tarix: </h4>
        <input type="text" id="doc-date" name="docIssueDate" class="form-control date-picker date_id">
    </div>
    <div class="col-md-12 pull-l mt-20">
        <div class="alert alert-info">
            <strong>Qeyd: </strong>faylın ölçüsü 3 MB-dan böyük olmamalıdır.
            Yalnız "doc, docx, pdf, txt, png və jpeg" tipli faylların yüklənilməsinə icazə verilir.
        </div>
    </div>
    <div class="col-md-12 float-left">
        <div class="form-group">
            <div class="input-group input-group-file" data-plugin="inputGroupFile">
                <input type="text" class="form-control" readonly="">
                <span class="input-group-btn">
              <span class="btn btn-success btn-file">
                <i class="icon md-upload" aria-hidden="true"></i>
                <input type="file" name="file">
              </span>
            </span>
            </div>
        </div>
    </div>
    {{--<div class="col-md-12 pull-l mt-10">--}}
        {{--<form class="upload-form file-upload" id="exampleUploadForm" method="POST">--}}
            {{--<input type="file" id="inputUpload" name="files[]" multiple="" />--}}
            {{--<div class="uploader-inline">--}}
                {{--<p class="upload-instructions">Faylları sürüşdürüb atın yada üstünə vuraraq seçin.</p>--}}
            {{--</div>--}}
            {{--<div class="file-wrap container-fluid">--}}
                {{--<div class="file-list2 row"></div>--}}
            {{--</div>--}}
        {{--</form>--}}
    {{--</div>--}}
    {{--<div class="col-md-12 pull-l m-t-20">--}}
        {{--<div class="alert alert-info">--}}
            {{--<strong>Qeyd: </strong>faylın ölçüsü 3 MB-dan böyük olmamalıdır.--}}
            {{--Yalnız "doc, docx, pdf, txt, png və jpeg" tipli faylların yüklənilməsinə icazə verilir.--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-12 pull-l m-t-10">--}}
        {{--<form class="upload-form file-upload" id="exampleUploadForm" method="POST">--}}
            {{--<input type="file" id="inputUpload" name="files[]" multiple="" />--}}
            {{--<div class="uploader-inline">--}}
                {{--<p class="upload-instructions">Faylları sürüşdürüb atın yada üstünə vuraraq seçin.</p>--}}
            {{--</div>--}}
            {{--<div class="file-wrap container-fluid">--}}
                {{--<div class="file-list2 row"></div>--}}
            {{--</div>--}}
        {{--</form>--}}
    {{--</div>--}}
    @include('components.modal-footer')

    @include('components.modal-header' , ['id' => 'document-file','mdlTitle' => 'Fayllar' ,  'mdUrl' => 'javascript:void(0)' , 'custom' => 'return false;'])

    <div class="panel">
        <div class="table-responsive h-250 scrollable is-enabled scrollable-vertical" data-plugin="scrollable" style="position: relative;">
            <div data-role="container" class="scrollable-container">
                <div data-role="content" class="scrollable-content" id="download-modal-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Fayl</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="scrollable-bar scrollable-bar-vertical scrollable-bar-hide" draggable="false"><div class="scrollable-bar-handle" style="height: 168.524px; transform: translate3d(0px, 73.3441px, 0px);"></div></div></div>
    </div>

    @include('components.modal-footer')
</section>

<section id='scripts'>
    {{--File Uploader--}}
    <script src="{{asset('js/custom/plugins/page-row/document-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/fileDownload.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/input-group-file.js')}}"></script>
    <script src="{{asset('js/custom/plugins/refresh.js')}}"></script>
    {{--<script src="{{asset('core/global/vendor/blueimp-tmpl/tmpl.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-load-image/load-image.all.min.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-process.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-image.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-audio.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-video.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-validate.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-ui.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/dropify/dropify.min.js')}}"></script>--}}
    {{--/File Uploader--}}
    {{--<script src="{{asset('core/assets/examples/js/forms/uploads.js')}}"></script>--}}

    {{----}}
    <script>
        $('#doc-type').selectObj('doc-type');
        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
//        $('#exampleUploadForm').uploaderC('exampleUploadForm');
        $('#contact-search').search('document-search','document_pagination');
        $('#contacts_paginate').pagination('load','document_pagination','document-search');
        // Variable to store your files
        var files;
        // Add events
        $('input[type=file]').on('change', prepareUpload);
        // Grab the files and set them to our variable
        function prepareUpload(event) {
            files = event.target.files[0];
        }
    </script>

</section>