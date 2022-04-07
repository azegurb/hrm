@include('components.modal-header' , ['id' => 'permissions-modal','mdlTitle' => 'İcazələrin qeydiyyatı ekranı','mdUrl' => route('permission.store')])
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div class="col-md-12 float-left mt-20">
    <h4 >İcazə verən şəxs</h4>
    <select class="form-control select" id="allowerUser" data-url="{{route('users')}}" name="alloweruser" required="required">
    </select>
</div>
<div class="col-lg-4 col-xl-4 float-left mt-20">
    <h4 >İcazə səbəbi</h4>
    <select class="form-control select" id="listRequestForPermissionReason" data-url="{{route('permission.permissionReasons')}}" name="listrequestforpermissionreason" required="required">
    </select>
</div>
<div class="col-lg-4 col-xl-4 float-left mt-20">
    <h4 >İcazənin verilmə tarixi</h4>
    <div class=" input-group">
            <span class=" input-group-addon" id="startdate-con">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
            <input  type="text" class="date_id form-control" name="startdate" required="required">
    </div>
</div>
<div class="col-lg-4 col-xl-4 float-left mt-20">
    <h4 >İcazənin bitmə tarixi</h4>
    <div class=" input-group">
            <span class=" input-group-addon" id="enddate-con">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
        <div></div>
            <input  type="text" class="date_id form-control" name="enddate" required="required">
    </div>
</div>
<div class=" col-lg-8  pull-l mt-20 float-left ">
    <h4 >İcazə ilə bağlı status</h4>
    <div class="col-lg-3 pull-l mt-5 text-black">
        <div class="radio-custom radio-primary">
            <input type="radio" id="visitors" value="1" name="isapprowed"  required="required">
            <label for="visitors">Baxılmayıb</label>
        </div>
    </div>
    <div class="col-lg-3  pull-l mt-5 text-black">
        <div class="radio-custom radio-primary">
            <input type="radio" id="approval" value="2" name="isapprowed" required="required">
            <label for="approval">Təsdiq</label>
        </div>
    </div>
    <div class="col-lg-2  pull-l mt-5 text-black">
        <div class="radio-custom radio-primary">
            <input type="radio" id="refusal" value="3" name="isapprowed"  required="required">
            <label for="refusal">İmtina</label>
        </div>
    </div>
</div>
<div class="col-lg-4  float-left pull-l mt-20 ">
    <h4 >Ərizənin tarixi</h4>
    <div class=" input-group">
            <span class=" input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
        <input type="text" class="date_id form-control" data-plugin="datepicker" name="applicationdate" required="required">
    </div>
</div>
<div class="col-md-12 pull-l mt-20 float-left">
    <h4 class="form_head_margin side_h_style ">Qeyd</h4>
    <textarea class="maxlength-textarea form-control" required="required"
              data-plugin="maxlength" data-placement="bottom-right-inside" maxlength="100" rows="3" name="note"></textarea>
</div>

<script>

</script>
@include('components.modal-footer')