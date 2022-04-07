@include('components.modal-header' , ['id' => 'note','mdlTitle' => 'Xüsusi qeydlər' , 'mdUrl' => route('note.store') , 'pid' => 'note_paginate' , 'tb' => 'tableBody'])
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div class="row">
    <div class="col-md-12 col-xs-12">
        <h4 class="form_head_margin side_h_style " style="font-size: 15px;">Qeyd:</h4>
        <textarea style="padding-bottom:0px" name="note"
                  class="maxlength-textarea form-control"
                  data-plugin="maxlength" data-placement="bottom-right-inside"
                  maxlength="100" rows="3" required="required"></textarea>
    </div>
    <div class="col-lg-6 col-xs-6 mt-20">
        <h4 style="font-size: 15px;">Tarix:</h4>
        <div class=" input-group">
                <span class=" input-group-addon">
                    <i class="icon md-calendar" aria-hidden="true"></i>
                </span>
            <input type="text" class="date_id form-control"  name="noteDate" required="required">
        </div>
    </div>
    <div class="col-md-12 pull-l m-t-20">
        <div class="alert alert-info">
            <strong>Qeyd:</strong>faylın ölçüsü 3 MB-dan böyük olmamalıdır.
            Yalnız "doc, docx, pdf, txt, png və jpeg" tipli faylların yüklənilməsinə icazə verilir.
        </div>
    </div>
    <div class="col-md-12 pull-l m-t-10">
        <!-- <form class="upload-form" id="exampleUploadForm" method="POST">
            <input type="file" id="inputUpload" name="files[]" multiple=""/>
            <div class="uploader-inline">
                <p class="upload-instructions">Faylları sürüşdürüb atın yada üstünə vuraraq seçin.</p>
            </div>
            <div class="file-wrap container-fluid">
                <div id="file-list" class="file-list row"></div>
            </div>
        </form> -->
    </div>
</div>
@include('components.modal-footer')
