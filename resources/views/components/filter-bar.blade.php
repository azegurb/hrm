{{--Filters--}}

<div class="col-md-3 pull-l mb-10 pl-0">
    <div class="input-search">
        <button type="submit" class="input-search-btn"><div class="loader vertical-align-middle loader-circle search-loader"></div></button>
        <input type="text" class="form-control" name="{{$sname}}" id="{{$sid}}" placeholder="Axtar...">
    </div>
</div>
<div class="col-md-3 pull-l mb-10 pl-0" id="searchField"></div>
<div class="col-md-5"></div>
<div class="col-md-1 float-right mb-10">
    <select name="{{$pname}}" id="{{$pid}}_filter" class="form-control pull-r">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
</div>
{{--End Filters--}}
