@include('components.modal-header' , ['id' => 'provision-modal','mdlTitle' => 'Təhkim olunmuş invetarların qeydiyyatı ekranı', 'mdUrl' => route('provision.store')])
<div class="col-lg-6  pull-l m-t-20 float-left" >
    <h4 >Əlaqənin növü:</h4>
    <select class="form-control select" id="listContactType" data-url="{{route('listContactController.get')}}" name="listcontacttype" required="required">
    </select>
</div>
<div class="col-lg-6  pull-l m-t-20 float-left  ">
    <h4 >Əlaqə:</h4>
    <input type="text" class="form-control" id="inputPlaceholder" name="contactinfo" required="required">
</div>
@include('components.modal-footer')