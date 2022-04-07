{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'not-search','sname' => 'n-search' , 'pid' => 'not-pagination' , 'pname' => 'n-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full">
    <thead >
    <tr>
        <th>№</th>
        <th>Səbəb</th>
        <th>Əmrin nömrəsi</th>
        <th>Əmrin tarixi</th>
    </tr>
    </thead>
    <tbody id="mainTbody" class="tr-pro">

    </tbody>
</table>
{{--/Table--}}
{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#disciplinary-notification">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}
<!-- Disciplinary Responsibility Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'disciplinary-notification','mdlTitle' => 'Xəbərdarlıq'])
                <div class="col-md-6 pull-l m-t-20">
                    <h4>Səbəb: </h4>
                    <input type="text" id="disciplinary-responsibility-couse" class="form-control" required="required">
                </div>
                <div class="col-md-6 pull-l m-t-20">
                    <h4>Əmrin nömrəsi</h4>
                    <input type="text" id="disciplinary-responsibility-order-date" class="form-control" required="required">
                </div>
                <div class="col-md-6 pull-l m-t-20">
                    <h4>Əmrin tarixi: </h4>
                    <input type="text" id="disciplinary-responsibility-date" class="form-control date-picker" required="required">
                </div>
@include('components.modal-footer')
<!-- /Modal -->