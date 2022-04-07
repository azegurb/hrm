
{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'certificate-search','sname' => 'c-search' , 'pid' => 'certificate_pagination' , 'pname' => 'c-pagination'])
{{--End Filters--}}
@if(count($new) > 0)
<table class="table">
    <thead>
    <tr>
        <th class="table-width-5">№</th>
        <th>Sertifikatın adı</th>
        <th>Bal (qiymət, dərəcə)</th>
        <th>Verilmə tarixi</th>
        <th>Təşkilatın adı </th>
        <th class="text-right table-width-8"></th>
    </tr>
    </thead>
    <tbody>
        @foreach($new as $newNC)
            @include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['name','value','issueDate','orgName']])
        @endforeach
    </tbody>
</table>
@endif
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead >
    <tr>
        <th class="table-width-5">№</th>
        <th>Sertifikatın adı</th>
        <th>Bal (qiymət, dərəcə)</th>
        <th>Verilmə tarixi</th>
        <th>Təşkilatın adı </th>
        <th class="text-right table-width-8"></th>
    </tr>
    </thead>
    <tbody id="mainTbody" class="tr-pro">
        @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
            @foreach($data -> data as $key => $value)
                <tr id="{{$value->id}}">
                    <td style="width: 3%;">{{++$key}}</td>
                    <td style="width: 25%;">{{$value->name}}</td>
                    <td style="width: 10%;">{{$value->value}}</td>
                    <td style="width: 10%;">{{$value->issueDate}}</td>
                    <td>{{$value->orgName}}</td>
                    <td class="text-nowrap text-right">
                        <button type="button" class="btn btn-sm btn-icon btn-flat btn-default waves-effect" data-toggle="tooltip" onclick="editData('{{route('certificates.edit' , $value->id)}}' , 'certificates')" data-original-title="Düzəliş et">
                            <i class="icon md-edit" aria-hidden="true">
                            </i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-flat btn-default waves-effect" data-toggle="tooltip"  onclick='removeData($(this) , "{{route('certificates.destroy' , $value->id)}}" )' data-original-title="Sil">
                            <i class="icon md-delete" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                @if(!is_null($value->nc))
                    @include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['name','value','issueDate','orgName']])
                @endif
            @endforeach
        @else
            <tr align="center"><td class="alert alert-warning" colspan="6">Məlumat daxil edilməmişdir!</td></tr>
        @endif
    </tbody>
</table>
{{--/Table--}}
{{-- Pagination load more button --}}
@include('components.pagination' , ['id' => 'certificate_pagination','url' => route('certificates.index') , 'totalCount' => $data->totalCount,'page' => $page])
{{-- /Pagination load more button --}}

<!-- Modal Qualification Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'certificates','mdlTitle' => 'Sertifikatların qeydiyyatı ekranı', 'pid'=> 'certificate_pagination' , 'mdUrl' => route('certificates.store') , 'tb' => 'mainTbody'])
<div class="container">
    <div class="row">
        <div class="col-md-6 pull-l m-t-20">
            <h4>Sertifikatın adı: </h4>
            <input type="text" id="certificate-name" name="certificateName" class="form-control" required="required">
        </div>
        <div class="col-md-6 pull-l m-t-20">
            <h4>Bal (qiymət, dərəcə): </h4>
            <input type="text" id="mark" name="certificateDegree" class="form-control" required="required">
        </div>
        <div class="col-md-6 pull-l m-t-20">
            <h4>Təşkilatın adı: </h4>
            <input type="text" id="company-name" name="orgName" class="form-control" required="required">
        </div>
        <div class="col-md-6 pull-l m-t-20">
            <h4>Verilmə tarixi: </h4>
            <input type="text"  name="issueDate" class="form-control date_id-picker" required="required">
        </div>
        <div class="col-md-12 pull-l m-t-20">
            <div class="alert alert-info">
                <strong>Qeyd: </strong>faylın ölçüsü 3 MB-dan böyük olmamalıdır.
                Yalnız "doc, docx, pdf, txt, png və jpeg" tipli faylların yüklənilməsinə icazə verilir.
            </div>
        </div>
        {{--<div class="col-md-12 pull-l m-t-20">--}}
        {{--<form class="upload-form" id="exampleUploadForm" method="POST">--}}
        {{--<input type="file" id="inputUpload" name="files[]" multiple="" />--}}
        {{--<div class="uploader-inline">--}}
        {{--<p class="upload-instructions">Faylları sürüşdürüb atın yada üstünə vuraraq seçin.</p>--}}
        {{--</div>--}}
        {{--<div class="file-wrap container-fluid">--}}
        {{--<div id="file-list" class="file-list row"></div>--}}
        {{--</div>--}}
        {{--</form>--}}
        {{--</div>--}}
    </div>
</div>
@include('components.modal-footer')

<!-- /Modal -->


{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#certificates">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}
<script src="{{asset('js/custom/plugins/pagination/paginate.js')}}"></script>
<script src="{{asset('js/custom/plugins/search.js')}}"></script>
<script src="{{asset('js/custom/plugins/page-row/certificate-row.js')}}"></script>
<script>
    $('#certificate-search').search('certificate-search','certificate_pagination');
    $('#certificate_pagination').pagination('load','certificate_pagination','certificate-search');

    $(".date_id-picker").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekStart: 1
    });
</script>



