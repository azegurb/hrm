{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'military-search','sname' => 'm-search' , 'pid' => 'military_pagination' , 'pname' => 'm-pagination'])
{{--End Filters--}}
{{--Table--}}
<table class="table table-hover dataTable w-full" >
    <thead >
        <tr>
            <th id="testin" class="table-width-5">№</th>
            <th>Verilmə tarixi</th>
            <th>Xüsusi rütbənin növü</th>
            <th>Xüsusi rütbə</th>
            <th>Sənədin nömrəsi</th>
            <th>Sənədin tarixi</th>
            <th class="text-right table-width-8"></th>
        </tr>
    </thead>
    <tbody id="tb">
    @if(count($new) > 0)
        @foreach($new as $newNC)
            @include('components.row', ['value' => $newNC,'count' => '','row' => ['startDate','listSpecialRankId.listSpecialRankTypeId.name', 'listSpecialRankId.name', 'docInfo', 'docDate']])
        @endforeach
    @endif
        @if($data->totalCount > 0)
            @foreach($data->data as $key=>$value)
            <tr id="{{$value->id}}">
                <td>{{++$key}}</td>
                <td>{{$value->startDate}}</td>
                <td>{{$value->listSpecialRankId->listSpecialRankTypeId->name}}</td>
                <td>{{$value->listSpecialRankId->name}}</td>
                <td>{{$value->docInfo}}</td>
                <td>{{$value->docDate}}</td>
                <td class="text-nowrap text-right">
                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="openModal('{{route('user-rank.edit' , $value->id)}}' , 'military')" >
                        <i class="icon md-edit" aria-hidden="true"></i>
                                        <span class="tptext tpedit">Düzəliş et</span>
                    </div>
                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('user-rank.destroy' , $value->id)}}" )'>
                        <i class="icon md-delete" aria-hidden="true"></i>
                                        <span class="tptext tpdel">Sil</span>
                    </div>
                </td>
            </tr>
            @if(!is_null($value->nc))
                @include('components.row', ['value' => $newNC,'count' => '','row' => ['startDate','listSpecialRankId.listSpecialRankTypeId.name', 'listSpecialRankId.name', 'docInfo', 'docDate']])
            @endif
            @endforeach
        @else
            <tr align="center"><td colspan="7" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
        @endif
    </tbody>
</table>
{{--/Table--}}
{{-- Pagination load more button --}}
@include('components.pagination' , ['id' => 'military_pagination','url' => route('user-rank.index') , 'totalCount' => $data->totalCount,'page' => $page])
{{-- /Pagination load more button --}}
{{--Slide Panel Trigger--}}
{{--<div class="site-action">--}}
    {{--<button type="button" class="btn btn-floating btn-info waves-effect"--}}
            {{--data-toggle="modal" data-target="#military">--}}
        {{--<i class="icon md-plus" aria-hidden="true"></i>--}}
    {{--</button>--}}
{{--</div>--}}
{{--Slide Panel Trigger--}}

<!-- Add button-->
<div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">
    <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{route('user-rank.create')}}', 'military')" type="button">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
<!-- /Add button-->

<!--Military Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'military','mdlTitle' => 'Xüsusi rütbələrin qeydiyyatı ekranı', 'pid'=>'military_pagination', 'mdUrl' => route('user-rank.store') , 'tb' => 'tb'])
@include('components.modal-footer')

<!-- /Modal -->
{{--test--}}
<script src="{{asset('js/custom/plugins/loader.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/responsive-tabs.js')}}"></script>
<script src="{{asset('core/global/js/Plugin/tabs.js')}}"></script>
<script src="{{asset('core/global/vendor/asrange/jquery-asRange.min.js')}}"></script>
<script src="{{asset('js/custom/plugins/page-row/qualification-row.js')}}"></script>
<script src="{{asset('js/custom/plugins/page-row/user-rank-row.js')}}"></script>
<script src="{{asset('js/custom/plugins/refresh.js')}}"></script>



<script src="{{ asset('js/custom/pages/work-experience/modal.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#ListSpecialRankType').selectObj('ListSpecialRankType');
    });
    $('#military-search').search('military-search','military_pagination');
    $('#military_pagination').pagination('load','military_pagination','military-search');
</script>

