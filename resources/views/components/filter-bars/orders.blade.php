{{--Filters--}}
<div class="col-md-3 pull-l mb-10 pl-0">
    {{--<h5>Əmrin tipinə görə axtar</h5>--}}
    <select class="form-control" id="orderTypesFilter" name="listOrderTypeId"
            data-placeholder="Əmrin tipinə görə axtarış" data-url="{{ route('order-types.list') }}">
        <option></option>
    </select>
</div>
<div class="col-md-3 pull-l mb-10 pl-0">
    {{--<h5>Əmrin nömrəsinə görə axtar</h5>--}}
    <input type="text" class="form-control" id="orderNumberFilter" name="orderNum"
           placeholder="Əmrin nömrəsinə görə axtarış">
</div>
<div class="col-md-2 pull-l mb-10 pl-0">
    {{--<h5>Tarix aralığına görə axtar</h5>--}}
    <div class="input-group">
            <span class="input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
        <input type="text" class="form-control" name="orderDate" id="orderDateStart" data-plugin="datepicker" placeholder="Tarixdən"/>
    </div>
</div>
<div class="col-2 pull-l mb-10 pl-0">
    <div class="input-group">
        <span class="input-group-addon">
                <i class="icon md-calendar" aria-hidden="true"></i>
            </span>
        <input type="text" class="form-control" name="orderDate" id="orderDateEnd" data-plugin="datepicker" placeholder="Tarixədək"/>
    </div>
</div>
<div class="col-md-2 float-right mb-10">
    <select name="{{$pname}}" id="{{$pid}}_filter" class="form-control pull-r">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
</div>
{{--End Filters--}}