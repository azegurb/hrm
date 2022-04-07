<section id='links'>

    <link rel="stylesheet" href="{{ asset('core/assets/examples/css/apps/work.css') }}">
    <link rel="stylesheet" href="{{asset('js/custom/plugins/context/jquery.contextMenu.css')}}">

    <style>

        .slidePanel { width: 900px; }

    </style>

</section>

<section id='content'>
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'list-shift-search','sname' => 'list-shift-search' , 'pid' => 'list_shift_pagination' , 'pname' => 'list_shift_pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-auto">Adı</th>
                    <th class="table-width-auto">Təsnifat</th>
                    <th class="table-width-auto">İş günü</th>
                    <th class="table-width-auto">İstirahət günü</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody id="shiftBody">
                @if($data->totalCount > 0)
                    @foreach($data->data as $key => $value)
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            <td>{{$value->name}}</td>
                            <td>
                                @if($value->periodic == 1)
                                    <span class="badge badge-success">Mütəmadi</span>
                                @else
                                    <span class="badge badge-default">Qeyri-mütəmadi</span>
                                @endif
                            </td>
                            <td>{{ $value->workDay }}</td>
                            <td>{{ $value->restDay }}</td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('list-shift.destroy' , $value->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                        <script>
                            $('tr#'+ '{{$value->id}}').dblclick(function () {

                                document.loadPanel('{{ $value->id }}', '{{ $value->periodic }}');

                            });
                        </script>
                    @endforeach
                @else
                    <tr align="center"><td colspan="3" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>

            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'list_shift_pagination','url' => route('list-shift.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable" class="btn btn-floating btn-info waves-effect" data-target="#list-shift-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i>
                </button>
            </div>

        </div>
    </div>
    {{--Modal--}}
    @include('pages.helper_lists.shift_in_week_day._modals')
    {{--/Modal--}}
</section>
<section id='scripts'>

    <script src="{{asset('js/custom/plugins/page-row/helper-lists/list-shift-row.js')}}"></script>
    <script>
        $('#list-shift-search').search('list-shift-search','list_shift_pagination');
        $('#list_shift_pagination').pagination('load','list_shift_pagination','list-shift-search');

        document.loadPanel = function(id, periodic) {

            $.slidePanel.show({
                url: "{{url('/helper-lists/get-shift-slide-panel')}}",
                settings: {
                    method: 'GET',
                    data: {id : id, periodic: periodic }
                }
            });
        };

    </script>

</section>