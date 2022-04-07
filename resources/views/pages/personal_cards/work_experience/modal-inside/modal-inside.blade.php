<div class="row">
    <div class="col-lg-4 float-left">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" id="differentOrg" value="true" name="differentOrg" {{!empty($data) && $data->data->differentOrg == false && $data->data->isClosed == false ? 'disabled' : ''}} {{!empty($data) && $data->data->differentOrg == false ? '' : 'checked'}} />
            <label for="differentOrg"><b>Digər Struktur</b></label>
        </div>
    </div>
</div>
<div id="appendonchange">
    @if(!empty($data) && $data->data->differentOrg == false )
        @include('pages.personal_cards.work_experience.modal-inside._unchecked' , ['data' => $data])
    @elseif(!empty($data) && $data->data->differentOrg == true)
        @include('pages.personal_cards.work_experience.modal-inside._checked' , ['data' => $data])
    @else
        @include('pages.personal_cards.work_experience.modal-inside._checked')
    @endif
</div>
<script>
    @if(!empty($url))
        modalFormUrl('{{$url}}');
    @else
        modalFormUrl();
    @endif
</script>