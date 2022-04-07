<header class="slidePanel-header pr-35" style="background-color: #3547a9">
    <div id="slidePanelClose" class="slidePanel-actions custom-x">
        <button type="button" class="btn btn-pure ml-50 btn-inverse slidePanel-close actions-top icon md-close"
                aria-hidden="true"></button>
    </div>
    <h1>Növbənin redaktə olunması ekranı</h1>
</header>
<div id="panel" class="container-fluid" style="height: 100%;">
    <div class="row" style="height: 100%;">
        <div class="col-xxl-12 col-lg-12 col-xs-12 loader_panel" style="height:100%;">
            <!-- Tabs In The Panel -->
            <div class="panel">

                <form method="POST" id="updateShift">

                    <div class="row" id="shiftRow">
                        <div class="col-lg-3">
                            <h4>Növbənin adı: </h4>
                            <input type="text" id="shiftName" name="name" class="form-control" value="{{ $shift->name }}" disabled required>
                        </div>
                        <div class="col-lg-3 mt-40">
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox" id="periodic" name="periodic" @if($shift->periodic) {{ 'checked' }} @endif disabled/>
                                <label for="periodic">Mütəmadi</label>
                            </div>
                        </div>
                        <div class="col-lg-6" id="periodicInputs">
                            @if($shift->periodic)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>İş günü: </h4>
                                        <input type="number" id="workDay" name="workDay" class="form-control" value="{{ $shift->workDay }}" disabled required>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4>İstirahət günü: </h4>
                                        <input type="number" id="restDay" name="restDay" class="form-control" value="{{ $shift->restDay }}" disabled required>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @foreach($arr as $item)
                            <input type="hidden" name="relIds[]" value="{{ $item['relId'] }}">
                        @endforeach
                    </div>

                </form>

                <div class="row mt-30">
                    <div class="col-lg-12 bg-grey-100 text-center"><h3>Detallar</h3></div>
                </div>

                @if($shift->periodic)
                    @include('pages.helper_lists.shift_in_week_day.slide-panel-content.periodic')
                @else
                    @include('pages.helper_lists.shift_in_week_day.slide-panel-content.non-periodic')
                @endif

            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/custom/plugins/context/jquery.contextMenu.js')}}"></script>
<script>

    /*
    * hide slide panel on x click
    * */
    $('#slidePanelClose').on('click', function () {
        $.slidePanel.hide();
    });


    /*
    * build and control context menu
    * */
    $.contextMenu({
        selector: '#shiftRow',
        items: {
            "save": {

                name: "Saxla",

                icon: "",

                disabled: function (key, options) {

                    /* disabling and enabling item will be defined by  'edit' click */
                   return !this.data('disabled');

                },

                callback: function (key, options) {

                    /*
                    * check if shift type changed
                    * */

                    if (this.data('defaults').checkbox != $('input[type=checkbox]').prop('checked')) {

                        swal({
                                title: "Diqqət!",
                                text: "Növbənin təsnifatını dəyişdiyiniz üçün növbəyə aid bütün detallar silinəcəkdir. Təsdiqlənsin?",
                                type: "info",
                                showCancelButton: true,
                                confirmButtonColor: "#66BB6A",
                                confirmButtonText: "Bəli, təsdiqlənsin!",
                                cancelButtonText: "Xeyr, imtina!",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function (isConfirm) {

                                $('#updateShift').append('<input type="hidden" name="changed" value="true">');

                                request();

                            });

                    } else {

                        request();
                    }


                }
            },
            "edit": {

                name: 'Dəyişdir',

                icon: "",

                callback: function (key, options) {

                    /*
                    * save input and checkbox state in private data
                    * */

                    var checked = false;
                    var name    = $('input[name="name"]').val();
                    var workDay = $('input[name="workDay"]').val();
                    var restDay = $('input[name="restDay"]').val();

                    if ($('input[type=checkbox]').is(':checked')) {
                        checked = true;
                    }

                    /*
                    * save it as defaults
                    * */
                    this.data('defaults', {
                        checkbox: checked,
                        name: name,
                        workDay: workDay,
                        restDay: restDay
                    });

                    $('#shiftName').removeAttr('disabled');
                    $('#periodic') .removeAttr('disabled');
                    $('#workDay').removeAttr('disabled');
                    $('#restDay') .removeAttr('disabled');

                    this.data('disabled', true);

                },

                disabled: function (key, options) {

                    /* disabling and enabling item will be defined by  'edit' click */
                    return this.data('disabled');

                }
            },
            "quit": {

                name: 'İmtina',

                icon: '',

                callback: function (key, options) {

                    /*
                    *
                    * when cancel is clicked get saved default state and
                    * put them into input values
                    * */

                    var defaults = this.data('defaults');

                    $('input[type=checkbox]').prop('checked', defaults.checkbox);
                    $('input[name="name"]').val(defaults.name);
                    $('input[name="workDay"]').val(defaults.workDay);
                    $('input[name="restDay"]').val(defaults.restDay);

                    /* mark them as disabled*/
                    $('#shiftName').prop('disabled', true);
                    $('#periodic') .prop('disabled', true);
                    $('#workDay') .prop('disabled', true);
                    $('#restDay') .prop('disabled', true);

                    /* enable edit item */
                    this.data('disabled', false);

                },

                disabled: function (key, options) {

                    /* disabling and enabling item will be defined by  'edit' click */
                    return !this.data('disabled');

                }
            }
        }
    });

    /*
     * get single table row content
     *
     * */

    var getRow = function (item, index) {

        for (var member in item) {

            if (item[member] == null)
                item[member] = '';

        }

        var periodic = '';

        if (item.periodic == true) {
            periodic = '<span class="badge badge-success">Mütəmadi</span>';
        } else {
            periodic = '<span class="badge badge-default">Qeyri-mütəmadi</span>';
        }

        /* return single instance of table row */

        return  '<td>' + index + '</td>' +
                '<td>' + item.name + '</td>' +
                '<td>' + periodic + '</td>' +
                '<td>' + item.workDay + '</td>' +
                '<td>' + item.restDay + '</td>' +
                '<td class="text-right">' +
                    '<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="removeData($(this) , \'/helper-lists/list-shift/' + item.id + '  \' )">' +
                        '<i class="icon md-delete" aria-hidden="true"></i>' +
                        '<span class="tptext tpdel">Sil</span>' +
                    '</div>' +
                '</td>';

    };


    /*
    *
    * make ajax request for update
    * */

    function request() {

        var shift = $('input[name="shiftId"]').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/helper-lists/list-shift/' + shift,
            type: 'PUT',
            data: $('#updateShift').serialize(),
            success: function (response) {

                if (parseInt(response.code) === 200) {

                    document.loadPanel(response.data.id, response.data.periodic);

                    var row = $('#shiftBody').find('#'+response.data.id);
                    /* add highlight class and remove it after 1.5 seconds */

                    /*
                    * update event listener
                    * */
                    $('tr#'+response.data.id).unbind('dblclick');


                    $('tr#'+response.data.id).dblclick(function () {

                        document.loadPanel(response.data.id, response.data.periodic);

                    });

                    row.addClass('highlight');
                    setTimeout(function () {
                        row.removeClass('highlight')
                    }, 1500);

                    var rowNum = row.find('td').first().text();
                    if (isNaN(parseInt(rowNum))) rowNum = 0;
                    $('#shiftBody').find('#'+response.data.id).html(getRow(response.data, parseInt(rowNum)));

                    swal('Uğurlu!', 'Yeniləndi', 'success');


                } else {

                    swal('Xəta!', response.message, 'error');

                }

            }

        });

    }

    /*
    * on checkbox change append and remove inputs
    * */

    $('input[type=checkbox]').on('change', function () {

        if ($(this).is(':checked')) {

            $('#periodicInputs').html(  '<div class="row">' +
                                            '<div class="col-lg-6">' +
                                                '<h4>İş günü: </h4>' +
                                                '<input type="number" id="workDay" name="workDay" class="form-control" required>' +
                                            '</div>' +
                                            '<div class="col-lg-6">' +
                                                '<h4>İstirahət günü: </h4>' +
                                                '<input type="number" id="restDay" name="restDay" class="form-control" required>' +
                                            '</div>' +
                                        '</div>');

        } else {

            $('#periodicInputs').empty();

        }

    });


</script>