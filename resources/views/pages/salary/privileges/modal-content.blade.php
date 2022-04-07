<div class="panel-bordered">

    <script>$('.dd-content2').hide();</script>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 pull-l">
                <h4 >Struktur: </h4>
                <select id="listStructure" class="form-control select" data-url="{{ route('structures.list') }}" name="input_structure" required="required" {{ !empty($data->data) && $data->data->strName != null ? 'disabled' : ' ' }}>
                    @if( !empty($data->data) && $data->data->strName != null)
                        <option selected>{{$data->data->strName}}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-6 pull-l">
                <h4 >Əməkdaş: </h4>

                <select class="form-control select" id="listUsers" data-url="{{ route('usersByStructure.list') }}" name="user" required="required" {{ !empty($data->data) && $data->data->strName != null ? 'disabled' : ' ' }}>
                    @if( !empty($data->data) && $data->data->userIdId != null)
                        <option value="{{ $data->data->userIdId }}" selected>{{ $data->data->userIdLastName . ' ' . $data->data->userIdFirstName }}</option>
                    @endif
                </select>
                {{--<select id="listUsers" class="form-control select" data-url="{{ route('usersByStructure.list') }}" name="input_user" required="required" {{ !empty($data->data) && $data->data->userIdFirstName != null ? 'disabled' : ' ' }}>--}}
                {{--@if( !empty($data->data) && $data->data->userIdFirstName != null)--}}
                    {{--<option selected>{{$data->data->userIdFirstName}} {{$data->data->userIdLastName}}</option>--}}
                    {{--@endif--}}
                {{--</select>--}}
                {{--<hr class="mt-20">--}}
            </div>
            {{--<div class="col-md-1 pull-l"> </div>--}}
            <div class="col-md-2 pull-l">
                <h4 >Güzəştin başlama tarixi: </h4>
                <input type="text"  data-plugin="datepicker" class="form-control date_id" name="input_date" required="required" value="@if(!empty($data->data) && $data->data !=null){{$data->data->startDate}} @endif">
            </div>
        </div>

        <div class="col-md-12 pull-l">
            <hr class="mt-20">
        </div>

        <div class="col-md-12">

            <div class="col-md-12">


            </div>


            <div class="col-md-12">
                <h4>Güzəşt növünü seçin:</h4>
                @if(!empty($data))
                @foreach($data->forModal as $key=>$single_data)
                    <hr>
                    <div id="side-navs " data-parent="Əmək haqqı">
                        <span class="list-group-item dd-menu2 pt-0 pb-0 privilege-list-menu"><i class="icon md-plus-circle-o" aria-hidden="true"></i>{{$single_data->taxesParagraph}}</span>
                        <div class="ml-20 dd-content2" id="dd-content-{{ $key }}">
                            <table>
                                <tbody>
                                @foreach($single_data->options as $key2=>$single_data2)
                                    @if(!empty($data->data))
                                        @if($data->data->privilegeIdId == $single_data2->id)
                                            <script>
                                                document.getElementById('dd-content-{{ $key }}').style.display = "block";
                                            </script>
                                        @endif
                                    @endif
                                    <tr style="">
                                        <td class="col-lg-6 privilege-list-item"><a class="list-group-item @if(!empty($data->data)){{$data->data->privilegeIdId == $single_data2->id ? 'bg-grey-200' : ' '}}@endif" style=""><label class="privilege-label" for="{{$single_data2->id}}" ><i class="icon md-long-arrow-right" aria-hidden="true"></i>{{$single_data2->name}}</label></a></td>
                                        <td class="col-lg-3">
                                            <div class="radio-custom radio-primary">
                                                <input type="radio" id="{{$single_data2->id}}" required value="{{$single_data2->id}}" name="input_privilege" @if(!empty($data->data)){{$data->data->privilegeIdId == $single_data2->id ? 'checked' : ' '}} @endif >
                                                <label for="{{$single_data2->id}}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
                    @endif
            </div>
        </div>
    </div>
</div>

<script>
    var url = $('#listUsers').data('url');
    $('#listStructure').selectObj('listStructure');


    $('.dd-menu2').click(function(){
        $(this).next('.dd-content2').slideToggle();
    });


    $('#listStructure').on('select2:select',function () {
        var id = $(this).select2('data')[0].id;
        $('#listUsers').attr('data-url', '');
        $('#listUsers').empty();
        $('#listUsers').selectObj('listUsers', false, url + '/' + id);
    });

</script>




<script>
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekStart: 1
    });

    @if(!empty($url))
        modalFormUrl('{{$url}}');
    @else
        modalFormUrl();
    @endif

    //Set Url
    function modalFormUrl(url){
        if(typeof url != 'undefined'){
            $('#privileges-modal_form').attr('action' , url);
            $('#privileges-modal_form').attr('method' , 'PUT');
        }else{
            $('#privileges-modal_form').attr('method' , 'POST');
        }
    };

</script>


<script>
    $('#provision').selectObj('provision');
    $('#listUsers').selectObj('listUsers');
//
//    var url = listPositions.attr('data-url');
//
//    $('#listStructure').on('select2:select', function(){
//        console.log('testestest');
//        listPositions.attr('data-url', '');
//        listPositions.selectObj('positionName', 'position-provisions-modal-store', url + '/' + $(this).val());
//
//    });
//
//    $('#provision').on('select2:unselect', function (event) {
//
//        $(document).find('input[name="relId[' + event.params.data.id +']"]').remove();
//
//    });
//
//    $(document).on('hidden.bs.modal', function () {
//
//        $('select.select').empty('');
//
//    });
//
//    listPositions.on('select2:select', function () {
//
//        var posId = $(this).val();
//
//        $.ajax({
//            type: 'GET',
//            url: '/helper-lists/get-provisions-by-position/' + posId,
//            success: function (response) {
//
//                var select = $('#provision');
//                var option = '';
//
//                if (response.length > 0) {
//
//                    $(document).find('form').append('<input name="_method" type="hidden" value="PUT">');
//                    $(document).find('form').attr('action', '/helper-lists/position-provisions/' + posId);
//
//                    response.forEach(function (item) {
//
//                        option += '<option value="' + item.id + '" selected>' + item.text + '</option>';
//
//                    });
//
//                    select.html(option);
//                    select.trigger('change');
//
//                } else {
//
//                    select.html('');
//
//                }
//
//
//
//            }
//
//        });
//
//    });


</script>
