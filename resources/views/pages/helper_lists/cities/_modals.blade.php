@include('components.modal-header' , ['id' => 'cities-modal','mdlTitle' => 'Şəhərlər', 'mdUrl' => route('cities.store')])
<div class="col-lg-12 float-left">
    <h4>Ölkə:</h4>
    <div class="form-group">
        <select class="form-control select" id="listCountries"  data-url="{{route('listCountriesController.get')}}" name="input_country" required="required"></select>
    </div>
    <h4>Şəhər:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_city" required="required">

</div>
@include('components.modal-footer')