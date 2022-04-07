@include('components.modal-header' , ['id' => 'training-modal','mdlTitle' => 'Təlimlərin qeydiyyatı','mdUrl' => route('training.store') , 'pid' => 'training_pagination' , 'tb' => 'tbody'])
<div class="row">
    <div class="col-md-6 mt-20">
        <h4>Təlim tələbatı:</h4>
        <input type="hidden" class="append" name="userTrainingNeedIdName" value="">
        <select class="form-control select" id="listTrainingNeed" data-url="{{route('training.need')}}" name="listTrainingNeed"></select>
    </div>
    {{--<div class="col-md-6 mt-20">--}}
    {{--<h4 class="example-title">TƏLİMİN NÖVÜ</h4>--}}
    {{--<input type="hidden" class="append" name="userTrainingNeedIdName" value="listtrainingtype">--}}
    {{--<select class="form-control select" id="listTrainingType" data-url="{{route('training.trainingTypes')}}" name="listtrainingtype">--}}
    {{--</select>--}}
    {{--</div>--}}
    <div class="col-md-6 mt-20">
        <h4>Təlimin adı:</h4>
        <input type="hidden" class="append" name="listTrainingNameIdName" value="">
        <select class="form-control select" id="listTrainingNameId" data-url="{{route('training.trainingNames')}}" name="listTrainingNameId" required="required">
        </select>
    </div>
    <div class="col-md-6 mt-20">
        <h4>Təlimin forması:</h4>
        <input type="hidden" class="append" name="listTrainingFormIdName" value="">
        <select class="form-control select" id="listTrainingFormId" data-url="{{route('training.trainingForms')}}" name="listTrainingFormId" required="required">
        </select>
    </div>
    <div class="col-md-6 mt-20">
        <h4>Başlama &mdash; Bitmə tarixi:</h4>
        <div class="input-daterange" >
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="icon md-calendar" aria-hidden="true"></i>
                </span>
                <input type="text" class="form-control date_id" name="trainingStartDate" required="required"/>
            </div>
            <div class="input-group">
                <span class="input-group-addon">&mdash;</span>
                <input type="text" class="form-control date_id" name="trainingEndDate" required="required"/>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-20">
        <h4>Müddət <small>(saat ilə):</small></h4>
        <input type="number" class="form-control" name="period" required="required">
    </div>
    <div class="col-md-6 mt-20">
        <h4>Keçirildiyi yer:</h4>
        <input type="hidden" class="append" name="listTrainingLocationIdName" value="">
        <select class="form-control select" id="listTrainingLocationId" data-url="{{route('training.trainingLocations')}}" name="listTrainingLocationId" required="required">
        </select>
    </div>
</div>
<!-- End Modal -->
@include('components.modal-footer')