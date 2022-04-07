<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'org-structures-search','sname' => 'orgstr-search' , 'pid' => 'org_structures_pagination' , 'pname' => 'org-structures-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th>Şirkət</th>
                    <th>Struktur</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody id="tb">
                @if($data->totalCount > 0)
                    @foreach($data->data as $key => $value)
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            <td>{{$value->organizationIdName}}</td>
                            <td>{{$value->structuresNameIdName}}</td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('organizationstructures.edit' , $value->id)}}' , 'org-structures-modal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('organizationstructures.destroy' , $value->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center"><td colspan="4" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>

            {{--Pagination load more button --}}
            @include('components.pagination' , ['id' => 'org_structures_pagination','url' => route('organizationstructures.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{--/Pagination load more button --}}

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#org-structures-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.organizations.structures._modals')
    {{-- /Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/helper-lists/org-structures-row.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#listOrganizations').selectObj('listOrganizations');
            $('#organizations-search').search('organizations-search','org_structures_pagination');
            $('#org_structures_pagination').pagination('load','org_structures_pagination','organizations-search');
        })

    </script>
</section>