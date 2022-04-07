<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'prod-cal-search','sname' => 'prod-cal-search' , 'pid' => 'prod_cal_pagination' , 'pname' => 'prod-cal-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-auto">İl</th>
                    <th class="table-width-auto">Ay</th>
                    <th class="table-width-auto">İş günlərinin sayı</th>
                    <th class="table-width-auto">Cəmi iş saatı</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody id="tb">
                @if($data->totalCount > 0)
                    @foreach($data->data as $key => $value)
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            <td>{{$value->year}}</td>
                            <td>{{$value->month}}</td>
                            <td>{{$value->dayCount}}</td>
                            <td>{{$value->hourCount }}</td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('prod-calendar.edit' , $value->id)}}' , 'prod-cal-modal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('prod-calendar.destroy' , $value->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center"><td colspan="7" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'prod_cal_pagination','url' => route('prod-calendar.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#prod-cal-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('components.modal-header' , ['id' => 'prod-cal-modal','mdlTitle' => 'İstehsalat cədvəli növləri', 'mdUrl' => route('prod-calendar.store'), 'tb' => 'tb'])
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <h4>İl: </h4>
                    <input type="number" min="1970" max="2050" class="form-control" name="year" id="year" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <h4>Ay: </h4>
                    <select name="month" id="month" class="form-control select">
                        <option value="01"> Yanvar  </option>
                        <option value="02"> Fevral  </option>
                        <option value="03"> Mart    </option>
                        <option value="04"> Aprel   </option>
                        <option value="05"> May     </option>
                        <option value="06"> İyun    </option>
                        <option value="07"> İyul    </option>
                        <option value="08"> Avqust  </option>
                        <option value="09"> Sentyabr</option>
                        <option value="10"> Oktyabr </option>
                        <option value="11"> Noyabr  </option>
                        <option value="12"> Dekabr  </option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <h4>İş günlərinin sayı:</h4>
                    <input type="number" min="1" max="31" class="form-control" name="dayCount" id="dayCount" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <h4>Cəmi iş saatı: </h4>
                    <input type="number" min="1" max="10000" class="form-control" name="hourCount" id="hourCount" required>
                </div>
            </div>
        </div>
    @include('components.modal-footer')
    {{-- /Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/helper-lists/prod-cal-row.js')}}"></script>
    <script>
        $('.select').select2({
            width: '100%'
        });
        $('#prod-cal-search').search('prod-cal-search','prod_cal_pagination');
        $('#prod_cal_pagination').pagination('load','prod_cal_pagination','prod-cal-search');
    </script>
</section>