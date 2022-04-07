{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'uni-search','sname' => 'u-search' , 'pid' => 'uni-pagination' , 'pname' => 'u-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead >
    <tr>
        <th>№</th>
        <th>Tarix</th>
        <th>Qeyd</th>
    </tr>
    </thead>
    <tbody id="mainTbody" class="tr-pro">

    </tbody>
</table>
{{--/Table--}}
{{--Slide Panel Trigger--}}
<div class="site-action">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#disciplinary-uniform">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}

<!-- Modal Qualification Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'disciplinary-uniform','mdlTitle' => 'Geyim qaydası'])
                <div class="col-md-6 pull-l m-t-20">
                    <h4>Tarixi: </h4>
                    <input type="text" id="disciplinary-uniform-date" class="form-control date-picker" required="required">
                </div>
                <div class="col-md-12 pull-l m-t-20">
                    <h4>Qeyd </h4>
                    <input type="text" id="disciplinary-uniform-note" class="form-control" required="required">
                </div>
@include('components.modal-footer')
<!-- /Modal -->