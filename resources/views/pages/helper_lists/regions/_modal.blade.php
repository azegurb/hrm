<!-- Modal Add/Edit-->
<div class="modal fade modal-on-close modal-primary bs-example-modal-lg" id="regions-modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close close-modal-s" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel">Şəhər və rayonlar</h4>
            </div>
            <form id="regions-modal_form" class="modal_form" data-pid="" data-tb=""
                  action="{{route('regions.store')}}" method="POST" data-plugin="formdatas">
                {{ csrf_field() }}
                <div class="modal-body" onclick="onformClick()">

                    @include('pages.helper_lists.regions._content-modal')

                </div>
                <div class="modal-footer pt-10 pb-10 mt-5" style="background: #e8e8e8">
                    <button type="button" class="btn close-modal-s text-black btn-default">İmtina</button>
                    <button type="submit" class="btn btn-success">Təsdiq</button>
                </div>
            </form>
        </div>
    </div>
</div>