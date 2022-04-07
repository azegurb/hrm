@include('components.modal-header' , ['id' => 'family-modal','mdlTitle' => 'Ailə tərkibi', 'mdUrl' => route('family.store')])
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div  class="row">
    <div class="col-lg-12 col-md-12 ">
        <h4 style="font-size:15px">Qohumluğun dərəcəsi:</h4>
        <select class="form-control select" id="familyRelationTypes" name="familyRelationTypeId" required="required" data-url="{{ route('family-relation-types.list') }}">
            <option></option>
        </select>
    </div>
    <div class="col-lg-4 col-xs-4 mt-20" >
        <h4 style="font-size:15px">Ad:</h4>
        <input type="text" class="form-control" name="firstName" id="inputPlaceholdera" required="required">
    </div>
    <div class="col-lg-4 col-xs-4 mt-20" >
        <h4 style="font-size:15px">Soyad:</h4>
        <input type="text" class="form-control" name="lastName" id="inputPlaceholders" required="required">
    </div>
    <div class="col-lg-4 col-xs-4 mt-20" >
        <h4 style="font-size:15px">Atasının adı:</h4>
        <input type="text" class="form-control" name="fathersName" id="inputPlaceholderd" required="required">
    </div>
    <div class="col-lg-6 col-xs-6 mt-20">
        <h4 style="font-size: 15px;">Doğulduğu tarix</h4>
        <div class=" input-group">
            <span class=" input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
            <input style="font-size: 15px;" type="text" class="date_id form-control" name="birthDate" data-plugin="datepicker" required="required">
        </div>
    </div>
    <div class="col-lg-6 col-xs-6 mt-20" >
        <h4 style="font-size:15px">Doğulduğu yer:</h4>
        <input type="text" class="form-control" id="inputPlaceholder" name="birthPlace" required="required">
    </div>
    <div class="col-lg-12 col-md-12 mt-20" >
        <h4 style="font-size:15px">İş yeri və vəzifəsi:</h4>
        <input type="text" class="form-control" id="inputPlaceholderw" name="position" required="required">
    </div>
    <div class="col-lg-12 col-md-12 mt-20" >
        <h4 style="font-size:15px">Yaşadığı ünvan:</h4>
        <input type="text" class="form-control" id="inputPlaceholderaddress" name="address" required="required">
    </div>
</div>
@include('components.modal-footer')