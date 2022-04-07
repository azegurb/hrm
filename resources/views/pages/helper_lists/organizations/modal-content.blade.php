<div class="col-lg-12 float-left">
    <h4>Şirkət adı:</h4>
    <input type="text" class="form-control" id="orgName" value="@if(isset($data)){{$data->orgData['name']}}@endif" name="input_organization" required="required">
</div>

<div class="col-lg-12 float-left">
    <hr>
    {{--<button type="button" id="addButton" onclick="addInput()" class="btn btn-floating btn-info btn-sm waves-effect waves-float waves-light"><i class="icon md-plus" style="top:-2px;" aria-hidden="true"></i></button><span class="ml-10" style="top: 55px">Struktur əlavə et</span>--}}
</div>
<div class="col-lg-12 float-left" id="mainDiv">

    <div id="headerInput" class="col-lg-12 float-left mt-0" style="display: @if(isset($data) && $data->totalCount > 0) {{'block'}} @else {{'none'}} @endif ;">
        <div class="col-lg-1 float-left"></div>

        <div class="col-lg-9 float-left">
            <h4>Yeni struktur əlavə et:</h4>
        </div>

        <div class="col-lg-1 float-left"></div>
    </div>

    <div class="col-lg-12 float-left mt-10 setir" id="inputOrgDiv">
        <div class="col-lg-1 float-left">
        </div>

        <div class="col-lg-9 float-left">
            <input type="hidden" id="orgId" class="form-control"name="input_org_id" value="@if(isset($data)){{$data->orgData['id']}}@endif" required="required">
            <input type="text" id="newStrInput" class="form-control"name="input_structure" >
        </div>

        <div class="col-lg-1 float-left">
            <button type="button" class="btn btn-floating btn-success btn-sm waves-effect waves-float waves-light removeData"  onclick="addStr();" style="top:-3px;"><i class="icon md-plus" style="top:-2px;" aria-hidden="true"></i></button>
        </div>
    </div>

    <div id="headerInput" class="col-lg-12 float-left mt-0" style="display: @if(isset($data) && $data->totalCount > 0) {{'block'}} @else {{'none'}} @endif ;">
        <div class="col-lg-1 float-left"></div>

        <div class="col-lg-9 float-left">
            <h4>Strukturlar:</h4>
        </div>

        <div class="col-lg-1 float-left"></div>
    </div>

    @if(isset($data) && $data->totalCount > 0)
        @php($num = 1)
        @foreach($data->data as $key=>$value)
            {{--{{dump($value)}}--}}
            <div class="col-lg-12 float-left mt-10 setir" id="inputOrgDiv_{{$num}}">
                <div class="col-lg-1 float-left">
                </div>

                <div class="col-lg-9 float-left">

                    <input type="text" class="form-control"name="input_structure[]" value="{{$value->structuresNameIdName}}" required="required" disabled="disabled">
                </div>

                <div class="col-lg-1 float-left">
                    <button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light removeData"  onclick='deleteStr({{$value->id}},"inputOrgDiv_{{$num}}")' style="top:-3px;"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>
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

    //$('body').on('click', '.removeData', function(){
    //
    //    $(this).parent().parent().remove();
    //
    //});

    function deleteStr(id,divId) {
        console.log(id,divId);

        $.ajax({
            url: '/helper-lists/organizationstructures/' + id,
            type: 'DELETE',
            success: function(response) {
                console.log(response);
                if(response == 200){
                    swal('Uğurlu','Struktur Silindi','success');


                    $("#"+divId).remove();

                }else{
                    swal('Silinmədi','Bu struktur istifadə edilir.','error')
                }


            },
            error: function(error){

                console.log('aaaaaa');
            }
        });

    }

    function addStr() {
        var text  = $("#newStrInput").val();
        var orgId = $("#orgId").val();

        $.ajax({
            url: '/helper-lists/organizationstructures',
            type: 'POST',
            data: {input_structure: text,input_organization:orgId},
            success: function(response) {
                console.log(response.data);
                if(response.code == 201){
                    swal('Yeni struktur əlavə edildi.','','success');

                    //Add row
                    addNewRow2(response.data.body.structuresNameId.id,response.data.body.structuresNameId.name);


                }

                $('#newStrInput').val('');
            },
            error: function(error){

                console.log('error yarandi');
            }
        });


    }

    let id = 0;

    var addNewRow = function() {

        ++id;


        $('#mainDiv').append(  '<div class="col-lg-12 float-left mt-10" id="addWork-'+ id +'">' +
            '<div class="col-lg-1 float-left"></div>' +
            '<div class="col-lg-9 float-left" id="dismissal-note-' + id + '">' +
            '<input type="text" class="form-control" id="inp-'+ id +'" name="input_structure[]" required="required" value="">' +
            '</div>' +
            '<div class="col-lg-1 float-left">' +
            '<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light" style="top:-3px;" onclick="$(\'#addWork-' + id + '\').remove()"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>' +
            '</div>' +
            '</div>');
    }

    var addNewRow2 = function(strId,strName) {
console.log(strId,strName);
        let randId = Math.floor((Math.random() * 1000000000) + 1);

        divId = "addWork-" +randId;
        $('#mainDiv').append(  '<div class="col-lg-12 float-left mt-10" id="'+ divId +'">' +
            '<div class="col-lg-1 float-left"></div>' +
            '<div class="col-lg-9 float-left" id="dismissal-note-' + randId + '">' +
            '<input type="text" class="form-control" id="inp-'+ randId +'" name="input_structure[]" required="required" disabled="disabled" value="'+ strName +'">' +
            '</div>' +
            '<div class="col-lg-1 float-left">' +
            '<button type="button" class="btn btn-floating btn-danger btn-sm waves-effect waves-float waves-light" style="top:-3px;" onclick="deleteStr('+strId+',\''+divId+'\')"><i class="icon md-close" style="top:-2px;" aria-hidden="true"></i></button>' +
            '</div>' +
            '</div>');
    }




</script>