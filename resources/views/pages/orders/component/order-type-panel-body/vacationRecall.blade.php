<input type="hidden" name="orderTypeLabel" value="vacationRecall">
<div class="row">

    <div class="col-md-4">
        <h4>Əməkdaş:</h4>

        <select name="userId" id="userId" class="userId form-control select" data-url="{{ route('users','select') }}" required>
            <option value="@if(isset($data->fields['vacationRecall']['main'][0]) && isset($data->fields['vacationRecall']['main'][0])){{$data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->orderVacationId->userId->id}}@endif" selected>@if(isset($data->fields['vacationRecall']['main'][0]) && isset($data->fields['vacationRecall']['main'][0])){{$data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->orderVacationId->userId->firstName}} {{$data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->orderVacationId->userId->lastName}}@endif</option>
        </select>
    </div>

    <div class="col-md-4">
        <h4>Struktur: </h4>
        <input type="text" name="" id="structureName" readonly value="@if(isset($data->fields['vacationRecall']) && isset($data->fields['vacationRecall']['main'][0]) && isset($data->fields['vacationRecall']['main'][0]['OrderVacationReturn'])) {{$data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->orderVacationId->positionId->structureId->name}}@endif" class="form-control">
    </div>


    <div class="col-md-4">
        <h4>Vəzifə: </h4>
        <input type="text" name="" id="positionName" readonly value="@if(isset($data->fields['vacationRecall']) && isset($data->fields['vacationRecall']['main'][0]) && isset($data->fields['vacationRecall']['main'][0]['OrderVacationReturn'])) {{$data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->orderVacationId->positionId->posNameId->name}}@endif" class="form-control">
    </div>

</div>

<div class="row">

    <div class="col-md-4">
        <h4>Geri çağrılma tarixi:</h4>
        <div>
            <input type="text" class="col-md-12 form-control" name="recallDate" id="recallDate" value="@if(isset($data->fields['vacationRecall']['main'][0])) {{date('d.m.Y', strtotime($data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->returnDate))}} @endif">
        </div>
    </div>

    <div class="col-md-4">
        <h4>Geri çağırılma tipi:</h4>
        <div>

            <select name="returnType" class="form-control" id="returnType" data-url="/orders/vacation-return-types/">

                @if(isset($data))
                    @foreach($data->fields['vacationRecall']['main'][2]['listReturnTypes']->data as $list)
                       @if(isset($data->fields['vacationRecall']['main'][0]) && $data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->listReturnTypeIdId==$list->id)

                           <option value="{{$list->id}}" selected>{{$list->name}}</option>

                        @else

                            <option value="{{$list->id}}">{{$list->name}}</option>
                        @endif

                    @endforeach

                @endif


            </select>

        </div>
    </div>

    <div class="col-md-4 replaceDate">

        @if(isset($data) && $data->fields['vacationRecall']['main'][0]['OrderVacationReturn']->data[0]->listReturnTypeIdLabel=='replacement')
            <h4>Məzuniyyətə buraxıldığı tarixləri:</h4><div class="input-daterange" data-plugin="datepicker">
                <div class="input-group">
                  <span class="input-group-addon">
                      <i class="icon md-calendar" aria-hidden="true"></i>
                  </span>
                    <input type="text" class="form-control"  id="startDate"  name="startDate" value="@if(isset($data->fields['vacationRecall']['main'][1]) && $data->fields['vacationRecall']['main'][1]['OrderVacationReplacement']->data[0]) {{date('d.m.Y', strtotime($data->fields['vacationRecall']['main'][1]['OrderVacationReplacement']->data[0]->startDate))}} @endif" required/>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control"  id="endDate" name="endDate" value="@if(isset($data->fields['vacationRecall']['main'][1]) && $data->fields['vacationRecall']['main'][1]['OrderVacationReplacement']->data[0]) {{date('d.m.Y', strtotime($data->fields['vacationRecall']['main'][1]['OrderVacationReplacement']->data[0]->endDate))}} @endif" required/>
                </div>
            </div>

        @endif

    </div>

</div>
<script>
    $('#userId').selectObj('userId', 'ordersModal');

    $('#returnType').selectObj('returnType', 'ordersModal');

    $('#returnType').on('select2:select', function () {

        var str='';

        if($(this).val()=='1'){

            str='<h4>Məzuniyyətə buraxıldığı tarixləri:</h4><div class="input-daterange" data-plugin="datepicker"><div class="input-group">';
            str=str+'<span class="input-group-addon"><i class="icon md-calendar" aria-hidden="true"></i></span><input type="text" class="form-control"  id="startDate"  name="startDate" value="" required/>';
            str=str+'</div><div class="input-group"><span class="input-group-addon">-</span><input type="text" class="form-control"  id="endDate" name="endDate" value="" required/></div></div>';

        }
        else {

            str='';
        }

        $('.replaceDate').html(str);


        $('#startDate').datepicker({

        }).on('show', function (ev) {
            if($('#recallDate').val()==''){
                ev.stopPropagation();
                swal('Diqqət!', 'Geri çağırılma tarixini seçməlisiz əvvəlcə!', 'info');
                $('#startDate').datepicker('hide');
                return false;
            }

        }).on('changeDate', function (ev) {
           if($('#recallDate').html()!=''){

               swal('Diqqət!', 'Geri çağırılma tarixini seçməlisiz əvvəlcə!', 'info');
               $('#startDate').datepicker({
                   format: 'dd.mm.yyyy',
                   autoclose: true,
                   orientation: 'top',
                   weekstart: 1
               });

           }
           else {

               var diffDays='0';

               $.ajax({
                   method: 'GET',
                   url: '/orders/vacation-check-by-user/'+$('#userId').val()+'/'+$('#recallDate').val(),

                   success: function (response) {

                       if(response.notselected){

                           swal('Diqqət!', response.notselected, 'info');

                       }
                       else {

                           console.log(response)

                           $.ajax({
                               method: 'GET',
                               url: '/orders/calculatevacationday-for-recall/' + response.diffDays + '/' + $('#startDate').val()+'/'+$('#userId').val(),
                               success: function (response) {

                                   if(response.notselected){

                                       swal('Diqqət!', response.notselected, 'info');

                                   }
                                   else {

                                       $('#endDate').val(response.data);
                                   }

                               },
                               error: function (err) {

                                   throw new Error('Error getting vacation days: ' + err);

                               }
                           });

                       }

                   },
                   error: function (err) {

                       throw new Error('Error getting vacation days: ' + err);

                   }
               });


           }

        })
        $('#endDate').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            orientation: 'top',
            weekstart: 1
        });
    });

    $('#userId').on('select2:select', function () {

        // Define variables
        var userId =  $(this).val();
        var url    =  'orders/get-position-by-userId/' + userId;
        // Send AJAX request
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                console.log(response.id);
                write(response.positionId.posNameId.name,response.id,response.positionId.structureId.name);
                $('#userPosition1').val(response.id)
            },
            error: function(error){
                console.log('error yarandi');
            }
        });

        $.ajax({
            url: 'orders/check-vacation/'+userId,
            type: 'GET',
            success: function(response) {

            },
            error: function(error){
                console.log('error yarandi');
            }
        });


        function write(posName,posId,strName){
            var posName = posName;
            var posId   = posId;
            var strName = strName;

            $('#structureName').val(strName);
            $('#positionName').val(posName);
//            $('#userPosition1').val(posId);

        }



//        let url = $('#positionId').data('url') + '/' +  $(this).val();

        $('#positionId').selectObj('positionId' ,false, url);

    });


    $('#recallDate').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        orientation: 'top',
        weekstart: 1
    });
</script>