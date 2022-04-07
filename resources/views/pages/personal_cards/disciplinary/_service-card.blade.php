{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'serv-search','sname' => 'se-search' , 'pid' => 'serv-pagination' , 'pname' => 'se-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead >
    <tr>
        <th>№</th>
        <th>Tarix</th>
        <th>Nəticə</th>
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
            data-toggle="modal" data-target="#disciplinary-service-card">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}

<!-- Modal Qualification Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'disciplinary-service-card','mdlTitle' => 'Xidməti vəsiqələr'])
                <div class="col-md-12 pull-l m-t-20">
                    <h4>Qeyd: </h4>
                    <textarea type="text" id="disciplinary-service-card-ntoe" class="form-control" required="required"></textarea>
                </div>
                <div class="col-md-6 pull-l m-t-20">
                    <h4>Tarix: </h4>
                    <input type="text" id="disciplinary-service-card-date" class="form-control date-picker" required="required">
                </div>
                <div class="col-md-12 pull-l m-t-20">
                    <div class="alert alert-info">
                        <strong>Qeyd: </strong>faylın ölçüsü 3 MB-dan böyük olmamalıdır.
                        Yalnız "doc, docx, pdf, txt, png və jpeg" tipli faylların yüklənilməsinə icazə verilir.
                    </div>
                </div>
                <div class="col-md-12 pull-l m-t-10">
                    <form class="upload-form file-upload" id="exampleUploadForm2" method="POST">
                        <input type="file" id="inputUpload2" name="files[]" multiple="" />
                        <div class="uploader-inline">
                            <p class="upload-instructions">Click Or Drop Files To Upload.</p>
                        </div>
                        <div class="file-wrap container-fluid">
                            <div class="file-list2 row"></div>
                        </div>
                    </form>
                </div>
@include('components.modal-footer')
<!-- /Modal -->