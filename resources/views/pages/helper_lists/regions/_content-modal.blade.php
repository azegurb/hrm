
<div class="row">
    <div class="col-lg-6">
        <h4 >Üst şəhər/rayon: </h4>
        <select id="parentId"
                name="parentId"
                class="form-control"
                data-url="/helper-lists/list-regions"
                data-placeholder="Şəhərin/Rayonun aid olduğu şəhər/rayon">
            <option></option>

            @if (isset($region) && $region != null)
                <option value="{{ $region->parentIdId }}" selected>{{ $region->parentIdName }}</option>
            @endif

        </select>
    </div>
    <div class="col-lg-6">
        <h4 >Tipi: </h4>
        <select id="listRegionTypeId"
                name="listRegionTypeId"
                class="form-control"
                data-url="/helper-lists/list-region-types"
                data-placeholder="Ərazinin tipini seçin" required>
            <option></option>

            @if (isset($region) && $region != null)
                <option value="{{ $region->listRegionTypeIdId }}" selected>{{ $region->listRegionTypeIdName }}</option>
            @endif

        </select>
    </div>
    <div class="col-lg-6">
        <h4 >Rayonun adı: </h4>
        <input type="text" id="name" name="name" class="form-control" required
        @if (isset($region) && $region != null)
            value="{{ $region->name }}"
        @endif>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // init select2 to fetch data
        $('#parentId').selectObj('parentId', 'regions-modal');
        // region type
        $('#listRegionTypeId').selectObj('listRegionTypeId', 'regions-modal');

        @if(isset($region) && $region != null)
        $('#regions-modal').find('form').attr('action', '{{ route('regions.update', $region->id) }}');
        $('#regions-modal').find('form').append('<input type="hidden" name="_method" value="PUT">');
        @else
        $('#regions-modal').find('form').attr('action', '{{ route('regions.store') }}').attr('method', 'POST');
        $('#regions-modal').find('input[name="_method"]').remove();
        @endif

    });
</script>