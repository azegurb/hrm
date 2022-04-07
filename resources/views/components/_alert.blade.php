@if(session()->has('alert'))
    <script>
        swal({
            title : "Uğurlu",
            text  : "{{ session()->get('alert')['message'] }}",
            type  : "{{ session()->get('alert')['type'] }}",
            timer : 2000,
            showConfirmButton: false
        });
    </script>
@endif
<div class="modal fade bs-example-modal-sm alertModal" id="alertModal" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
                <div class="loader vertical-align-middle loader-ellipsis"></div>
        </div>
    </div>
</div>