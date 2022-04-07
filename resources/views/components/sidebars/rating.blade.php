<!-- Contacts Sidebar -->
    <div class="page-aside-switch">
        <i class="icon md-chevron-left" aria-hidden="true"></i>
        <i class="icon md-chevron-right" aria-hidden="true"></i>
    </div>
    <div class="page-aside-inner page-aside-scroll">
        <div data-role="container">
            <div data-role="content">
                <div class="page-aside-section">
                    <div class="page-aside-title btn-group btn-group-flat mb-10 mt-0 px-0`">
                        <div class="input-search input-search-dark index-increase" style="width:320px!important;">
                            <i class="input-search-icon md-search" aria-hidden="true"></i>
                            <input type="search" class="form-control"
                                   onkeyup="searcherBox($(this),$('#employee-area'),'.employee-name')"
                                   id="stateProgramSearch"
                                   autocomplete="off" placeholder="Əməkdaş axtar...">
                        </div>
                    </div>
                    {{--<h5 class="page-aside-title">&nbsp;</h5>--}}
                    <div class="list-group" id="employee-area">
                        {{-- Users List --}}
                        @if(!empty($data) && count($data->data) > 0)
                            @foreach($data->data as $employee)
                                <div class="list-group-item py-0" data-employee="{{$employee->Id}}" style="cursor: pointer;border-bottom:1px solid lightgray">
                                    <div class="list-content">
                                        <span class="list-text" style="display: inline-block;width: 100%">
                                            <div class="row">
                                                <div class="col-md-2">
                                                <a class="avatar mr-10 mt-15" href="javascript:void(0)">
                                                  <img class="img-fluid" src="{{asset('media/noavatar.png')}}" alt="...">
                                                </a>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="pb-0">
                                                    <h4 class="mb-0 employee-name" style="height: 20px;width: 100%!important;">{{!empty($employee->first_name) ? $employee->first_name : ''}} {{!empty($employee->last_name) ? $employee->last_name : ''}}
                                                        <span class="float-right">{{!empty($employee->value) ? $employee->value : ''}}</span>
                                                    </h4>
                                                    <p class="mb-5 mt-10" style="">{{!empty($employee->strName) ? $employee->strName : ''}}</p>
                                                    <p class="mb-0" style="line-height: 30px"><strong>{{!empty($employee->posName) ? $employee->posName : ''}}</strong></p>
                                                </div>
                                            </div>
                                            </div>

                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{----------------}}
                    </div>
                </div>
            </div>
        </div>
    </div>