<form method="POST" id="ShiftInWeekDayForm">

    <div class="row">

        <input type="hidden" name="shiftId" value="{{ $id }}">

        <div class="col-md-4">
            <h4>Həftənin günü: </h4>
            <select name="weekDay" id="weekDays" class="form-control select">
                <option></option>
                <option value="1">Bazar ertəsi   </option>
                <option value="2">Çərşənbə axşamı</option>
                <option value="3">Çərşənbə       </option>
                <option value="4">Cümə axşamı    </option>
                <option value="5">Cümə           </option>
                <option value="6">Şənbə          </option>
                <option value="7">Bazar          </option>
            </select>
        </div>

        <div class="col-md-3">
            <h4>Başlama vaxtı: </h4>
            <div class="input-group clockpicker-wrap">
                <input type="text" class="form-control clockpicker" name="startTime" required>
                <span class="input-group-addon">
                    <span class="md-time"></span>
                </span>
            </div>
        </div>

        <div class="col-md-3">
            <h4>Bitmə vaxtı: </h4>
            <div class="input-group clockpicker-wrap">
                <input type="text" class="form-control clockpicker" name="endTime" required>
                <span class="input-group-addon">
                    <span class="md-time"></span>
                </span>
            </div>
        </div>

        <div class="col-md-2 pt-40" style="padding-right: 120px !important;">
            <button id="addToTable" class="btn btn-floating btn-xs btn-primary waves-effect"
                    data-target="#rank-types-modal" data-toggle="modal" type="submit" title="Əlavə et">
                <i class="icon md-plus" aria-hidden="true"></i>
            </button>
        </div>

    </div>

</form>

@if(count($arr) > 0)

    @foreach($arr as $item)

        <div class="row mt-10" id="{{ $item['relId'] }}">

            <div class="col-md-4">
                <select name="weekDay" id="weekDays" class="form-control select" disabled="disabled">
                    <option value="{{ $item['weekDay']['id'] }}">{{ $item['weekDay']['text'] }}</option>
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group clockpicker-wrap">
                    <input type="text" class="form-control clockpicker" name="startTime"
                           value="{{ $item['startTime'] }}" disabled="disabled">
                    <span class="input-group-addon">
                        <span class="md-time"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="input-group clockpicker-wrap">
                    <input type="text" class="form-control clockpicker" name="endTime"
                           value="{{ $item['endTime'] }}" disabled="disabled">
                    <span class="input-group-addon">
                        <span class="md-time"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-2" style="padding-right: 115px !important; padding-top: 5px !important;">
                <button onclick="remove('{{ $item['relId'] }}')" class="close"
                        data-target="#rank-types-modal" data-toggle="modal" type="submit">
                    <i class="icon md-close" aria-hidden="true"></i>
                </button>
            </div>

        </div>

    @endforeach

@else

    <div class="row mt-10">

        <div class="col-md-12 alert alert-warning text-center">
            Məlumat daxil edilməmişdir!
        </div>

    </div>

@endif

<div id="appendArea"></div>

<script>

    /*
     *
     * ShiftInWeekDayStore
     * */

    $('#ShiftInWeekDayForm').on('submit', function (event) {

        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: '{{ route('shift-in-week-day.store') }}',
            type: 'POST',
            data: $('#ShiftInWeekDayForm').serialize(),
            success: function (response) {

                if (parseInt(response.code) === 201) {

                    $('#appendArea').append(loadResponse(response));
                    swal('Uğurlu!', 'Əlavə olundu', 'success');

                } else {

                    swal('Xəta!', response.message, 'error');

                }

            }

        });


    });

    /*
    * remove relation
    * */

    function remove(relId) {

        swal({
                title: "Əminsiniz?",
                text: "Siz elementi silirsiniz!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#66BB6A",
                confirmButtonText: "Bəli, silinsin!",
                cancelButtonText: "Xeyr, imtina!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {

                if (isConfirm) {

                    $.ajax({
                        url: '{{ url('/helper-lists/shift-in-week-day/') }}' + '/' + relId,
                        type: 'DELETE',
                        data: {},
                        success: function (response) {

                            if (parseInt(response.code) === 200) {

                                swal('Silindi!', '', 'success');
                                $('div#' + relId).remove();

                            } else {

                                swal('Xəta!', response.message, 'error');

                            }

                        }
                    });

                }

            });

    }

    /*
    * load crated resource to table body
    * */

    function loadResponse(data) {

        var row = '';

        row +=      '<div class="row mt-10" id="'+data.relId+'">' +
                        '<div class="col-md-4">' +
                        '<select name="weekDay" id="weekDays" class="form-control select" disabled="disabled">' +
                             '<option value="'+data.weekDayId+'">'+data.weekDayText+'</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<div class="input-group clockpicker-wrap">' +
                                '<input type="text" class="form-control clockpicker" name="startTime" value="'+data.startTime+'" disabled="disabled">' +
                                '<span class="input-group-addon">' +
                                    '<span class="md-time"></span>' +
                                '</span>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<div class="input-group clockpicker-wrap">' +
                                '<input type="text" class="form-control clockpicker" name="endTime" value="'+data.endTime+'" disabled="disabled">' +
                                '<span class="input-group-addon">' +
                                    '<span class="md-time"></span>' +
                                '</span>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-2" style="padding-right: 115px !important; padding-top: 5px !important;">' +
                            '<button onclick="remove(\'' + data.relId + '\')" class="close" data-target="#rank-types-modal" data-toggle="modal" type="submit">' +
                                '<i class="icon md-close" aria-hidden="true"></i>' +
                            '</button>' +
                        '</div>' +
                     '</div>';


        return row;
    }

    /*
    * sleect2 and clockpicker
    * */

    $('#weekDays').select2({
        width: '100%',
        placeholder: 'Seçim edin...',
        dropdownParent: $('#panel')
    });

    $('.clockpicker').clockpicker({
        donetext: 'Təsdiq'
    });

</script>