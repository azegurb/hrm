<link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
<link rel="stylesheet" href="{{asset('/css/external_plugins/print.min.css')}}">
<link rel="stylesheet" href="{{asset('cv-template/style.css')}}">
<style>
    .card-shadow{
        border-radius: 3px;
    }
    .material-shadow{
        border-bottom: 1px solid white;
    }
    .material-shadow:hover{
        transition: 200ms;
        -webkit-box-shadow: 9px 9px 18px -3px rgba(179,179,179,1);
        -moz-box-shadow: 9px 9px 18px -3px rgba(179,179,179,1);
        box-shadow: 9px 9px 18px -3px rgba(179,179,179,1);
        margin-bottom: 5px;
        margin-top: 2px;
        cursor: pointer;
    }
    .material-shadow-input:hover, .material-shadow-input.active{
        transition: 200ms;
        -webkit-box-shadow: 4px 5px 13px 0px rgba(186,186,186,1);
        -moz-box-shadow: 4px 5px 13px 0px rgba(186,186,186,1);
        box-shadow: 4px 5px 13px 0px rgba(186,186,186,1);
    }
    .dropdown-divider{
        background-color: #80DEEA;
    }
    .height-45{
        height:45px;
    }
    .select-user{
        border: 1px solid transparent;
    }
    .select-user:hover{
        border-color: grey!important;
        background-color: #f1f1f1!important;
    }
</style>
<div class="container pt-40">
    <div class="container">
        <div class="row">

            <div class="col-md-12 px-0">
                <div class="card card-bordered card-outline-default">
                    <div class="card-block text-center">
                        <div class="col-md-1" style="margin-left: auto;margin-right: auto">
                            @include('pages.chairman.component.emblem')
                        </div>
                        <h4 class="card-title mt-10" style="color: #006064;">-</h4>
                        <h3 class="card-title mt-10" style="color:#006064;">--</h3>
                        <div class="dropdown-divider my-20"></div>
                        <div class="input-group material-shadow-input height-45">
                            <input type="text" onkeyup="userS($(this),event)" class="form-control height-45" id="user-search-input" name="" placeholder="Əməkdaşa görə axtarış">
                            <span class="input-group-btn height-45">
                            <button type="button" expander-button class="btn btn-default waves-effect height-45">Ətraflı axtarış <i class="icon md-chevron-down" aria-hidden="true"></i></button>
                        </span>
                        </div>
                        <div class="text-left" id="complete-search-area" style="display: none">
                            <fieldset style="border: 1px solid #e0e0e0;border-radius:3px" class="p-15">
                                <legend class="px-5 font-black legend-custom" style="width: auto">Ətraflı axtarış:</legend>
                                <div class="container" style="margin-top: -20px">
                                    <div class="row">
                                        <div class="form-group mb-0 ml-5" style="width: 12%">
                                            <input type="text" class="form-control" name="name" placeholder="Adı">
                                        </div>
                                        <div class="form-group mb-0 ml-5" style="width: 15%">
                                            <input type="text" class="form-control" name="last" placeholder="Soyadı">
                                        </div>
                                        <div class="form-group mb-0 ml-5" style="width: 12%">
                                            <input type="text" class="form-control" name="patronymic" placeholder="Ata adı">
                                        </div>
                                        <div class="form-group mb-0 ml-10" style="display: flex;width: 10%">
                                            <select name="gender" id="" class="form-control">
                                                <option value="" disabled selected>Cinsi</option>
                                                <option value="2" >Kişi</option>
                                                <option value="1">Qadın</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-0 ml-10" style="display: flex;width: 10%">
                                            <select name="marital" id="" class="form-control">
                                            </select>
                                        </div>
                                        <div class="input-daterange ml-15" data-plugin="datepicker" style="width: 30%">
                                            <div class="input-group">
                                                <span class="input-group-addon date-range-start">
                                                    <i class="icon md-calendar font-black" aria-hidden="true"></i>
                                                </span>
                                                <input type="text" id="startDate" class="form-control date-range-middle font-black required date-pick-validate" name="startDate" value="{{$valueStart or ''}}">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon font-black date-range-middle">&mdash;</span>
                                                <input type="text" id="endDate" class="form-control date-range-end font-black required date-pick-validate" name="endDate" value="{{$valueEnd or ''}}">
                                            </div>
                                        </div>
                                        <div style="width: 3%" class="ml-10">
                                            <button class="btn btn-primary icon md-search" onclick="filterByUser()" style="padding: 0.6rem"></button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="text-left" id="search-results-area" style="display: none;">
                            <fieldset style="border: 1px solid #e0e0e0;border-radius:3px" class="p-15">
                                <legend class="px-5 font-black legend-custom" style="width: auto">Axtarış nəticələri</legend>
                                <div class="container px-0" style="margin-top: -40px">
                                    <div class="col-md-12 text-right px-0">
                                        <button class="btn btn-pure icon md-close" onclick="clearFilters()"></button>
                                    </div>
                                </div>

                                <div class="container">

                                    <div class="row"  style="max-height: 250px;overflow-y: auto">

                                        <ul class="list-group" search-content style="width: 100%">

                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(!empty($data) && count($data->data) > 0)
                @foreach($data->data as $structure)
                            @include('pages.chairman.component.structure' , ['structure'=>$structure ])
                @endforeach
            @endif
        </div>
    </div>
</div>
<!-- Large modal -->

<div class="modal fade bs-example-modal-xl" tabindex="-1" id="cvModal" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" onclick="$('#cvModal').modal('hide')" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer pt-10 pb-10 mt-5" style="background: #e8e8e8">
                <button type="button" onclick="$('#cvModal').modal('hide')"  class="btn text-black btn-default">Bağla</button>
            </div>
        </div>
    </div>
</div>
<script>
    var usersUrl = '{{ route('users','select') }}';
    var filterByUserUrl = '{{route('users.crud')}}';
    var familyStatus = '{{url('/users/family-statusid-name')}}';
    var userCV = '{{url('/chairman/users/cv/')}}';
    var structureU = '{{url('/chairman/structure/')}}';
    setTimeout(function(){
        $.getScript("{{asset('/core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}");
        $.getScript("{{asset('/core/global/js/Plugin/bootstrap-datepicker.js')}}");
        $.getScript("{{asset('/core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.az.min.js')}}");
    },1100)
</script>
<script defer src="{{asset('js/custom/plugins/external_plugins/print.min.js')}}"></script>
<script src="{{asset('js/custom/pages/chairman/main.js')}}"></script>
<script defer type="text/javascript" src="{{asset('/js/custom/plugins/external_plugins/FileSaver.min.js')}}"></script>