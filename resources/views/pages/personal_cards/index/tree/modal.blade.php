<!-- Modal -->
@include('components.modal-header' , ['id' => 'treeModal','mdlTitle' => 'Struktur haqqında məlumatın daxil / redaktə edilməsi ekranı', 'mdUrl' => route('structures.store') , 'custom' => 'postForm($(this) , "updateTree")'])

<div class="col-lg-6  pull-l m-t-20 float-left" >
    <h4 >Üst struktur:</h4>
    <span id="structuresGet-span">
        <select class="form-control select" id="structuresGet" data-url="{{route('structures.list')}}" name="structures"></select>
    </span>
</div>
<div class="col-lg-6  pull-l m-t-20 float-left" >

    <h4 >Struktur tipi:</h4>
    <span id="structuresType-span">
        <select class="form-control select" id="structuresType" data-url="{{route('structures.type')}}" name="structurestype" required></select>
    </span>
</div>
<div class="col-lg-6  pull-l m-t-20 float-left">
    <h4 >Struktur adı:</h4>
    <input type="text" class="form-control" id="structureName" name="name" required="required">
</div>
@include('components.modal-footer')
<!-- End Modal -->
