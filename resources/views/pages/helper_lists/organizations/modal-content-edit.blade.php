<div class="col-lg-12 float-left">
    <h4>Şirkət adı:</h4>
    <input type="text" class="form-control" id="orgName" value="@if(isset($data)){{$data->orgData['name']}}@endif" name="input_organization" required="required">
</div>

<div class="col-lg-12 float-left">
    <hr>
    <button type="button" id="addButton" onclick="addInput()" class="btn btn-floating btn-info btn-sm waves-effect waves-float waves-light"><i class="icon md-plus" style="top:-2px;" aria-hidden="true"></i></button><span class="ml-10" style="top: 55px">Struktur əlavə et</span>
</div>
<div class="col-lg-12 float-left" id="mainDiv">

    <div id="headerInput" class="col-lg-12 float-left mt-0" style="display: @if(isset($data) && $data->totalCount > 0) {{'block'}} @else {{'none'}} @endif ;">
        <div class="col-lg-1 float-left"></div>

        <div class="col-lg-9 float-left">
            <h4>Struktur adı:</h4>
        </div>

        <div class="col-lg-1 float-left"></div>
    </div>

    @if(isset($data) && $data->totalCount > 0)
        @php($num = 1)
        @foreach($data->data as $key=>$value)
            {{--{{dump($value)}}--}}
            <div class="col-lg-12 float-left mt-10" id="inputOrgDiv_{{$num}}">
            <div class="col-lg-1 float-left">
            </div>

            <div class="col-lg-9 float-left">
            <input type="text" class="form-control" id="inputOrg_{{$num}}" name="{{$value->structuresNameIdId}}" value="{{$value->structuresNameIdName}}" required="required">
            </div>

            <div class="col-lg-1 float-left">
            <button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light" onclick="$('#inputOrgDiv_{{$num}}').remove()" style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>
            </div>
            </div>
            @php($num = $num +1)
        @endforeach
    @endif


</div>

<script>
    function addInput(){

        document.getElementById("headerInput").style.display="block";

        addNewRow();

    };


    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }
    let id = 0;
    var addNewRow = function() {

//        let id = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();

        ++id;


        $('#mainDiv').append(  '<div class="col-lg-12 float-left mt-10" id="addWork-'+ id +'">' +
            '<div class="col-lg-1 float-left"></div>' +
            '<div class="col-lg-9 float-left" id="dismissal-note-' + id + '">' +
            '<input type="text" class="form-control" name="input_structure[]" required="required">' +
                {{--'<select id="structureId-'+ id +'" class="form-control select" data-url="{{ route('structures.list') }}" required>' +--}}
                {{--'<option></option>' +--}}
                {{--'</select>' +--}}
            //                                       '<button type="button" class="close" onclick="$(\'#addWork-' + id + '\').remove()"><span aria-hidden="true">&times;</span></button>' +
            '</div>' +
            '<div class="col-lg-1 float-left">' +
            '<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light" style="top:-3px;" onclick="$(\'#addWork-' + id + '\').remove()"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>' +
            '</div>' +
            '</div>');
    }



</script>