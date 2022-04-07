<div class="row modal-scroll">
    <div class="col-md-12">
        @php($data)
        <div class="row">

            @if($data != null)
                @if($data->fields['orderTypeLabel'] == 'appointment' ||
                    $data->fields['orderTypeLabel'] == 'dismissal' ||
                    $data->fields['orderTypeLabel'] == 'vacation' ||
                    $data->fields['orderTypeLabel'] == 'financialAid' ||
                    $data->fields['orderTypeLabel'] == 'nonWorkingDaysSelection' ||
                    $data->fields['orderTypeLabel'] == 'discipline' ||
                    $data->fields['orderTypeLabel'] == 'salaryAddition' ||
                    $data->fields['orderTypeLabel'] == 'orderTransfer' ||
                    $data->fields['orderTypeLabel'] == 'additionalWorkTime' ||
                    $data->fields['orderTypeLabel'] == 'Reward' ||
                    $data->fields['orderTypeLabel'] == 'warning' ||
                    $data->fields['orderTypeLabel'] == 'vacationRecall' ||

                    $data->fields['orderTypeLabel'] == 'salaryDeduction' ||

                     $data->fields['orderTypeLabel'] == 'staffOpening' ||
                    $data->fields['orderTypeLabel'] == 'staffCancellation' ||

                    $data->fields['orderTypeLabel'] == 'damage')

                    <div class="col-md-12">

                        @if(isset($data->vacation->orderVacationDetailAddArray))
                        <button class="btn btn-primary float-right" type="button"
                                onclick="showAFile('{{json_encode($data)}}')">
                            <i class="icon md-eye" aria-hidden="true"></i> / <i class="icon md-print"
                                                                                aria-hidden="true"></i>
                        </button>

                            @else
                            <button class="btn btn-primary float-right" type="button"
                                    onclick="showAFile('{{json_encode($data->fields)}}')">
                                <i class="icon md-eye" aria-hidden="true"></i> / <i class="icon md-print"
                                                                                    aria-hidden="true"></i>
                            </button>
                        @endif
                    </div>

                @endif
            @endif
            <div class="col-md-5">
                <h4>Əmrin tipi:</h4>
                <select class="form-control" id="listOrderTypes" name="listOrderTypeId"
                        data-url="{{ route('order-types.list') }}" required>
                    @if($data!=null)
                        <option value="{{ $data->fields['listOrderTypes']['id'] }}"
                                selected>{{ $data->fields['listOrderTypes']['text'] }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <h4>Əmrin nömrəsi:</h4>
                <input type="text" class="form-control" name="orderNumber" id="orderNumber"
                       value="@if($data!=null){{ $data->fields['orderNumber'] }}@endif" required>
            </div>
            <div class="col-md-2">
                <h4>Əmrin tarixi:</h4>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="icon md-calendar" aria-hidden="true"></i>
                    </span>
                    <input style="font-size: 15px;" type="text" class="order-related-date form-control" name="orderDate"
                           data-plugin="datepicker" id="orderDate"
                           value="@if($data!=null){{ date('d.m.Y', strtotime($data->fields['orderDate'])) }}@endif"
                           required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-10" style="position: relative;">
                <h4>Əmrin əsası:</h4>
                <textarea name="orderBasis" id="orderBasis" cols="30" rows="3" class="form-control"
                          required>@if($data!=null){{$data->fields['orderBasis']}}@endif</textarea>
            </div>
        </div>
    </div>
</div>
<!-- Add button-->
<div class="row" id="btnCloneForm" style="display: none;">
    <div class="col-md-12 mt-20" data-animate="fade" data-child="button" data-selectable="selectable">
        <button class="btn btn-sm btn-floating btn-info waves-effect" id="append-new-row" type="button">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
</div>
<!-- /Add button-->

<div id="appendArea">

    <?php
//dd($data);

    ?>
    @if($data != null && $data->fields['orderTypeLabel']!='vacation' && !isset($data->fields[$data->fields['orderTypeLabel']]['ordersalaryaddition']))

        @foreach($data->fields[$data->fields['orderTypeLabel']] as $array)

            @include('pages.orders.component.order-type-panel-body.'.$data->fields['orderTypeLabel'], ['array' => (object)$array, 'objwhole'=>(object)$data])
        @endforeach

        @elseif($data != null && isset($data->fields[$data->fields['orderTypeLabel']]['ordersalaryaddition']))
        <?php $array=$data->fields[$data->fields['orderTypeLabel']]['ordersalaryaddition'];?>
            @include('pages.orders.component.order-type-panel-body.'.$data->fields['orderTypeLabel'], ['array' => (object)$array, 'objwhole'=>(object)$data])


        @elseif($data != null && $data->fields['orderTypeLabel']=='vacation')

            @if(isset($data->label) && ($data->label=='sabbatical_leave' || $data->label=='paid_educational_vacation' || $data->label=='nonpaid_vacation' || $data->label=='nonpaid_educational_vacation'))

                @include('pages.orders.component.order-type-panel-body.sabbatical_leave_edit', ['objwhole'=>(object)$data])

            @else

                @foreach($data->fields[$data->fields['orderTypeLabel']] as $array)

                    @include('pages.orders.component.order-type-panel-body.'.$data->fields['orderTypeLabel'].'_edit', ['array' => (object)$array, 'objwhole'=>(object)$data])

                @endforeach

            @endif

    @endif
</div>
@if($data != null)

    <script>

        $('#ordersModal').find('form').attr('action', '{{ route('orders.update', $data->id) }}').attr('method', 'PUT');

    </script>

@else

    <script>

        $('#ordersModal').find('form').attr('action', '{{ route('orders.store') }}').attr('method', 'POST');

    </script>

@endif

<script>
    $('#listOrderTypes').selectObj('listOrderTypes', 'ordersModal');
    /*
     *
     * Page date picker
     * */
    $(".order-related-date").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        autoclose: true,
        weekStart: 1
    });

</script>

<script src="{{ asset('js/custom/pages/orders/modal-controllers/select-parser.js')}}"></script>
<script src="{{ asset('js/custom/pages/orders/modal-controllers/append-more.js')}}"></script>
<script src="{{ asset('js/custom/pages/work-experience/getFile.js')}}"></script>
<script src="{{ asset('js/custom/pages/orders/modal-controllers/remove-self.js')}}"></script>
