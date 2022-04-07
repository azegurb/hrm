<section id='links'></section>
<section id='content'>
    <div class="panel ">
        <div  class="panel-body pt-20">
            {{--Filters--}}
            @include('components.filter-bar' , ['sid' => 'education-search','sname' => 'e-search' , 'pid' => 'education_pagination' , 'pname' => 'e-pagination'])
            {{--End Filters--}}
        </div>
        {{--Table--}}
        <div  class="panel-body pt-0">

            {{--@if(count($new) > 0)--}}
                {{--<table class="table">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th id="testin" class="table-width-5" data-id="">№</th>--}}
                        {{--<th>Daxil olduğu il</th>--}}
                        {{--<th>Bitirdiyi il</th>--}}
                        {{--<th>Təhsil müəsisəsi</th>--}}
                        {{--<th>Diplom üzrə ixtisası</th>--}}
                        {{--<th>Sənədin nömrəsi və verilmə tarixi</th>--}}
                        {{--<th>Təhsil forması</th>--}}
                        {{--<th>Təhsil səviyyəsi</th>--}}
                        {{--<th>Nostrifikasiya şəhadətnaməsi</th>--}}
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
            <table class="table">
                <thead >
                <tr>
                    <th id="testin" class="table-width-5" data-id="">№</th>
                    <th>Daxil olduğu il</th>
                    <th>Bitirdiyi il</th>
                    <th>Təhsil müəsisəsi</th>
                    <th>Diplom üzrə ixtisası</th>
                    <th>Sənədin nömrəsi və verilmə tarixi</th>
                    <th>Təhsil forması</th>
                    <th>Təhsil səviyyəsi</th>
                    <th>Nostrifikasiya şəhadətnaməsi</th>
                    <th class="text-right table-width-8"></th>
                </tr>
                </thead>

                    <tbody id="tb">

                    @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
                    @foreach($data->data as $key=>$value)
                    <tr id="{{$value->id}}">
                        <td>{{++$key}}</td>
                        <td>{{$value->eduStartDate}}</td>
                        <td>{{$value->eduEndDate}}</td>
                        <td>{{$value->listEducationalInstitutionId->name}}</td>
                        <td>{{$value->professionName}}</td>
                        <td>{{$value->educationDocInfo}}</td>
                        <td>{{$value->listEducationFormId->name}}</td>
                        <td>{{$value->listEducationLevelId->name}}</td>
                        <td>{{$value->educationDocInfoF}}</td>
                        <td class="text-nowrap text-right">
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('education.edit' , $value->id)}}' , 'education-modal')">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                            </div>
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('education.destroy' , $value->id)}}" )'>
                                <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                            </div>
                        </td>
                    </tr>
                    {{--@if(!is_null($value->nc))--}}
                        {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '', 'row' => ['eduStartDate','eduEndDate', 'listEducationalInstitutionId.name', 'professionName', 'educationDocInfo', 'listEducationFormId.name', 'listEducationLevelId.name', 'educationDocInfoF']])--}}
                    {{--@endif--}}
                    @endforeach
                    @else
                        <tr align="center"><td colspan="10" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                    @endif
                    </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'education_pagination','url' => route('education.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}
        </div>
    </div>

    {{--Modals--}}
    @include('pages.personal_cards.education._modals', ['modalid'=>'education-modal'])
    {{--/Modals--}}

    {{--Slide Panel Trigger--}}
    <div class="site-action">
        <button type="button" class="btn btn-floating btn-info waves-effect"
                data-toggle="modal" data-target="#education-modal">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
    {{--Slide Panel Trigger--}}



</section>

<section id='scripts'>
    <script src="{{asset('js/custom/plugins/page-row/education-row.js')}}"></script>
    <script>
        $('#listEducationalInstitution').selectObj('listEducationalInstitution');
        $('#listEducationForm').selectObj('listEducationForm');
        $('#listEducationLevel').selectObj('listEducationLevel');
        $('#education-search').search('education-search','education_pagination');
        $('#education_pagination').pagination('load','education_pagination','education-search');
    </script>
    @stack('scripts')
    {{--<script>--}}
        <script>
            function confirmation(elem,isC,id){
                $.ajax({
                    url:'/personal-cards/education-confirm/'+id+'/'+isC+'/',
                    type: 'GET',
                    success: function(response){
                        if(response == 200){
                            $('[href="/personal-cards/education"]').click();
                        }
                    }
                });
            }

        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
        $('input[name="edustartdate"]').on('change' , function () {
            var start = $(this).val();
            $('input[name="eduenddate"]').remove();
            $('#enddate-con').after('<input  type="text" class="form-control" name="eduenddate" required="required">');
            $('input[name="eduenddate"]').datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                startDate: start,
                weekStart: 1
            });
        });
        $('input[name="eduenddate"]').on('change' , function () {
            var end = $(this).val();
            $('input[name="edustartdate"]').remove();
            $('#startdate-con').after('<input  type="text" class="form-control" name="edustartdate" required="required">');
            $('input[name="edustartdate"]').datepicker({
                orientation: "left bottom",
                format: 'dd.mm.yyyy',
                endDate: end,
                weekStart: 1
            });
        });
    </script>

    <script>
        $('#education-search').search('education-search','education_pagination');
    </script>

</section>