{{--<div class="panel-bordered">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="col-md-4 pull-l">--}}
                {{--<h4 >Struktur: </h4>--}}
                {{--<select id="listStructure" class="form-control select" data-url="{{ route('structures.list') }}" name="input_structure" required="required" @if($data->data->strName != null)--}}
                {{--disabled--}}
                        {{--@endif>--}}
                    {{--@if($data->data->strName != null)--}}
                        {{--<option value="{{$data->data->strName}}" selected>{{$data->data->strName}}</option>--}}
                    {{--@endif--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="col-md-4 pull-l">--}}
                {{--<h4 >Əməkdaş: </h4>--}}
                {{--<select id="listUsers" class="form-control select" data-url="{{ route('usersByStructure.list') }}" name="input_user" required="required" @if($data->data->userIdFirstName != null)--}}
                {{--disabled--}}
                        {{--@endif>--}}
                    {{--@if($data->data->userIdFirstName != null)--}}
                        {{--<option value="{{$data->data->strName}}" selected>{{$data->data->userIdFirstName}} {{$data->data->userIdLastName}}</option>--}}
                    {{--@endif--}}
                {{--</select>--}}
                {{--<hr class="mt-20">--}}
            {{--</div>--}}
            {{--<div class="col-md-1 pull-l"> </div>--}}
            {{--<div class="col-md-3 pull-l">--}}
                {{--<h4 >Güzəştin başlama tarixi: </h4>--}}
                {{--<input type="text"  data-plugin="datepicker" class="form-control date_id" name="input_date" required="required">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-md-12 pull-l">--}}
            {{--<hr class="mt-20">--}}
        {{--</div>--}}

        {{--<div class="col-md-12">--}}

            {{--<div class="col-md-12">--}}
                {{--<h4>Güzəşt növünü seçin:</h4>--}}

                {{--@foreach($data->forModal as $key=>$single_data)--}}
                    {{--<hr>--}}
                    {{--<div id="side-navs" data-parent="Əmək haqqı">--}}
                        {{--<span class="list-group-item dd-menu2"><i class="icon md-toll" aria-hidden="true"></i>{{$single_data->taxesParagraph}}</span>--}}
                        {{--<div class="ml-20 dd-content2">--}}
                            {{--<table>--}}
                                {{--<tbody>--}}
                                {{--@foreach($single_data->options as $key2=>$single_data2)--}}
                                    {{--<tr>--}}
                                        {{--<td class="col-lg-6"><a class="list-group-item"><label for="{{$single_data2->id}}" ><i class="icon md-long-arrow-right" aria-hidden="true"></i>{{$single_data2->name}}</label></a></td>--}}
                                        {{--<td class="col-lg-3">--}}
                                            {{--<div class="radio-custom radio-primary">--}}
                                                {{--<input type="radio" id="{{$single_data2->id}}" value="{{$single_data2->id}}" name="input_privilege">--}}
                                                {{--<label for="{{$single_data2->id}}"></label>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<script>--}}
    {{--var url = $('#listUsers').data('url');--}}
    {{--$('#listStructure').selectObj('listStructure');--}}
    {{--//    $('#listUsers').selectObj('listUsers');--}}

    {{--$('.dd-content2').hide();--}}
    {{--$('.dd-menu2').click(function(){--}}
        {{--$(this).next('.dd-content2').slideToggle();--}}
    {{--});--}}

    {{--$('#listStructure').on('select2:select',function () {--}}
        {{--var id = $(this).select2('data')[0].id;--}}

        {{--$('#listUsers').selectObj('listUsers', false, url + '/' + id);--}}

    {{--});--}}

{{--</script>--}}

{{--<script>--}}
    {{--$(".date_id").datepicker({--}}
        {{--orientation: "left bottom",--}}
        {{--format: 'dd.mm.yyyy',--}}
        {{--weekStart: 1--}}
    {{--});--}}
{{--</script>--}}