<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'dismissal-search','sname' => 'dis-directions-search' , 'pid' => 'dismissal_pagination' , 'pname' => 'dis-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                    <tr>
                        <th class="table-width-5">№</th>
                        <th class="table-width-auto">Adı</th>
                        <th class="table-width-8"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($data->totalCount > 0)
                        @foreach($data->data as $key => $value)
                            <tr id="{{$value->id}}">
                                <td>{{++$key}}</td>
                                <td>{{$value->name}}</td>
                                <td class="text-nowrap text-right">
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('dismissal.edit' , $value->id)}}' , 'dismissal-modal')">
                                        <i class="icon md-edit" aria-hidden="true"></i>
                                            <span class="tptext tpedit">Düzəliş et</span>
                                    </div>
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('dismissal.destroy' , $value->id)}}" )'>
                                        <i class="icon md-delete" aria-hidden="true"></i>
                                            <span class="tptext tpdel">Sil</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr align="center"><td colspan="3" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                    @endif
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'dismissal_pagination','url' => route('dismissal.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#dismissal-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.dismissal._modals')
    {{-- /Modal --}}

</section>
<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/helper-lists/dismissal-row.js')}}"></script>
    <script>
        $('#dismissal-search').search('dismissal-search','dismissal_pagination');
        $('#dismissal_pagination').pagination('load','dismissal_pagination','dismissal-search');
    </script>
</section>

