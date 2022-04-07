<!-- Modal Add/Edit-->
<div class="modal fade modal-on-close modal-primary bs-example-modal-{{$mdlSize or 'lg'}}" id="{{$id}}" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-{{$mdlSize or 'lg'}}" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close close-modal-s" onclick="addScroll();" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel">{{$mdlTitle}}</h4>
            </div>
            <form id="{{$id}}_form" class="modal_form" method="POST" data-pid="{{$pid or ''}}" data-tb="{{$tb or ''}}" action="{{$mdUrl or ''}}" onsubmit="event.preventDefault(); {{ $custom or 'postForm($(this))' }};" data-plugin="formdatas" data-url="{{$mdUrl or ''}}">
                {{csrf_field()}}
                <div class="modal-body" onclick="onformClick()">

                    <script>
                        function addScroll() {
                            document.getElementById('html').style.overflow = "scroll";
                        }
                    </script>