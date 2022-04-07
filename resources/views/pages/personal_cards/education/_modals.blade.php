<!-- Modal Education Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'education-modal','mdlTitle' => 'Təhsil haqqında məlumatların qeydiyyatı ekranı','mdUrl'=>route('education.store'), 'tb' => 'tb'])

{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div class="row">
    <div class="col-md-6 mt-20">
        <h4 >Təhsil müəsisəsi: </h4>
        <select class="form-control select" id="listEducationalInstitution" required="required" data-url="{{route('education.educationalInstitutions')}}" name="listeducationalinstitution">
        </select>
    </div>
    <div class="col-md-6 col-lg-6 mt-20">
        <h4>Təhsil forması: </h4>
        <select  class="form-control select"  id="listEducationForm" required="required" data-url="{{route('education.educationForms')}}" name="listeducationform">
        </select>
    </div>
    <div class="col-md-6 col-lg-6 mt-20">
        <h4>Təhsil səviyyəsi: </h4>
        <select  class="form-control select" id="listEducationLevel" required="required" data-url="{{route('education.educationLevels')}}" name="listeducationlevel">
        </select>
    </div>
    <div class="col-md-12">
        <div class="col-md-6 col-lg-6 mt-20 float-left pl-0">
            <h4 id="startdate-con">Daxil olduğu il: </h4>
            <input type="text"  class="date_id form-control" name="edustartdate" required="required">
        </div>
        <div class="col-md-6 col-lg-6 mt-20 float-left pr-0">
            <h4 id="enddate-con">Bitirdiyi il: </h4>
            <input type="text"  class="date_id form-control" name="eduenddate" required="required">
        </div>
    </div>
    <div class="col-md-12 col-lg-12 mt-20">
        <h4>Sənədin nömrəsi və verilmə tarixi tarixi: </h4>
        <input type="text"  class="form-control" id="educationdocinfo" name="educationdocinfo" required="required">
    </div>

    <div class="col-lg-6 col-md-6 mt-20">
        <h4>Diplom üzrə ixtisas: </h4>
        <input type="text"  class="form-control" id="professionname" name="professionname" required="required">
    </div>
    <div class="col-lg-6 col-md-6 mt-20">
        <h4>Peşə: </h4>
        <input type="text" class="form-control" id="workname" name="workname" required="required">
    </div>
    <div class="col-md-12 col-lg-12 mt-20">
        <h4>Nostrifikasiya şəhadətnaməsi: </h4>
        <input type="text"  class="form-control" id="educationdocinfof" name="educationdocinfof" required="required">
    </div>
</div>
@include('components.modal-footer')