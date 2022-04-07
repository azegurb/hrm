{{--<div   class="float-left col-md-6 pl-0">--}}
    {{--<h4 style="font-size: 15px">Günlər üzrə axtarış</h4>--}}
    {{--<div class="input-datepicker input-daterange" data-plugin="datepicker">--}}
        {{--<div class="input-group ">--}}
                                    {{--<span class="input-group-addon">--}}
                                    {{--<i class="icon md-calendar" aria-hidden="true"></i>--}}
                                    {{--</span>--}}
            {{--<input type="text" class="input-datepicker form-control" name="start"/>--}}
        {{--</div>--}}
        {{--<div class="input-group ">--}}
            {{--<span class="input-group-addon">-</span>--}}
            {{--<input type="text" class=" input-datepicker form-control" name="end"/>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-30">
            <form id="shiftChanger">
                <div class="col-md-6 float-left">
                    <h4 style="font-size: 15px;">Növbə</h4>
                    <div class="input-group">
                        <input type="hidden" name="id" value="{{$userShiftId->reluserid}}">
                        <select class="form-control select" id="getShift" data-url="{{route('shift.get')}}" name="shift">

                        </select>
                    </div>
                    <div class="col-md-12 mt-20 periodic-shift-selector" style="display: none">
                        <div class="col-md-6 pl-0 float-left">
                            <h4>İş günü</h4>
                            <div class="workDay">

                            </div>
                        </div>
                        <div class="col-md-6 pr-0 float-left">
                            <h4>Istirahət günü</h4>
                            <div class="restDay">

                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-left mt-30"> Təsdiq </button>
            </form>
        </div>
    </div>
</div>
<table  class="table table-hover dataTable w-full">
    <thead >
        <tr>
            <th>№</th>
            <th>Həftənin günü:</th>
            <th>İşin başlama vaxtı:</th>
            <th>İşin bitmə vaxtı:</th>
        </tr>
    </thead>
    <tbody align="center">
    @if($data->totalCount != '')
        @foreach($data->data as $key => $value)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$value->weekDay}}</td>
                <td>{{$value->startTime}}</td>
                <td>{{$value->endTime}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="alert alert-danger">Məlumat Yoxdur</td>
        </tr>
    @endif
    </tbody>
</table>
<script src="{{asset('js/custom/pages/work-graphics/shift-connector.js')}}"></script>
<script>$('#getShift').selectObj('getShift',false);</script>
<script>
    var select = $('select#getShift');
    var option = '<option value="{{$userShiftId->id}}" selected>{{$userShiftId->name}}</option>';
    select.append(option);
    shiftData = {
        'periodic' : "{{$userShiftId->periodic}}",
        'workDay'  : "{{$userShiftId->workDay}}",
        'restDay'  : "{{$userShiftId->restDay}}",
        'checkrestDay'  : {{$userShiftId->checkrestDay}},
        'checkworkDay'  : {{$userShiftId->checkworkDay}},
    };
    select.trigger('change');
</script>
