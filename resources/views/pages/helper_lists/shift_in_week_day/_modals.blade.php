@include('components.modal-header' , ['id' => 'list-shift-modal','mdlTitle' => 'Növbələnin əlavə olunması ekranı', 'mdUrl' => route('list-shift.store')])
<div class="row">
    <div class="col-lg-3">
        <h4>Növbənin adı: </h4>
        <input type="text" id="shiftNameModal" name="nameModal" class="form-control" required>
    </div>
    <div class="col-lg-3 mt-35">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" id="periodicModal" name="periodicModal"/>
            <label for="periodicModal">Mütəmadi</label>
        </div>
    </div>
    <div class="col-lg-6" id="periodicInputsModal"></div>
</div>
<script>

    /*
     * on checkbox change append and remove inputs
     * */

    $('input[type=checkbox]').on('change', function () {

        if ($(this).is(':checked')) {

            $('#periodicInputsModal').html(  '<div class="row">' +
                                            '<div class="col-lg-6">' +
                                                '<h4>İş günü: </h4>' +
                                                '<input type="number" id="workDayModal" name="workDayModal" class="form-control" required>' +
                                            '</div>' +
                                            '<div class="col-lg-6">' +
                                                '<h4>İstirahət günü: </h4>' +
                                                '<input type="number" id="restDayModal" name="restDayModal" class="form-control" required>' +
                                            '</div>' +
                                        '</div>');

        } else {

            $('#periodicInputsModal').empty();

        }

    });

</script>
@include('components.modal-footer')