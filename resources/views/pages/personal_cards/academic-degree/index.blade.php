<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse">
        <div  class="panel-body pt-20">
            {{--Filters--}}
            @include('components.filter-bar' , ['sid' => 'academic-search','sname' => 'aca-search' , 'pid' => 'academicdegree_paginate' , 'pname' => 'aca-pagination'])
            {{--End Filters--}}

            {{--@if(count($new) > 0)--}}
            {{--<table class="table">--}}
                {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th class="table-width-5">№</th>--}}
                        {{--<th class="table-width-15">Elmi dərəcə (elmi ad)</th>--}}
                        {{--<th class="table-width-15">Elmi istiqamət</th>--}}
                        {{--<th class="table-width-10">Verildiyi tarix</th>--}}
                        {{--<th>Kim tərəfindən verilib</th>--}}
                        {{--<th>Müvafiq sənədin nömrəsi, tarixi</th>--}}
                        {{--<th class="text-right table-width-8"></th>--}}
                    {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                    {{--@foreach($new as $newNC)--}}
                        {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['listAcademicDegreeId.name','listAcademicAreaId.name','issueDate','orgName','docInfo']])--}}
                    {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
            {{--@endif--}}

            {{--Table--}}
            <table class="table table-hover dataTable w-full" data-plugin="dataTable">
                <thead >
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-15">Elmi dərəcə (elmi ad)</th>
                    <th class="table-width-15">Elmi istiqamət</th>
                    <th class="table-width-10">Verildiyi tarix</th>
                    <th>Kim tərəfindən verilib</th>
                    <th>Müvafiq sənədin nömrəsi, tarixi</th>
                    <th class="text-right table-width-8"></th>
                </tr>
                </thead>
                <tbody id="mainTbody" class="tr-pro">

                @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
                @foreach($data->data as $key => $value)
                    <tr id="{{$value->id}}">
                        <td>{{++$key}}</td>
                        <td>{{$value->listAcademicDegreeId->name}}</td>
                        <td>{{$value->listAcademicAreaId->name}}</td>
                        <td>{{$value->issueDate}}</td>
                        <td>{{$value->orgName}}</td>
                        <td>{{$value->docInfo}}</td>
                        <td class="text-nowrap text-right">
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('academic-degree.edit' , $value->id)}}' , 'qualificationmodal')">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                            </div>
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('academic-degree.destroy' , $value->id)}}" )'>
                                <i class="icon md-delete" aria-hidden="true"></i>
                                <span class="tptext tpdel">Sil</span>
                            </div>
                        </td>
                    </tr>
                    {{--@if(!is_null($value->nc))--}}
                        {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listAcademicDegreeId.name','listAcademicAreaId.name','issueDate','orgName','docInfo']])--}}
                    {{--@endif--}}
                @endforeach
                @else
                    <tr align="center"><td colspan="7" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>
            {{--/Table--}}
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'academicdegree_paginate','url' => route('academic-degree.index') , 'totalCount' => $data->totalCount ,'page' => $page])
            {{-- /Pagination load more button --}}
            {{--Slide Panel Trigger--}}
            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
                 data-selectable="selectable" data-id="23">
                <button type="button" class="btn btn-floating btn-info waves-effect"
                        data-toggle="modal" data-target="#qualificationmodal">
                    <i class="icon md-plus" aria-hidden="true"></i>
                </button>
            </div>
            {{--Slide Panel Trigger--}}
        </div>
    </div>

    <!-- Modal Education Add/Edit Modal-->
    @include('components.modal-header' , ['id' => 'qualificationmodal','mdlTitle' => 'Elmi dərəcələrin qeydiyyatı ekranı', 'mdUrl' => route('academic-degree.store')])
    <div class="col-md-12 pull-l m-t-20">
        <h4>Kim tərəfindən verilib:</h4>
        <input type="text" id="giver" class="form-control " name="giver" required="required">
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Elmi istiqamət: </h4>
        <select id="education" class="form-control select"  data-url="{{route('listAcademicArea.get')}}" name="education" required="required">
            <option> </option>
        </select>
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Elmi dərəcə (elmi ad): </h4>
        <select id="educationdegree" class="form-control select" data-url="{{route('listAcademicDegree.get')}}" name="educationdegree"required="required">
            <option> </option>
        </select>
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Müvafiq sənədin nömrəsi, tarixi: </h4>
        <input type="text" id="filenumberdate" class="form-control" name="filenumberdate" required="required">
    </div>
    <div class="col-md-6 pull-l m-t-20">
        <h4>Verildiyi tarix: </h4>
        <div class="input-group">
                    <span class="input-group-addon">
                      <i class="icon md-calendar" aria-hidden="true"></i>
                    </span>
            <input id="graduatedate" name="graduatedate" type="text" class="form-control date-picker" required="required">
        </div>
    </div>
    {{--@include('pages.personal_cards.common', ['modalid'=>'qualificationmodal_form'])--}}
    @include('components.modal-footer')

</section>


<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/academicdegree-row.js')}}"></script>
    @stack('scripts')
    {{----}}
    <script>
        $('#education').selectObj('education');
        $('#educationdegree').selectObj('educationdegree');
        $('#academic-search').search('academic-search','academicdegree_paginate',
            {
                'listAcademicDegree.name': 'Elmi dərəcəyə görə',
                'listAcademicArea.name': 'Elmi istiqamətə görə',
                'orgName': 'Verən təşkilata görə',
                'docInfo': 'Sənədə görə'
            });
        $('#academicdegree_paginate').pagination('load','academicdegree_paginate','academic-search');
    </script>
    <script>
        $('.date-picker').datepicker({
            format: 'dd.mm.yyyy',
            language: 'az',
            weekStart: 1
        });
    </script>
</section>