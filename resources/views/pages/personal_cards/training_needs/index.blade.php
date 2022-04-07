<section id="links">
        <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.css') }}">
        <link rel="stylesheet" href="{{ asset('core/global/vendor/ladda/ladda.css') }}">
        <link rel="stylesheet" href="{{asset('core/assets/examples/css/uikit/buttons.css')}}">
        <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
</section>

<section id="content">

    <div class="panel" id="personalCards_TrainingNeeds">
        <div class="panel-heading p-20">
            {{--Filters--}}
            @include('components.filter-bar' , ['sid' => 'training-search','sname' => 't-search' , 'pid' => 'training_needs_paginate' , 'pname' => 't-pagination'])
            {{--End Filters--}}
        </div>
        <div class="clearfix"></div>
        <div class="panel-body pt-0">
            <div class="row">
                {{--@if(count($new) > 0)--}}
                    {{--<table class="table">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th class="table-width-5">№</th>--}}
                            {{--<th class="table-width-30">Təlim təlabatının adı</th>--}}
                            {{--<th class="table-width-auto">Qeyd</th>--}}
                            {{--<th class="table-width-15">Status</th>--}}
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
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="table-width-5">№</th>
                            <th class="table-width-30">Təlim təlabatının adı</th>
                            <th class="table-width-auto">Qeyd</th>
                            <th class="table-width-15">Status</th>
                            <th class="text-right table-width-8"></th>
                        </tr>
                    </thead>
                    <tbody>
                    {{--@if(count($new) > 0)--}}
                        {{--@foreach($new as $newNC)--}}
                            {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['listTrainingNameId.name','note']])--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                    @if($data->totalCount > 0)
                        @foreach($data->data as $key=>$userTrainingNeed)
                        <tr id="{{ $userTrainingNeed->id }}">
                            <td>{{ ++$key }}</td>
                            <td>{{ $userTrainingNeed->listTrainingNameId->name }}</td>
                            <td>{{ $userTrainingNeed->note }}</td>
                            <td>
                                @if($userTrainingNeed->isclosed == true)
                                    Ödənilib
                                @elseif($userTrainingNeed->isclosed == false || $userTrainingNeed->isclosed == null)
                                    Ödənilməyib
                                @endif
                            </td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('training-needs.edit' , $userTrainingNeed->id)}}' , 'trainingModal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('training-needs.destroy' , $userTrainingNeed->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                        {{--@if(!is_null($userTrainingNeed->nc))--}}
                            {{--@php($userTrainingNeed->nc->isclosed = $userTrainingNeed->nc->isclosed == true ?  'Ödənilib' : 'Ödənilməyib')--}}
                            {{--@include('components.row', ['value' => $userTrainingNeed->nc,'count' => $key,'ccon' => $data->ccon,'row' => ['listTrainingNameId.name','note', 'isclosed']])--}}
                        {{--@endif--}}
                        @endforeach
                    @else
                        <tr align="center"><td colspan="5" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                    @endif
                    </tbody>
                </table>
                {{-- Pagination load more button --}}
                @include('components.pagination' , ['id' => 'training_needs_paginate','url' => route('training-needs.index'), 'totalCount' => $data->totalCount,'page' => $page])
                {{-- /Pagination load more button --}}
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include('components.modal-header' , ['id' => 'trainingModal','mdlTitle' => 'Təlim tələbatlarının qeydiyyatı', 'mdUrl' => route('training-needs.store')])
    <div class="row">
        <div class="col-md-6">
            <h4>Təlim tələbatının adı:</h4>
            <select class="form-control select" id="listTrainingNameId" name="listTrainingNameId" required="required" data-url="{{ route('training-names.list') }}">
                <option></option>
            </select>
        </div>
        <div class="col-md-12 mt-20">
            <h4>Qeyd:</h4>
            <textarea name="note" id="" class="form-control" cols="30" rows="5" required="required"></textarea>
        </div>
    </div>
{{--@include('pages.personal_cards.common', ['modalid'=>'trainingModal_form'])--}}
@include('components.modal-footer')
<!-- End Modal -->

    <!-- Add button-->
    <div class="site-action">
        <button type="button" data-target="#trainingModal" data-toggle="modal" class="btn btn-floating btn-info waves-effect">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
    <!-- /Add button-->

</section>

<section id="scripts">
    <script src="{{asset('core/assets/examples/js/uikit/panel-structure.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/training-needs-row.js')}}"></script>
    <script>
//        function confirmation(elem,isC,id){
//            $.ajax({
//                url:'/personal-cards/education-confirm/'+id+'/'+isC+'/',
//                type: 'GET',
//                success: function(response){
//                    if(response == 200){
//                        $('[href="/personal-cards/contacts"]').click();
//                    }
//                }
//            });
//        }

        $('#listTrainingNameId').selectObj('listTrainingNameId');
        $('#training-search').search('training-search','training_needs_paginate');
        $('#training_needs_paginate').pagination('load','training_needs_paginate','training-search');
    </script>
    @if(count($errors) > 0)
        <script>
            swal(
                {
                    type: 'error',
                    title: 'Xəta!',
                    text: 'Xanalar boş buraxıla bilməz.'
                })
        </script>
    @endif
</section>