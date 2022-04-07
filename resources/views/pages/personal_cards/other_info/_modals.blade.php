@include('components.modal-header' , ['id' => 'other-info-modal','mdlTitle' => 'Digər məlumatların qeydiyyatı ekranı', 'mdUrl' => route('other-info.store')])
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div  class="row col-lg-12 col-md-12">
    <h4 style="font-size:15px">Seçkili (qanunvericilik və ya yerli özünüidarəetmə) orqanların işində iştirakı:</h4>
    <input type="text" class="form-control" id="inputPlaceholder" name="electionActivitiesNotes" required="required">
    <h4 style="font-size:15px">Dövlət orqanlarında dövlət qulluğunun rəhbər vəzifələrin tutulması üçün ehtiyat kadrlar siyahısına daxil olunması ilə bağlı qeydlər:</h4>
    <input type="text" class="form-control" id="inputPlaceholder" name="civilServiceNotes" required="required">
    <h4 style="font-size:15px">Çap edilmiş elmi əsərlərin və kitabların adları:</h4>
    <input type="text" class="form-control" id="inputPlaceholder" name="scientificWorksNotes" required="required">
    <h4 style="font-size:15px">Əmək (peşə) fəaliyyəti ilə bağlı mühüm əhəmiyyət kəsb edən tədbirlərdə iştirakı:</h4>
    <input type="text" class="form-control" id="inputPlaceholder" name="professionalActivitiesNotes" required="required">
</div>
@include('components.modal-footer')