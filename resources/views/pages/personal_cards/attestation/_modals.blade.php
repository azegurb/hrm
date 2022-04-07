<!-- Modal -->
@include('components.modal-header' , ['id' => 'attestation-modal','mdlTitle' => 'Attestasiya','mdUrl'=>route('attestation.store')])

<div class="col-lg-6 float-left mt-20">
    <h4 class="example-tittle">Müsabiqənin tipi:</h4>
    <select class="form-control select" id="listAttestationType" data-url="{{route('attestation.attestationTypes')}}" name="listattestationtype" required="required">
    </select>
</div>
<div class="col-lg-6  float-left mt-20">
    <h4 class="example-tittle">Tarixi:</h4>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="icon md-calendar" aria-hidden="true"></i>
        </span>
        <input  type="text" class="date_id date-picker form-control" name="dateoff"  required="required">
    </div>
</div>
<div class="col-lg-6  float-left mt-20">
    <h4 class="example-tittle">Qurumun adı:</h4>
    <input  type="text" class="form-control" id="inputPlaceholder" name="organname" required="required">
</div>
<div class="col-lg-6   float-left mt-20">
    <h4 class="example-tittle">Nəticə:</h4>
    <select class="form-control select"  id="listAttestationResult" data-url="{{route('attestation.attestationResults')}}" name="listattestationresult" required="required">
    </select>
</div>
<div class="col-lg-12 float-left mt-20">
    <h4 class="example-tittle">Qeydlər:</h4>
    <textarea  class="maxlength-textarea form-control"  data-plugin="maxlength"
               data-placement="bottom-left-inside" maxlength="100" rows="3" name="notes" required="required">
    </textarea>
</div>
@include('components.modal-footer')