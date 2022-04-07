<input type="hidden" name="orderTypeLabel" value="Reward">
@php $id=uniqid(); @endphp
<div class="mt-20 multi" id="reward-{{$id}}" style="border-top:1px solid #efefef;">
    <div class="col-12 text-right">
        @if(isset($array))
            <input type="hidden" name="id[{{$id}}]" value="{{ $array->id }}">
            <input type="hidden" name="relUserPaymentsId[{{$id}}]" value="{{ $array->relUserPaymentsId['id'] }}">
        @endif
        <input  type="hidden" name="reward[]" value="{{$id}}">
        <button type="button" class="btn-remove-appended close" onclick="drop('reward-{{$id}}')"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <h4>Əməkdaş: </h4>
                <select name="userId[{{$id}}]" id="userId-{{$id}}" class="form-control select" data-url="{{ route('users','select') }}" required>
                    <option></option>
                    @if(isset($array))
                        <option value="{{ $array->userId['id'] }}" selected>{{ $array->userId['text'] }}</option>
                    @endif
                </select>
            </div>
            <div class="col-3">
                <h4>Struktur:</h4>
                <select type="text" class="form-control" id="structure-{{$id}}" readonly>
                    @if(isset($array))
                        <option value="structure" selected>{{ $array->structure }}</option>
                    @endif
                </select>
            </div>
            <div class="col-3">
                <h4>Vəzifə:</h4>
                <select type="text" class="form-control" id="positionId-{{$id}}" name="positionId[{{$id}}]" readonly>
                    @if(isset($array))
                        <option value="{{ $array->positionId }}" selected>{{ $array->positionName }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <h4>Mükafatın məbləği (AZN): </h4>
                <input  type="number" step="any" name="rewardAmount[{{$id}}]" min="1" class="form-control" required

                        @if(isset($array))
                        value="{{ $array->rewardAmount }}"
                        @endif
                >
            </div>
            <div class="col-2">
                <h4>Mükafatın verilmə tarixi: </h4>
                <div class="input-group">
                <span class="input-group-addon">
                    <i class="icon md-calendar" aria-hidden="true"></i>
                </span>
                    <input  type="text" id="rewardDate-{{$id}}" name="rewardDate[{{$id}}]" class="form-control" data-plugin="datepicker" required

                            @if(isset($array))
                            value="{{ $array->rewardDate }}"
                            @endif
                    >
                </div>
            </div>
            <div class="col-4">
                <h4 class="mb-10">&nbsp;</h4>
                <input type="checkbox" id="includingTaxes-{{$id}}" name="includingTaxes[{{$id}}]"

                       @if(isset($array) && $array->includingTaxes) checked @endif
                >
                <label class="ml-10" id="taxesLabel-{{$id}}" for="includingTaxes-{{$id}}">Vergilər və digər ödənişlər xaric</label>
            </div>
        </div>
    </div>
</div>

<script>

    new Switchery(document.querySelector('#includingTaxes-{{$id}}'), {
        color: '#3f51b5'
    });


    $('#userId-{{$id}}').selectObj('userId-{{$id}}', 'ordersModal');


    $('[data-plugin="datepicker"]').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });

    /*
     * change label of 'includingTaxes' check
     * */
    $('#includingTaxes-{{$id}}').on('change', function() {

        //console.log($(this).is(':checked'), this.checked);

        if ($(this).is(':checked')) {
            $('#taxesLabel-{{$id}}').text('Vergilər və digər ödənişlər daxil olmaqla');
        }
        else {
            $('#taxesLabel-{{$id}}').text('Vergilər və digər ödənişlər xaric');
        }

    });

    /*
     * get user position and structure on user select
     * */
    $('#userId-{{$id}}').on('select2:select', function(){

        let user = $(this).val();

        $.ajax({
            url: '/staff-table/get-position-by-user/' + user,
            type: 'GET',
            //data: { type: 'appointment' },
            success: function(response){

                $('#structure-{{$id}}').empty();
                $('#positionId-{{$id}}').empty();

                if (response.code == 200)
                {
                    /* generate option for structure */
                    let structure = $('<option></option>')
                        .val(1)
                        .text(response.data[0].structureIdName)
                        .prop('selected', true);

                    /* generate option for position id */
                    let position  = $('<option></option>')
                        .val(response.data[0].positionIdId)
                        .text(response.data[0].posNameIdName)
                        .prop('selected', true);

                    /* append structure and position */
                    structure.appendTo($('#structure-{{$id}}'));
                    position.appendTo($('#positionId-{{$id}}'));
                }

            },
            error: function() {

                throw new Error('Couldn\'t get user structure.');
            }
        });

    })


</script>