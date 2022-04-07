<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'privileges-search','sname' => 'privileges-search' , 'pid' => 'privileges_pagination' , 'pname' => 'privileges-pagination'])
            {{-- /Filters --}}



            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    {{--<th class="table-width-auto"></th>--}}
                    <th class="table-width-auto">Adı Soyadı</th>
                    <th class="table-width-auto">Güzəşt miqdarı</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="tb">
                @php($no = 0)
                @if($data->totalCount > 0)
                @foreach($data->data as $key => $value)
                    <tr>
                        <td>{{++$no}}</td>
                        {{--<td><img class="avatar img-fluid" src="{{$value->userIdPhoto != null ? 'data:image/png;base64,'.$value->userIdPhoto : asset('media/noavatar.png')}}" alt="..."></td>--}}
                        <td>{{$value->userIdFirstName}} {{$value->userIdLastName}}</td>
                        <td>{{$value->privilegeIdValue}} AZN</td>
                        <td class="text-nowrap text-right">
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal('{{route('privileges.edit' , $value->id)}}' , 'privileges-modal')">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                            </div>
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('privileges.destroy' , $value->id)}}" )'>
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

             {{--Pagination load more button--}}
            @include('components.pagination' , ['id' => 'privileges_pagination','url' => route('privileges.index') , 'totalCount' => $data->totalCount,'page' => $page])
             {{--/Pagination load more button--}}




        </div>
    </div>
    {{-- Modal --}}
    @include('pages.salary.privileges._modals')
    {{-- /Modal --}}

    {{--Store button--}}
    <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
        <button id="addToTable"   class="btn btn-floating btn-info waves-effect" onclick="openModal('{{route('privileges.create' )}}' , 'privileges-modal')" data-target="#privileges-modal" data-toggle="modal" type="button">
            <i class="icon md-plus" aria-hidden="true"></i></button>
    </div>
    {{--/Store button--}}

</section>

<section id="scripts">
    <script src="{{asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/salary/privileges-row.js')}}"></script>
    <script>
        $('#privileges-search').search('privileges-search','privileges_pagination');
        $('#privileges_pagination').pagination('load','privileges_pagination','privileges-search');
    </script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
    <script>
        $('.dd-content2').hide();
        $('.dd-menu2').click(function(){
            $(this).next('.dd-content2').slideToggle();
        });
    </script>

</section>