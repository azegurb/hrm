{{--Filters--}}
@include('components.filter-bar' , ['sid' => 'itskills-search','sname' => 'i-search' , 'pid' => 'itskills_pagination' , 'pname' => 'i-pagination'])
{{--End Filters--}}
{{--Table--}}
{{--@include('pages.personal_cards.common', ['modalid'=>'it-knowledge-modal'])--}}
{{--@if(count($new) > 0)--}}
{{--<table class="table">--}}
    {{--<thead>--}}
    {{--<tr>--}}
        {{--<th class="table-width-5">№</th>--}}
        {{--<th>Kompüter biliyi</th>--}}
        {{--<th>Bacarıq səviyyəsi</th>--}}
        {{--<th class="text-right table-width-8"></th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--@foreach($new as $newNC)--}}
        {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['name','listKnowledgeLevelId.name']])--}}
    {{--@endforeach--}}
    {{--</tbody>--}}
{{--</table>--}}
{{--@endif--}}

<table class="table table-hover dataTable w-full">
    <thead >
    <tr>
        <th class="table-width-5">№</th>
        <th>Kompüter biliyi</th>
        <th>Bacarıq səviyyəsi</th>
        <th class="text-right table-width-8"></th>
    </tr>
    </thead>
    <tbody id="tb" class="tr-pro">
    @if(!empty($data->data) && is_array ($data->data) && $data->totalCount != 0)
        @foreach($data->data as $key => $value)
            <tr id="{{$value->id}}">
                <td>{{++$key}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->listKnowledgeLevelId->name}}</td>
                <td class="text-nowrap text-right">
                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('it-knowledge.edit' , $value->id)}}' , 'it-skills')">
                        <i class="icon md-edit" aria-hidden="true"></i>
                                        <span class="tptext tpedit">Düzəliş et</span>
                    </div>
                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('it-knowledge.destroy' , $value->id)}}" )'>
                        <i class="icon md-delete" aria-hidden="true"></i>
                                        <span class="tptext tpdel">Sil</span>
                    </div>
                </td>

            </tr>
            {{--@if(!is_null($value->nc))--}}
                {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['name','listKnowledgeLevelId.name']])--}}
            {{--@endif--}}
        @endforeach
    @else
        <tr align="center"><td colspan="4" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
    @endif
    </tbody>
</table>
{{--/Table--}}
{{-- Pagination load more button --}}
@include('components.pagination' , ['id' => 'itskills_pagination','url' => route('it-knowledge.index') , 'totalCount' => $data->totalCount,'page' => $page])
{{-- /Pagination load more button --}}

<!-- Modal Qualification Add/Edit Modal-->
@include('components.modal-header' , ['id' => 'it-skills','mdlTitle' => 'IT biliklərinin qeydiyyatı ekranı','pid'=>'itskills_pagination' ,'mdUrl' => route('it-knowledge.store'), 'tb' => 'tb'])
<div class="container">
    <div class="row">
        <div class="col-md-6 pull-l">
            <h4 >Kompüter biliyi: </h4>
            <input id="it-skill" class="form-control" data-url="{{route('itKnowledgeController.get')}}" name="itknowledge" required="required">
        </div>
        <div class="col-md-6 pull-r">
            <h4 >Bacarıq səviyyəsi: </h4>
            <select id="it-skills-level" class="form-control select" data-url="{{route('listItKnowledgeLevelController.get')}}" name="itknowledgeLevel" required="required">
                <option> </option>
            </select>
        </div>
    </div>
</div>
@include('components.modal-footer')
<!-- /Modal -->

{{--Slide Panel Trigger--}}
<div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
     data-selectable="selectable">
    <button type="button" class="btn btn-floating btn-info waves-effect"
            data-toggle="modal" data-target="#it-skills">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
{{--Slide Panel Trigger--}}




<script>$('#it-skills-level').selectObj('it-skills-level')</script>
<script src="{{asset('js/custom/plugins/page-row/itskills-row.js')}}"></script>
<script>
//    function confirmation(elem,isC,id){
//        $.ajax({
//            url:'/personal-cards/contact-confirm/'+id+'/'+isC+'/',
//            type: 'GET',
//            success: function(response){
//                if(response == 200){
//                    $('[href="/personal-cards/contacts"]').click();
//                }
//            }
//        });
//    }
    $('#itskills-search').search('itskills-search','itskills_pagination');
    $('#language-pagination').pagination('load','itskills_pagination','itskills-search');
</script>
