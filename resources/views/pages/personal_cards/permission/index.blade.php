<section id="links"></section>
<section id="content">
    <div class="panel">
        <div  class="panel-body pt-20">
            @include('components.filter-bar' , ['sid' => 'permission-search','sname' => 'p-search' , 'pid' => 'permission_pagination' , 'pname' => 'p-pagination'])
        </div>
        <div class="clearfix"></div>
        <div class="panel-body pt-0">
            <table class="table">
                <thead >
                <tr>
                    <th id="testin" class="table-width-5" data-id="" >№</th>
                    <th>İcazə səbəbi:</th>
                    <th>İcazə verən şəxs:</th>
                    <th>İcazənin verilmə tarixi:</th>
                    <th>İcazənin bitmə tarixi:</th>
                    <th>İcazənin statusu:</th>
                    <th class="text-right table-width-8"></th>
                </tr>
                </thead>
                <tbody id="tbody">
                @if($data->totalCount > 0)
                    {{--@if(count($new) > 0)--}}
                        {{--@foreach($new as $newNC)--}}
                            {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listRequestForPermissionReasonIdName','allowerUserIdFirstName','startDate','endDate','isApprowed']])--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                    @foreach($data->data as $key=>$value)
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            <td>{{$value->listRequestForPermissionReasonIdName}}</td>
                            <td>{{$value->allowerUserIdFirstName ." ". $value->allowerUserIdLastName }}</td>
                            <td>{{$value->startDate}}</td>
                            <td>{{$value->endDate}}</td>
                            <td>
                                {{$value->isApprowed}}
                            </td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData('{{route('permission.edit' , $value->id)}}' , 'permissions-modal' ,'data_permission_custom')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this) , "{{route('permission.destroy' , $value->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                        {{--@if(!is_null($value->nc))--}}
                            {{--@include('components.row', ['value' => $value->nc,'count' => $key,'row' => ['listRequestForPermissionReasonIdName','allowerUserIdFirstName','startDate','endDate','isApprowed']])--}}
                        {{--@endif--}}
                    @endforeach
                @else
                    <tr align="center"><td colspan="7" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>

            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'permission_pagination','url' => route('permission.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}
        </div>
    </div>
            <!-- Modal -->
            @include('pages.personal_cards.permission._modal', ['modalid'=>'permissions-modal_form'])
            <!-- /Modal -->

    <div class="site-action">
        <button  class="btn btn-floating btn-info waves-effect" data-target="#permissions-modal" data-toggle="modal" type="button">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
    <!-- Modal -->
{{--@include('pages.personal_cards.permission._modal')--}}
<!-- /Modal -->
</section>
<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/permission-row.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/data_permission_custom.js')}}"></script>
    <script>
        $('#allowerUser').selectObj('allowerUser');
        $('#listRequestForPermissionReason').selectObj('listRequestForPermissionReason');
        $('#permission-search').search('permission-search','permission_pagination');
        $('#permission_pagination').pagination('load','permission_pagination','permission-search');
    </script>
    <script>
        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
        $('input[name="startdate"]').on('change' , function () {
            var start = $(this).val();
            $('input[name="enddate"]').remove();
            $('#enddate-con').after('<input  type="text" class="form-control" name="enddate" required="required">');
            $('input[name="enddate"]').datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                startDate: start,
                weekStart: 1
            });
        });
        $('input[name="enddate"]').on('change' , function () {
            var end = $(this).val();
            $('input[name="startdate"]').remove();
            $('#startdate-con').after('<input  type="text" class="form-control" name="startdate" required="required">');
            $('input[name="startdate"]').datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                endDate: end,
                weekStart: 1
            });
        });
    </script>

</section>