<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'labor-search','sname' => 'lab-search' , 'pid' => 'labor_pagination' , 'pname' => 'lab-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-auto">Adı</th>
                    <th class="table-width-auto">Dövlət qulluğu</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody id="tb">
                @foreach($data->data as $key => $value)
                    <tr id="{{$value->id}}">
                        <td>{{++$key}}</td>
                        <td>{{$value->name}}</td>
                        <td><i class="icon md-check" {{$value->civilService1}}></i><i class="icon md-close" {{$value->civilService2}}></i></td>
                        <td class="text-nowrap text-right">
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('labor-contracts.edit' , $value->id)}}' , 'labor-contracts-modal')">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                            </div>
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('labor-contracts.destroy' , $value->id)}}" )'>
                                <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'labor_pagination','url' => route('labor-contracts.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}
            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#labor-contracts-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.labor_contracts._modals')
    {{-- /Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/helper-lists/laborcontracts-row.js')}}"></script>
    <script>
        $('#labor-search').search('labor-search','labor_pagination');
        $('#labor_pagination').pagination('load','labor_pagination','labor-search');
    </script>
</section>

