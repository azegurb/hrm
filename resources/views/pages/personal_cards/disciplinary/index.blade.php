<section id='links'>
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.css')}}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/dropify/dropify.css')}}">
</section>
<section id='content'>
    <div class="col-lg-12 col-xs-12">
        <div class="alert alert-info">
            <strong>Qeyd: </strong>
            İntizam məsuliyyəti/Xidməti araşdırma bölməsinə - əməkdaşın intizam məsuliyyətinə cəlb edilməsi və onun barəsində hər hansı xidməti araşdırmanın aparılması,
            həmçinin xəbərdarlıq edilməsi barədə məlumatlar qeyd edilir.
        </div>
        <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
            <div class="panel-heading panel-heading-tab">
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#disciplinarypanelTab1"
                                            aria-controls="panelTab1" role="tab" aria-expanded="true">İntizam məsuliyyəti</a>
                    </li>
                    <li class="nav-item"><a class="nav-link load-link" data-toggle="tab" href="#warningtab" data-url="{{route('it-knowledge.index')}}" aria-controls="langpanelTab2"
                                            role="tab">Xəbərdarlıqlar</a>
                    </li>

                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active m-t-20" id="disciplinarypanelTab1" role="tabpanel">
                        {{--Table--}}
                        @include('pages.personal_cards.disciplinary._disciplininary-responsibility' , ['modalid'=>'disciplinary-responsibility_form', 'data' => $data])
                        {{--/Table--}}
                    </div>
                    <div class="tab-pane m-t-20" id="warningtab" role="tabpanel">
                        {{--Filters--}}
                        @include('components.filter-bar' , ['sid' => 'itskills-search','sname' => 'i-search' , 'pid' => 'itskills_pagination' , 'pname' => 'i-pagination'])
                        {{--End Filters--}}
                        {{--Table--}}
                        {{--@include('pages.personal_cards.common', ['modalid'=>'it-knowledge-modal'])--}}
                        <table class="table table-hover dataTable w-full">
                            <thead >
                            <tr>
                                <th class="table-width-5">№</th>
                                <th>Əmr nömrəsi</th>
                                <th>Əmr tarixi</th>
                                <th>Təqdimatı təqdim edən əməkdaş</th>
                            </tr>
                            </thead>
                            <tbody id="tb" class="tr-pro">
                                @foreach($data2->data as $key=>$single_data)
                                    <tr id="">
                                        <td>{{$key+1}}</td>
                                        <td>{{$single_data->orderCommonId->orderNum}}</td>
                                        <td>{{date("d.m.Y", strtotime($single_data->orderCommonId->orderDate))}}</td>
                                        <td>{{$single_data->executorUserIdFirstName}} {{$single_data->executorUserIdLastName}} {{$single_data->executorUserIdPatronymic}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            {{-- Tabs --}}
            {{--<div class="tab-pane active m-t-20" id="disciplinarypanelTab1" role="tabpanel">--}}
                {{--Table--}}
                {{--@include('pages.personal_cards.disciplinary._disciplininary-responsibility' , ['modalid'=>'disciplinary-responsibility_form', 'data' => $data])--}}
                {{--/Table--}}
            {{--</div>--}}
        </div>
    </div>
</section>

<section id='scripts'>

    {{--File Uploader --}}
    <script src="{{asset('core/global/vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('js/custom/plugins/compiled/disciplinary.js')}}"></script>
    {{--<script src="{{asset('core/global/vendor/blueimp-tmpl/tmpl.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js')}}"></script>--}}
    <script src="{{asset('core/global/vendor/blueimp-load-image/load-image.all.min.js')}}"></script>
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-process.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-image.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-audio.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-video.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-validate.js')}}"></script>--}}
    {{--<script src="{{asset('core/global/vendor/blueimp-file-upload/jquery.fileupload-ui.js')}}"></script>--}}
    <script src="{{asset('core/global/vendor/dropify/dropify.min.js')}}"></script>
    {{--/File Uploader --}}

    {{--<script src="{{asset('core/global/js/Plugin/dropify.js')}}"></script>--}}
    {{--<script src="{{asset('core/assets/examples/js/forms/uploads.js')}}"></script>--}}
    <script src="{{asset('js/custom/plugins/compiled/disciplinary-second.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/disciplinary_paginate.js')}}"></script>
    {{--/Date Picker--}}
    <script>
        $('.date-picker').datepicker({
            format: 'dd.mm.yyyy',
            language: 'az',
            clearBtn: true,
            todayHighlight: true,
            weekStart: 1,
            autoclose: true
        });
        $('#dis-res-search').search('dis-res-search','disciplinary_paginate','{{route('disciplinary-type')}}',{change:true});
        $('#honor_rewards_pagination').pagination('load','disciplinary_paginate','dis-res-search');
        //File Uploader trigger
        $('#exampleUploadForm').uploaderC('exampleUploadForm');
        $('#exampleUploadForm2').uploaderC('exampleUploadForm2');
    </script>

</section>