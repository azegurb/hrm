<input type="hidden" name="orderTypeLabel" value="nonWorkingDaysSelection">
<div class="mt-20" id="nonWorkingDaysSelection" style="border-top:1px solid #efefef;">
    <div class="row">
        <div class="col-4">
            @if(isset($array))
                <input type="hidden" name="orderRestDayId" value="{{ $array->orderRestDayId }}">
                <input type="hidden" name="dayOffId" value="{{ $array->dayOffId }}">
            @endif
            <div class="form-group">
                <h4>Başlama və bitiş tarixi:</h4>
                <div class="input-daterange" data-plugin="datepicker">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="icon md-calendar" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="input_startDate" value="@if(isset($array->startDate)){{$array->startDate}}@endif" required/>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">-</span>
                        <input type="text" class="form-control" name="input_endDate" value="@if(isset($array->endDate)){{$array->endDate}}@endif" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <h4>Adı:</h4>
            <input type="text" class="form-control" name="input_name" id="input_name" value="@if(isset($array->name)){{$array->name}}@endif" required>

        </div>
        {{--<div class="col-12">--}}
            {{--<h4>Qeyd: </h4>--}}
            {{--<textarea name="input_note" id="note" cols="30" rows="3"  value="@if(isset($array->note)) {{$array->note}} @endif"class="form-control">@if(isset($array->note)) {{$array->note}} @endif</textarea>--}}
        {{--</div>--}}
    </div>
</div>

<script>
    $('[data-plugin="datepicker"]').datepicker({
        orientation: "top",
        format: 'dd.mm.yyyy',
        autoclose: true,
        weekStart: 1
    });
</script>