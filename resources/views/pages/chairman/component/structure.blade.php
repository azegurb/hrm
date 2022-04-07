<div class="col-lg-4 pl-0">
    <div class="card card-shadow">
        <div class="card-header bg-blue-600 white p-5 clearfix">
            <div class="font-size-18 text-center">{{$structure->name}}</div>
        </div>
        @foreach($structure->childs as $child)
            <div class="material-shadow">
                <div class="card-header bg-light-blue-500 white p-5 clearfix" onclick="getStructureData($(this),'{{$child->id}}','{{$child->strOrTypeLabel}}')" dirty="" expanded="">
                    <div class="font-size-18">{{$child->name}}</div>
                </div>
                <ul class="list-group list-group-bordered mb-0 list-of-this" style="display: none;background-color: #f1f4f5">

                </ul>
            </div>
        @endforeach

    </div>
</div>