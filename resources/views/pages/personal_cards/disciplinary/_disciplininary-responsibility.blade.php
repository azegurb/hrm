<style>
    .select2-dropdown {
        z-index: 1!important;
    }
</style>
{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'dis-res-search','sname' => 'dis-search' , 'pid' => 'disciplinary_paginate' , 'pname' => 'dis-pagination'])
{{--End Filters--}}
{{--Table--}}
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
{{--@if(count($new) > 0)--}}
    {{--<table class="table">--}}
        {{--<thead>--}}
        {{--<tr>--}}
            {{--<th>№</th>--}}
            {{--<th>İntizam məsuliyyəti</th>--}}
            {{--<th>Səbəb</th>--}}
            {{--<th>Verildiyi tarix</th>--}}
            {{--<th class="text-right table-width-8"></th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--@foreach($new as $newNC)--}}
            {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['eduStartDate','eduEndDate', 'listEducationalInstitutionId.name', 'professionName', 'educationDocInfo', 'listEducationFormId.name', 'listEducationLevelId.name', 'educationDocInfoF']])--}}
        {{--@endforeach--}}
        {{--</tbody>--}}
    {{--</table>--}}

{{--@endif--}}

<table class="table table-hover dataTable w-full">
    <thead >
        <tr>
            <th>№</th>
            <th>İntizam məsuliyyəti</th>
            <th>Səbəb</th>
            <th>Verildiyi tarix</th>
            <th class="text-right table-width-8"></th>
        </tr>
    </thead>
    <tbody id="mainTbodyDisciplinary" class="tr-pro">
        @if($data->totalCount > 0)
        @foreach($data->data as $key => $value)
            <tr id="{{$value->id}}">
                <td>{{++$key}}</td>
                <td>{{$value->listDisciplinaryActionIdName}}</td>
                <td>{{$value->reason}}</td>
                <td>{{$value->orderCommonIdOrderDate}}</td>
                <td class="text-nowrap text-right">
                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('disciplinary.edit' , $value->id)}}' , 'disciplinary-responsibility')">
                        <i class="icon md-edit" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                    </div>
                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('disciplinary.destroy' , $value->id)}}" )'>
                        <i class="icon md-delete" aria-hidden="true"></i>
                                <span class="tptext tpdel">Sil</span>
                    </div>
                </td>
            </tr>
        @endforeach
        @else
            <tr align="center"><td colspan="5" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
        @endif
    </tbody>
</table>
{{--/Table--}}
{{-- Pagination load more button --}}
@include('components.pagination' , ['id' => 'disciplinary_paginate','url' => route('disciplinary.index') , 'totalCount' => $data->totalCount ,'page' => $page])
{{-- /Pagination load more button --}}
{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    {{--<button type="button" class="btn btn-floating btn-info waves-effect"--}}
            {{--data-toggle="modal" data-target="#disciplinary-responsibility">--}}
        {{--<i class="icon md-plus" aria-hidden="true"></i>--}}
    {{--</button>--}}
</div>
{{--Slide Panel Trigger--}}
<!-- Disciplinary Responsibility Add/Edit Modal-->
@include('components.modal-header' , ['mdlSize' => 'lg','id' => 'disciplinary-responsibility','mdlTitle' => 'İntizam məsuliyyəti üzrə qeydiyyat ekranı' ,'pid'  => 'disciplinary_paginate' , 'tb' => 'mainTbodyDisciplinary' ,'mdUrl' => route('disciplinary.store')])
    <div class="col-md-12">
        <label for="honor-reward"><h4>İntizam məsuliyyəti:</h4></label>
        <input type="hidden" class="append" name="listDisciplinaryActionTypeIdName" value="">
        <select id="listDisciplinaryActionTypeId" name="listDisciplinaryActionTypeId" data-url="{{route('listDisciplinaryActionTypeId.get')}}" class="form-control select"></select>
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Səbəb:</h4>
        <input type="text" id="disciplinary-responsibility-couse" name="reason" class="form-control">
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Əmrin nömrəsi və tarix:</h4>
        <input type="text" id="disciplinary-responsibility-order-date" name="orderNum" class="form-control">
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Verilmə tarixi:</h4>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
            <input type="text" class="form-control date_id" name="issueDate">
        </div>
    </div>
@include('components.modal-footer')
<!-- /Modal -->
<script src="{{asset('js/custom/plugins/page-row/disciplinary_paginate.js')}}"></script>
<script src="{{asset('js/custom/plugins/select-text-appender.js')}}"></script>
<script>
    $('#listDisciplinaryActionTypeId').selectObj('listDisciplinaryActionTypeId');
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekstart: 1
    });
    function confirmation(elem,isC,id){
        $.ajax({
            url:'/personal-cards/disciplinary-confirm/'+id+'/'+isC+'/',
            type: 'GET',
            success: function(response){
                if(response == 200){
                    $('[href="/personal-cards/disciplinary"]').click();
                }
            }
        });
    }
</script>