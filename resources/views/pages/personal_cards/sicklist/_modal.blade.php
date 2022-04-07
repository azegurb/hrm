<!-- Modal -->
@include('components.modal-header' , ['id' => 'sicklist-modal', 'tb' => 'sick' , 'mdlTitle' => 'Xəstəlik vərəqələrinin qeydiyyatı ekranı', 'mdUrl' => route('sicklist.store') , 'pid' => 'sicklist_pagination' , ''])
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div class="col-lg-6  pull-l m-t-20 float-left">
    <h4 >Xəstəlik vərəqəsini verən orqan:</h4>
    <input  type="text" class="form-control" id="inputPlaceholder" name="organizationName" required="required">
</div>
<div class="col-lg-3 pull-l m-t-20 float-left ">
    <h4 >Başlama tarixi:</h4>
    <div class="input-group">
        <span class="input-group-addon" id="startdate-con">
            <i class="icon md-calendar" aria-hidden="true"></i>
        </span>
        <input  type="text" class="form-control sick-list-date" data-plugin="datepicker" name="startDate" required="required">
    </div>
</div>
<div class="col-lg-3  pull-l m-t-20 float-left ">
    <h4 >Bitmə tarixi:</h4>
    <div class="input-group">
        <span class="input-group-addon" id="enddate-con">
            <i class="icon md-calendar" aria-hidden="true"></i>
        </span>
        <input  type="text" class="form-control sick-list-date" data-plugin="datepicker" name="endDate" required="required">
    </div>
</div>


<div class="col-lg-12  pull-l m-t-20  ">
    <h4 class="form_head_margin side_h_style ">Qeyd:</h4>
    <textarea  class="form-control" maxlength="100" rows="3" name="note" required="required"></textarea>
</div>
@include('components.modal-footer')
