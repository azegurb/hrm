<div class="col-md-6 pull-l">
    <h4 >Xüsusi rütbənin növü: </h4>

    <select class="form-control select" id="ListSpecialRankType" data-url="{{route('ranks.specialRankTypes')}}" name="listspecialranktype" required="required">
        @if(!empty($response->fields) && !empty($response->fields->listspecialranktype))
            <option value="{{$response->fields->listspecialranktype->id}}">{{$response->fields->listspecialranktype->text}}</option>
        @endif
    </select>
</div>
<div class="col-md-6 pull-r">
    <h4 >Xüsusi rütbə: </h4>
    <select class="form-control select" id="ListSpecialRank" data-url="{{route('ranks.specialRanks')}}" name="listspecialrank" required="required">
        @if(!empty($response->fields) && !empty($response->fields->listspecialrank))
            <option value="{{$response->fields->listspecialrank->id}}">{{$response->fields->listspecialrank->text}}</option>
        @endif
    </select>
</div>
<div class="col-md-4 pull-l m-t-20">
    <h4 >Verilmə tarixi: </h4>
    <input type="text"  data-plugin="datepicker" class="form-control date_id" name="input_given_date" value="{{!empty($response->fields) && !empty($response->fields->input_given_date) ? $response->fields->input_given_date : '' }}" required="required">
</div>
<div class="col-md-4 pull-l m-t-20">
    <h4>Sənədin nömrəsi: </h4>
    <input type="text" id="qualification-passport-number" class="form-control" name="input_docinfo" value="{{!empty($response->fields) && !empty($response->fields->input_docinfo) ? $response->fields->input_docinfo : '' }}" required="required">
</div>
<div class="col-md-4 pull-l m-t-20">
    <h4 >Sənədin tarixi: </h4>
    <input type="text" id="qualification-degree-end-date" class="form-control date_id" data-plugin="datepicker" name="input_doc_date" value="{{!empty($response->fields) && !empty($response->fields->input_doc_date) ? $response->fields->input_doc_date : '' }}" required="required">
</div>

<script>
    $(".date_id").datepicker({
        orientation: "left bottom",
        format: 'dd.mm.yyyy',
        weekstart: 1
    });
</script>

<script src="{{asset('js/custom/plugins/select-by-select.js')}}"></script>

<script>
    function modalFormUrl(url){
        console.log(url);
        if(typeof url != 'undefined'){
            $('#military_form').attr('action' , url);
            $('#military_form').attr('method' , 'PUT');
        }else{
            $('#military_form').attr('method' , 'POST');
        }
    };
    //Set Url
    var url = $('#ListSpecialRank').data('url');
    $('#ListSpecialRankType').selectObj('ListSpecialRankType');
    $('#ListSpecialRankType').on('select2:select',function () {
        var id = $(this).select2('data')[0].id;

        $('#ListSpecialRank').selectObj('ListSpecialRank', false, url + '/' + id);
    });
    @if(!empty($response->fields))
        console.log('here')
        $('#ListSpecialRank').selectObj('ListSpecialRank', false, url + '/{{$response->fields->listspecialranktype->id}}');
        modalFormUrl('{{route('user-rank.update' , $response->id)}}');
    @else
        modalFormUrl();
    @endif
</script>