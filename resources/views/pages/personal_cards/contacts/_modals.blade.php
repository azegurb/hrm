@include('components.modal-header' , ['id' => 'contact-modal','mdlTitle' => 'Əlaqə vasitələri', 'mdUrl' => route('contacts.store')])
{{--@include('pages.personal_cards.common', ['modalid'=>$modalid])--}}
<div class="row">
    <div class="col-lg-6" >
        <h4 >Əlaqənin növü:</h4>
        <select class="form-control select" id="listContactType" data-url="{{route('listContactController.get')}}" name="listcontacttype" required="required">
        </select>
    </div>
    <div class="col-lg-6">
        <h4 >Əlaqə:</h4>
        <input type="text" class="form-control contact-phone phone-num" id="inputPlaceholder" name="contactinfo" required="required">
    </div>
</div>
<script>
    $('#listContactType').on('select2:select', function () {

        var label=$(this).select2('data')[0].label;

        if(label=='mobile-work' || label=='mobile-personal' || label=='phone-work' || label=='phone-home' || label=='phone-internal'){

            $('.contact-phone').addClass('phone-num');
            $(".phone-num").mask("(999) 999-99-99", {});

        }
        else {
            $('.contact-phone').removeClass('phone-num');

        }
    })
</script>

@include('components.modal-footer')