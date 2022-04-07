<style>
    .select2-container--disabled{
        width:200px!important;
    }
</style>
<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'position-provisions-search','sname' => 'posprov-search' , 'pid' => 'position_provisions_pagination' , 'pname' => 'posprov-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-auto">Struktur</th>
                    <th class="table-width-auto">Vəzifə</th>
                    <th class="table-width-8"> Təminatlar</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody id="tb">
                @if($data->totalCount > 0)

                    @foreach($data->data as $key => $value)
                        <tr id="{{$value->positionId}}">
                            <td>{{++$key}}</td>
                            <td>{{$value->structureName}}</td>
                            <td>{{$value->positionName}}</td>
                            <td>
                                @foreach ($value->provisionList as $item)
                                    <span class="badge badge-default">{{ $item->provisionName }}</span><br>
                                @endforeach
                            </td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('position-provisions.edit' , $value->positionId)}}' , 'position-provisions-modal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('position-provisions.destroy' , $value->positionId)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center"><td colspan="5" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'position_provisions_pagination','url' => route('position-provisions.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#position-provisions-modal-store" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.position_provisions._modals')
    @include('pages.helper_lists.position_provisions._modals_store')
    {{-- /Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/helper-lists/position-provision-row.js')}}"></script>
    <script>
        $('#position-provisions-search').search('position-provisions-search','position_provisions_pagination');
        $('#position_provisions_pagination').pagination('load','position_provisions_pagination','position-provisions-search');

        $('.select').select2({
            placeholder: 'Seçilməyib',
            width: '100%'
        });

        var listPositions = $('#positionName');
        var listStructures = $('#structure');

        listStructures.selectObj('structure');

        $('#provision').selectObj('provision');
        $('#provisionAdd').selectObj('provisionAdd');

        var url = listPositions.attr('data-url');

        listStructures.on('select2:select', function(){

            listPositions.attr('data-url', '');
            listPositions.selectObj('positionName', 'position-provisions-modal-store', url + '/' + $(this).val());

        });

        $('#provision').on('select2:unselect', function (event) {

            $(document).find('input[name="relId[' + event.params.data.id +']"]').remove();

        });

        $(document).on('hidden.bs.modal', function () {

            $('select.select').empty('');

        });

        listPositions.on('select2:select', function () {

            var posId = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/helper-lists/get-provisions-by-position/' + posId,
                success: function (response) {

                    var select = $('#provision');
                    var option = '';

                    if (response.length > 0) {

                        $(document).find('form').append('<input name="_method" type="hidden" value="PUT">');
                        $(document).find('form').attr('action', '/helper-lists/position-provisions/' + posId);

                        response.forEach(function (item) {

                            option += '<option value="' + item.id + '" selected>' + item.text + '</option>';

                        });

                        select.html(option);
                        select.trigger('change');

                    } else {

                        select.html('');

                    }



                }

            });

        });


    </script>
</section>