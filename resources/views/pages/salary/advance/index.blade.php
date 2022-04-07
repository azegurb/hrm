<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'advance-search','sname' => 'advance-search' , 'pid' => 'advance_pagination' , 'pname' => 'advance-pagination'])
            {{-- /Filters --}}

            <table class="table table-hover table-advance table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    {{--<th class="table-width-auto"></th>--}}
                    <th class="table-width-auto">Adı Soyadı</th>
                    <th class="table-width-auto">Avans faizi</th>
                    <th class="table-width-auto">Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="tb">
                @php($no = 0)
                @if($data->totalCount > 0)
                @foreach($data->data as $key => $value)
                    <tr id="{{$value->id}}">
                        <td>{{++$no}}</td>
                        <td>{{$value->userIdLastName}} {{$value->userIdFirstName}} {{$value->userIdPatronymic}}</td>
                        <td>{{$value->value}} {{$value->isPercent ? '%' : 'AZN'}}</td>
                        <td>
                            <span class="badge badge-{{$value->isClosed ? 'danger' : 'success'}}">{{ $value->isClosed ? 'Deaktiv' : 'Aktiv' }}</span>
                        </td>
                        <td class="text-nowrap text-right">
                            <button id="{{$value->id}}" class="btn btn-md btn-icon btn-flat btn-default waves-effect edit-button">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr align="center"><td colspan="4" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>

             {{--Pagination load more button--}}
            @include('components.pagination' , ['id' => 'advance_pagination','url' => route('advance.index') , 'totalCount' => $data->totalCount,'page' => $page])
             {{--/Pagination load more button--}}

        </div>
    </div>
    {{-- Modal --}}
    @include('pages.salary.advance._modals')
    {{-- /Modal --}}

    {{--Store button--}}

    <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
        <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#advance-modal" data-toggle="modal" type="button">
            <i class="icon md-plus" aria-hidden="true"></i></button>
    </div>
    {{--/Store button--}}

</section>

<section id="scripts">
    <script src="{{asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/salary/advance-row.js')}}"></script>
    <script>
        $('#privileges-search').search('advance-search','advance_pagination');
        $('#privileges_pagination').pagination('load','advance_pagination','advance-search');
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

    <script>

        $('.select').select2({
            width: '100%',
            placeholder: 'Seçilməyib'
        });

        function write(posName,strName){
            var strName = strName;

            $('#structureName').val(strName);


        }

        $('.userId').selectObj('userId', 'advance-modal');

        $('#userId').on('select2:select', function () {

            $('#structureName').val('');

            // Define variables
            var userId =  $(this).val();
            var url    =  '/orders/get-position-by-userId/' + userId;

            // Send AJAX request
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    write(response.positionId.posNameId.name,response.positionId.structureId.name);
                },
                error: function(error){

                    console.log('error yarandi');
                }
            });


        });

        new Switchery(document.querySelector('#isPercent'), {
            color: '#3f51b5'
        });

        $(document).on('change', '#isPercent', function() {

            let max   = 100;
            let label = 'Faiz';

            if ($(this).is(':checked')) {

                max   = 100;
                label = 'Faiz';

            } else {

                max   = 10000;
                label = 'Məbləğ (AZN)';

            }

            $('.col-value').html(`<h4>${label}: </h4>
                <input type="number" id="value" step="any" min="0" max="${max}" name="value" class="form-control" required>`);

        });

        $('.table-advance').on('click', '.edit-button', function() {

            let id = $(this).attr('id');

            $.ajax({
                url: `/salary/advance/${id}/edit`,
                success: function(response) {
                    if (response.code == 200) {

                        $('#advance-modal').find('form').append('<input type="hidden" name="_method" value="PUT">');
                        $('#advance-modal').find('form').attr('action', '/salary/advance/'+response.data.id);

                        let user = `<option value="${response.data.userIdId}" selected>${response.data.userIdLastName} ${response.data.userIdFirstName} ${response.data.userIdPatronymic}</option>`;

                        $('#userId').html(user);

                        var url = '/orders/get-position-by-userId/' + response.data.userIdId;

                        // Send AJAX request
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                write(response.positionId.posNameId.name,response.positionId.structureId.name);
                            },
                            error: function(error){

                                console.log('error yarandi');
                            }
                        });

                        if (response.data.isClosed && $('#isActive').is(':checked')) {
                            $('#isActive').click();
                        } else if (!response.data.isClosed && !$('#isActive').is(':checked')){
                            $('#isActive').click();
                        }

                        if (!response.data.isPercent && $('#isPercent').is(':checked')) {
                            $('#isPercent').click();
                        } else if (response.data.isPercent && !$('#isPercent').is(':checked')){
                            $('#isPercent').click();
                        }

                        $('#value').val(response.data.value);

                    }
                    else {

                        // error

                    }

                    $('#advance-modal').modal('show');
                },
                error: function(exception, type, message) {
                    // handle
                }
            });

        });

        $('#advance-modal').on('hide.bs.modal', function() {

            $(this).find('form').attr('action', '{{route('advance.store')}}');
            $(this).find('[name="_method"]').remove();
            $('select').val('');
            $('input[type="text"]').val('');

        });

    </script>

</section>