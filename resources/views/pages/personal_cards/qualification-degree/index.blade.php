<section id='links'>
</section>
<?php
$modalid='qualification-modal_form';
?>

<section id='content'>
    <div class="col-lg-12 col-xs-12" id="qualification-degree">
        <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
            <div class="panel-heading panel-heading-tab">
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#qualpanelTab1"
                                            aria-controls="qualpanelTab1" onclick="refresh()" role="tab" aria-expanded="true">Ixtisas dərəcəsi</a>
                    </li>
                    <li class="nav-item"><a class="nav-link load-link" data-toggle="tab" href="#qualpanelTab2"  data-url="{{route('user-rank.index')}}"
                                            aria-controls="qualpanelTab2" role="tab">Xüsusi rütbə</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content" >
                    <div class="tab-pane active m-t-20" id="qualpanelTab1" role="tabpanel">
                        {{--Filters--}}
                        @include('components.filter-bar' , ['sid' => 'qualification-search','sname' => 'q-search' , 'pid' => 'qualification_pagination' , 'pname' => 'q-pagination'])
                        {{--End Filters--}}

                        {{--@if(count($new) > 0)--}}
                            {{--<table class="table" style="border: 1px solid #ffe0b2;border-radius: 3px">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<td colspan="4" class="alert alert-info text-center">--}}
                                        {{--<strong style="font-size: 20px">Yeni təsdiqə göndərilənlər</strong>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<th id="testin" class="table-width-5" data-id="">№</th>--}}
                                    {{--<th class="table-width-10">Verilmə tarixi</th>--}}
                                    {{--<th class="table-width-10">Təsnifatı</th>--}}
                                    {{--<th>İxtisas dərəcəsi</th>--}}
                                    {{--<th>Sənədin nömrəsi</th>--}}
                                    {{--<th class="table-width-10">Sənədin tarixi</th>--}}
                                    {{--<th class="text-right table-width-8"></th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}

                                {{--@foreach($new as $newNC)--}}
                                    {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['startDate','qualificationIdListPositionClassificationId.name', 'qualificationIdListQualificationTypeId.name', 'docInfo', 'docDate']])--}}
                                {{--@endforeach--}}

                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--@endif--}}

                        {{--Table--}}
                        <table class="table table-hover dataTable w-full" data-plugin="dataTable">
                            <thead >
                            <tr>
                                <th id="testin" class="table-width-5" data-id="">№</th>
                                <th class="table-width-10">Verilmə tarixi</th>
                                <th class="table-width-10">Təsnifatı</th>
                                <th>İxtisas dərəcəsi</th>
                                <th>Sənədin nömrəsi</th>
                                <th class="table-width-10">Sənədin tarixi</th>
                                <th class="text-right table-width-8"></th>
                            </tr>
                            </thead>
                            <tbody id="tbIdQ">
                            {{--@if(count($new) > 0)--}}
                                {{--@foreach($new as $newNC)--}}
                                    {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'row' => ['startDate','qualificationIdListPositionClassificationId.name', 'qualificationIdListQualificationTypeId.name', 'docInfo', 'docDate']])--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                                @if($data->totalCount > 0)
                                    @foreach($data->data as $key=>$value)
                                        <tr id="{{$value->id}}">
                                            <td>{{++$key}}</td>
                                            <td>{{$value->startDate}}</td>
                                            <td>{{$value->qualificationIdListPositionClassificationId->name}}</td>
                                            <td>{{$value->qualificationIdListQualificationTypeId->name}}</td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-nowrap text-right">
                                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('qualification-degree.edit' , $value->id)}}' , 'qualification-modal')">
                                                    <i class="icon md-edit" aria-hidden="true"></i>
                                            <span class="tptext tpedit">Düzəliş et</span>
                                                </div>
                                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('qualification-degree.destroy' , $value->id)}}" )'>
                                                    <i class="icon md-delete" aria-hidden="true"></i>
                                            <span class="tptext tpdel">Sil</span>
                                                </div>
                                            </td>
                                        </tr>
                                        {{--@if(!is_null($value->nc))--}}
                                            {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['startDate','qualificationIdListPositionClassificationId.name', 'qualificationIdListQualificationTypeId.name', 'docInfo', 'docDate']])--}}
                                        {{--@endif--}}
                                    @endforeach
                                @else
                                    <tr align="center"><td colspan="7" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                                @endif
                            </tbody>
                        </table>

                         {{--Pagination load more button--}}
                        @include('components.pagination' , ['id' => 'qualification_pagination','url' => route('qualification-degree.index') , 'totalCount' => $data->totalCount,'page' => $page])
                         {{--/Pagination load more button--}}
                        {{--/Table--}}
                        {{--Slide Panel Trigger--}}
                        <div class="site-action">
                            <button type="button" class="btn btn-floating btn-info waves-effect"
                                    data-toggle="modal" data-target="#qualification-modal" id="qualModal">
                                <i class="icon md-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                        {{--Slide Panel Trigger--}}
                    </div>
                    <div class="tab-pane m-t-20" id="qualpanelTab2" role="tabpanel"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Qualification Add/Edit Modal-->
    @include('components.modal-header' , ['id' => 'qualification-modal','mdlTitle' => 'İxtisas dərəcəsinin qeydiyyatı ekranı' , 'pid' => 'qualification_pagination' , 'mdUrl' => route('qualification-degree.store') , 'tb' => 'tbIdQ'])
    <div class="col-md-6 pull-l">
        <h4 >İxtisas dərəcəsinin təsnifatı: </h4>
        <select id="ListPositionClassification" class="form-control select" data-url="{{route('qualifications.positionClassifications')}}" name="listpositionclassification" required="required">
        </select>
    </div>
    <div class="col-md-6 pull-r">
        <h4 >İxtisas dərəcəsi: </h4>
        <select id="ListQualificationType" class="form-control select" data-url="{{route('qualifications.qualificationTypes')}}" name="listqualificationtype" required="required">
        </select>
    </div>
    <div class="col-md-4 pull-l m-t-20">
        <h4 >Verilmə tarixi: </h4>
        <input type="text"  data-plugin="datepicker" class="form-control date_id" name="startdate" required="required">
    </div>
    <div class="col-md-4 pull-l m-t-20">
        <h4 >Sənədin nömrəsi: </h4>
        <input type="text"  class="form-control" name="docinfo" required="required">
    </div>
    <div class="col-md-4 pull-l m-t-20">
        <h4 >Sənədin tarixi: </h4>
        <input type="text"  data-plugin="datepicker" class="form-control date_id" name="docdate" required="required">
    </div>
    {{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
    @include('components.modal-footer')
</section>

<section id='scripts'>
    <script src="{{asset('js/custom/plugins/loader.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/responsive-tabs.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/tabs.js')}}"></script>
    <script src="{{asset('core/global/vendor/asrange/jquery-asRange.min.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/qualification-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/user-rank-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/refresh.js')}}"></script>
    <script src="{{asset('js/custom/plugins/select-by-select.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#qualModal').on('click' , function(){
                console.log('test')
                $('#qualification-modal-modal').modal('show');
            });
            $('#ListPositionClassification').selectObj('ListPositionClassification');
        });
        $('#qualification-search').search('qualification-search','qualification_pagination');
        $('#qualification_pagination').pagination('load','qualification_pagination','qualification-search');
    </script>

    @stack('scripts')

    <script>
//        function confirmation(elem,isC,id){
//            $.ajax({
//                url:'/personal-cards/qualification-confirm/'+id+'/'+isC+'/',
//                type: 'GET',
//                success: function(response){
//                    if(response == 200){
//                        $('[href="/personal-cards/contacts"]').click();
//                    }
//                }
//            });
//        }

        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
    </script>
    <script>
        $('#ListPositionClassification').on('select2:select',function () {
            var id = $(this).select2('data')[0].id;

            var url = $('#ListQualificationType').data('url');

            $('#ListQualificationType').selectObj('ListQualificationType', url + '/' + id);
        });
    </script>
</section>