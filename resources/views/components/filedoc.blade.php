<div class="modal moodal fade bs-example-modal-lg" id="fileShow" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="color: black!important;">
            <div class="modal-header">
                    <button type="button" class="close" onclick="closeModal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" align="center">Əmr</h4>
            </div>
            <div class="modal-body" id="tablehide">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal();"  class="btn btn-default" >İmtina</button>
                <form action="{{url('orders/gen-download')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="html" id="data" value="">
                    <button type="submit"  class="btn btn-primary"><i class="icon md-download" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        console.log('aaaa');
        $('#fileShow').modal('hide');
        document.getElementById('ordersModal').style.overflow = "scroll";
        document.getElementById('html').style.overflow = "hidden";
        $('#userInVacationIdY').next().closest('.select2-container--default').css({'z-index':'9001'})
//        alert('gddgdd')

    }

</script>