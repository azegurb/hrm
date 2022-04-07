<section id='links'>
    <link rel="stylesheet" href="{{ asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/ladda/ladda.css') }}">
</section>

<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div  class="panel-body pt-20">
            <div class="tab-content">
                    @include('components.filter-bar' , ['sid' => 'sicklist-search','sname' => 's-search' , 'pid' => 'sicklist_pagination' , 'pname' => 's-pagination'])
                    <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                        <thead>
                        <tr>
                            <th class="table-width-5">№</th>
                            <th>Xəstəlik vərəqəsini verən orqan</th>
                            <th>Xəstəlik vərəqəsinin başlama tarixi</th>
                            <th>Xəstəlik vərəqəsinin bitmə tarixi</th>
                            <th>Xəstəlik vərəqəsinin qeydi</th>
                            <th class="text-right table-width-10"></th>

                        </tr>
                        </thead>
                        <tbody id="sick">
                        {{--@if(count($new) > 0)--}}
                            {{--@foreach($new as $newNC)--}}
                                {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['organizationName','sickStartDate', 'sickEndDate', 'sickNote']])--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                        @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
                            @foreach($data->data as $key=>$value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value->organizationName }}</td>
                                    <td>{{ $value->sickStartDate  }}</td>
                                    <td>{{ $value->sickEndDate }}</td>
                                    <td>{{ $value->sickNote}}</td>
                                    <td class="text-right">
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData('{{route('sicklist.edit' , $value->id)}}' , 'sicklist-modal')">
                                            <i class="icon md-edit" aria-hidden="true"></i>
                                            <span class="tptext tpedit">Düzəliş et</span>
                                        </div>
                                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this),"{{route('sicklist.destroy' , $value->id)}}")'>
                                            <i class="icon md-delete" aria-hidden="true"></i>
                                            <span class="tptext tpdel">Sil</span>
                                        </div>
                                    </td>

                                </tr>
                                {{--@if(!is_null($value->nc))--}}
                                    {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['organizationName','sickStartDate', 'sickEndDate', 'sickNote']])--}}
                                {{--@endif--}}
                            @endforeach
                        @else
                            <tr align="center"><td colspan="6" class="alert alert-warning" >Məlumat daxil edilməmişdir!</td></tr>
                        @endif
                        </tbody>
                    </table>
                {{-- Pagination load more button --}}
                @include('components.pagination' , ['id' => 'sicklist_paginate','url' => route('sicklist.index'), 'totalCount' => $data->totalCount,'page' => $page])
                {{-- /Pagination load more button --}}
                    <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                        <button id="addToTable"  class="btn btn-floating btn-info waves-effect" data-target="#sicklist-modal" data-toggle="modal" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
@include('pages.personal_cards.sicklist._modal', ['modalid'=>'sicklist-modal_form'])
<!-- /Modal -->
</section>

<section id="scripts">
    <script src="{{asset('core/assets/examples/js/uikit/panel-structure.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/sicklist-row.js')}}"></script>

    <script>
        //    $('#Id').selectObj('NameId');
        $('#sicklist-search').search('sicklist-search','sicklist_paginate');
        $('#sicklist_paginate').pagination('load','sicklist_paginate','sicklist-search');

        $(".sick-list-date").datepicker({
            format: 'dd.mm.yyyy',
            orientation: "left bottom",
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





