<section id='links'>
</section>

<section id='content'>

    <div class="row">
        <div class="col-xl-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-6">
                        <h4>Təlim tələbatı</h4>
                        <select class="form-control select" id=""  name="">
                            <option value="1">Ödənilib</option>
                            <option value="2">Ödənilməyib</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="panel" id="personalCards_Trainings">
        <div class="panel-heading p-20">
            {{--Filters--}}
            @include('components.filter-bar' , ['sid' => 'training-search','sname' => 't-search' , 'pid' => 'training_pagination' , 'pname' => 't-pagination'])
            {{--End Filters--}}
        </div>
        <div class="clearfix"></div>
        <div class="panel-body pt-0">
            <div class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th id="testin" class="table-width-5" data-id="">№</th>
                        <th class="table-width-auto">Təlimin adı</th>
                        <th class="table-width-15">Təlimin forması</th>
                        <th class="table-width-15">Təlimin başlama tarixi</th>
                        <th class="table-width-15">Təlimin bitmə tarixi</th>
                        <th class="text-right table-width-8"></th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    @if($data->totalCount > 0)
                        @foreach($data->data as $key=>$value)
                            <tr id="{{$value->id}}">
                                <td>{{++$key}}</td>
                                <td>{{$value->listTrainingNameIdName}}</td>
                                <td>{{$value->listTrainingFormIdName}}</td>
                                <td>{{$value->trainingStartDate}}</td>
                                <td>{{$value->trainingEndDate}}</td>
                                <td class="text-nowrap text-right">
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('training.edit' , $value->id)}}' , 'training-modal')">
                                        <i class="icon md-edit" aria-hidden="true"></i>
                                        <span class="tptext tpedit">Düzəliş et</span>
                                    </div>
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('training.destroy' , $value->id)}}" )'>
                                        <i class="icon md-delete" aria-hidden="true"></i>
                                        <span class="tptext tpdel">Sil</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr align="center">
                            <td style="display: none">0</td>
                            <td colspan="6" class="alert alert-warning">Məlumat daxil edilməmişdir !</td>
                        </tr>
                    @endif
                    </tbody>
                </table>


                {{-- Pagination load more button --}}
                @include('components.pagination' , ['id' => 'training_pagination','url' => route('training.index') , 'totalCount' => $data->totalCount,'page' => $page])
                {{-- /Pagination load more button --}}



            </div>
        </div>
    </div>

    <!-- Add button-->
    <div class="site-action">
        <button type="button" data-target="#training-modal" data-toggle="modal" class="btn btn-floating btn-info waves-effect">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
    <!-- /Add button-->


    <!-- Modal -->
@include('pages.personal_cards.training._modal')
<!-- End Modal -->


</section>

<section id='scripts'>
    <script src="{{asset('js/custom/plugins/page-row/training-row.js')}}"></script>
    <script src="{{asset('js/custom/plugins/select-text-appender.js')}}"></script>
    <script>
        $('#listTrainingNameId').selectObj('listTrainingNameId');
        $('#listTrainingFormId').selectObj('listTrainingFormId');
        $('#listTrainingLocationId').selectObj('listTrainingLocationId');
        $('#listTrainingType').selectObj('listTrainingType');
        $('#listTrainingNeed').selectObj('listTrainingNeed');
        $('#training-search').search('training-search','training_pagination');
        $('#training_pagination').pagination('load','training_pagination','training-search');
    </script>
    @stack('scripts')
    <script>

        $('.date_id').datepicker({
            orientation: "left bottom",
            format: "dd.mm.yyyy",
            weekStart: 1
        });
    </script>


</section>