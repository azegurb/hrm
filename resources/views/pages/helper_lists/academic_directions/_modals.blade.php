@include('components.modal-header' , ['id' => 'academic-directions-modal','mdlTitle' => 'Elmi istiqamətlər', 'mdUrl' => route('academic-directions.store')])
<div class="col-lg-12 float-left">
    <h4 >Elmi̇ isti̇qamət:</h4>
    <input type="text" class="form-control" id="inputHelpText" name="input_academic_direction" required="required">
</div>
@include('components.modal-footer')