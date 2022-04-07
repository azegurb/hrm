{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'inv-search','sname' => 'inv-search' , 'pid' => 'inv-pagination' , 'pname' => 'i-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead >
    <tr>
        <th>№</th>
        <th>Nəticə</th>
        <th>Tarix</th>
    </tr>
    </thead>
    <tbody id="mainTbody" class="tr-pro">

    </tbody>
</table>
{{--/Table--}}
{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#disciplinary-investigation">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}

<!-- Disciplinary Investigation Add/Edit Modal-->
@include('components.modal-header' , ['mdlSize' => 'lg','id' => 'disciplinary-investigation','mdlTitle' => 'Xidməti araşdırma'])
    <div class="col-md-12 pull-l m-t-20">
        <h4>Nəticə: </h4>
        <textarea type="text" id="disciplinary-investigation-result" class="form-control" required="required"></textarea>
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Tarix: </h4>
        <input type="text" id="disciplinary-investigation-date" class="form-control date-picker" required="required">
    </div>
    <div class="col-md-12 pull-l m-t-20">
        <div class="alert alert-info">
            <strong>Qeyd: </strong>faylın ölçüsü 3 MB-dan böyük olmamalıdır.
            Yalnız "doc, docx, pdf, txt, png və jpeg" tipli faylların yüklənilməsinə icazə verilir.
        </div>
    </div>
    <div class="col-md-12 pull-l m-t-10">
        <form class="upload-form" id="exampleUploadForm" method="POST">
            <input type="file" id="inputUpload" name="files[]" multiple=""  required="required"/>
            <div class="uploader-inline">
                <p class="upload-instructions">Faylları sürüşdürüb atın yada üstünə vuraraq seçin.</p>
            </div>
            <div class="file-wrap container-fluid">
                <div id="file-list" class="file-list row"></div>
            </div>
        </form>
    </div>
@include('components.modal-footer')
<!-- /Modal -->