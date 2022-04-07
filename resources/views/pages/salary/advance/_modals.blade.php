@include('components.modal-header' , ['id' => 'advance-modal', 'mdlSize' => 'l', 'mdlTitle' => 'Avansın əlavə edilməsi ekranı', 'mdUrl' => route('advance.store'), 'tb' => 'tb'])

<div class="row">

    <div class="col-3">
        <h4>Əməkdaş: </h4>
        <select name="userId" id="userId" class="userId form-control select" data-url="{{ route('users','select') }}" required>
            <option></option>
        </select>
    </div>

    <div class="col-3">
        <h4>Struktur: </h4>
        <input type="text" step="any" class="form-control" id="structureName" disabled="">
    </div>

    <div class="col-1">
        <h4>Faizlə:</h4>
        <input type="checkbox" id="isPercent" name="isPercent" checked/>
        <label for="isPercent" id="labelIsPercent"></label>
    </div>

    <div class="col-2 col-value">
        <h4>Faiz: </h4>
        <input type="number" id="value" step="any" min="0" max="100" name="value" class="form-control" required>
    </div>

    <div class="col-2 mt-25">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" id="isActive" name="isActive" checked>
            <label for="isActive">Aktivdir</label>
        </div>
    </div>

</div>

@include('components.modal-footer')