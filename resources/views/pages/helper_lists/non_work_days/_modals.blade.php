<!-- Modal Add/Edit-->
<div class="modal fade modal-on-close modal-primary bs-example-modal-lg" id="non-work-days-modal" role="dialog"
     aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close close-modal-s" onclick="addScroll();" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel">Qeyri iş gününün əlavə olunması ekranı</h4>
            </div>
            <form id="non-work-days-modal_form" class="modal_form" method="POST"
                  action="{{route('non-work-days.store')}}">
                {{csrf_field()}}
                <div class="modal-body" onclick="onformClick()">

                    <div class="col-lg-12 float-left">
                        <h4>Adı:</h4>
                        <input type="text" class="form-control" id="inputHelpText" name="name" required="required">
                    </div>

                    <input type="hidden" name="start" value="">

                </div>
                <div class="modal-footer pt-10 pb-10 mt-5" style="background: #e8e8e8">
                    <button type="button" class="btn close-modal-s text-black btn-default">İmtina</button>
                    <button type="submit" class="btn btn-success">Təsdiq</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add/Edit-->
<div class="modal fade modal-on-close modal-primary bs-example-modal-lg" id="non-work-days-edit-modal" role="dialog"
     aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close close-modal-s" onclick="addScroll();" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel">Qeyri iş gününün redaktə olunması ekranı</h4>
            </div>

            <div class="modal-body">

                <form id="non-work-days-edit-modal_form" class="modal_form" method="POST" action="">
                    {{csrf_field()}}

                    <div class="col-lg-12 float-left">
                        <h4>Adı:</h4>
                        <input type="text" class="form-control" id="inputHelpText" name="name" required="required">
                    </div>

                    <input type="hidden" name="start" value="">
                    <input type="hidden" name="_method" value="PUT">

                </form>

                <form id="event-delete-form" action="" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    {{csrf_field()}}
                </form>

            </div>
            <div class="modal-footer pt-10 pb-10 mt-5" style="background: #e8e8e8">
                <button type="button" class="btn close-modal-s text-black btn-default">İmtina</button>
                <button type="submit" form="event-delete-form" class="btn btn-danger">Sil</button>
                <button type="submit" form="non-work-days-edit-modal_form" class="btn btn-success">Təsdiq</button>
            </div>
        </div>
    </div>
</div>