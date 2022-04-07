@include('components.modal-header' , ['id' => 'trip-modal','mdlTitle' => 'Ezamiyyət','mdUrl' => route('business-trip.store')])
<input type="hidden" name="idField">
<div>
    <div class="col-md-12 float-left mb-20">
        <h4>Əmr:</h4>
        <select name="order" id="order" data-url="{{route('orders.select')}}" required="required"></select>
    </div>
</div>
<div class="col-md-8 float-left">
    <h4>Başlama &mdash; Bi̇tmə tari̇xi̇:</h4>
    <div class="input-daterange" data-plugin="datepicker">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
            <input type="text" class="form-control date date_id" name="start" required="required"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">&mdash;</span>
            <input type="text" class="form-control date_id" name="end" required="required"/>
        </div>
    </div>
</div>
<div class="col-md-4 float-left">
    <h4>Müddət:</h4>
    <input type="number" name="tripTime" class="form-control" required="required">
</div>
<div class="col-md-12 float-left"></div>
<div id="placeselection" style="display: block">
    <div class="col-md-4 float-left mt-20">
        <h4>Ölkə:</h4>
        <select name="country" id="country" data-url="{{url('orders/list-countries')}}" required="required"></select>
    </div>
</div>
<div class="col-md-12 float-left"></div>
<div class="col-md-12 float-left mt-20">
    <h4>Ezami̇yyəti̇n səbəbi:</h4>
    <input type="text" name="reason" class="form-control" required="required">
</div>
<div class="col-md-12 float-left mt-20">
    <h4>Qeyd:</h4>
    <textarea name="note" id="" class="form-control" cols="30" rows="2" required="required"></textarea>
</div>
@include('components.modal-footer')