<!-- Special work graphics Modal -->
@include('components.modal-header' , ['id' => 'special-work-graphics','mdlTitle' => 'Xüsusi iş qrafiki'])
<div class="col-lg-4 col-xl-4 float-left m-t-5">
    <h4 >Həftənin günləri</h4>
    <select class="form-control" data-plugin="select2">
        <option value="AK">Seçilməyib</option>
        <option value="HI">mmmm</option>
    </select>
</div>
<div class="col-lg-4 col-xl-4 float-left m-t-5">
    <h4 >İşin başlama vaxtı</h4>
    <div class="input-group clockpicker-wrap" data-plugin="clockpicker">
        <input type="text" class="form-control">
        <span class="input-group-addon">
                <span class="md-time"></span>
            </span>
    </div>
</div>
<div class="col-lg-4 col-xl-4 float-left m-t-5 ">
    <h4>İşin bitmə vaxtı</h4>
    <div class="input-group clockpicker-wrap" data-plugin="clockpicker">
        <input type="text" class="form-control">
        <span class="input-group-addon">
                 <span class="md-time"></span>
            </span>
    </div>
</div>
@include('components.modal-footer')
<!-- End Modal -->