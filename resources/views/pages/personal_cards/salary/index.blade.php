@extends('layouts.main_layout',['sidebar'=>'personal_cards'])
@section('title', 'Orxan Abbaslı')
@section('page-title', '<small>Maaş</small>')
@section('links')
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/clockpicker/clockpicker.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/ascolorpicker/asColorPicker.css')}}">
@endsection
@section('content')

    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body">
            <div class="container-fluid pl-20">
                <div class="col-md-6 float-left ">
                    <h4 >Başlama &mdash; Bitmə tarixi</h4>
                    <div class="input-daterange" data-plugin="datepicker">
                        <div class="input-group">
                                    <span class="input-group-addon">
                                       <i class="icon md-calendar" aria-hidden="true"></i>
                                    </span>
                            <input type="text" class="input-datepicker form-control date" name="start" required="required"/>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">&mdash;</span>
                            <input type="text" class=" input-datepicker form-control" name="end" required="required"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 float-right example ">
                    <div  class="modal-footer  ">
                        <button type="button"  class="btn btn-primary" data-dismiss="modal">Təsdiqlə</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Tabs--}}
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-heading panel-heading-tab">
            <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#salarytab1" aria-controls="salary-panelTab1" role="tab" aria-expanded="true">
                        Əmək haqqı
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#salarytab2" aria-controls="salary-panelTab2" role="tab" aria-expanded="true">
                        Ödəniş və tutulmalar
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body pt-20 pb-0">
            <div class="tab-content">
                <div class="tab-pane active" id="salarytab1" role="tabpanel">
                    <table class="table w-full">
                        <tr>
                            <th class="table-width-3">№</th>
                            <th></th>

                            <th class="table-width-8"></th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>test</td>
                                <td class="text-nowrap text-right"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="site-action">
                        <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{--route()--}}', 'salary-modal')" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="tab-pane" id="salarytab2" role="tabpanel">
                    <table class="table w-full">
                        <tr>
                            <th class="table-width-5">№</th>
                            <th>Adı</th>
                            <th class="table-width-8"></th>
                        </tr>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>test</td>
                            <td class="text-nowrap text-right"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="site-action">
                        <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{--route()--}}', 'salary-modal')" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js ')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/ascolorpicker.js')}}"></script>
    <script src="{{asset('core/global/vendor/datepair/datepair.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/datepair/jquery.datepair.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/datepair.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/jt-timepicker.js')}}"></script>
    <script src="{{asset('core/global/vendor/clockpicker/bootstrap-clockpicker.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/clockpicker.js')}}"></script>
    <script>
       $(".input-datepicker").datepicker({
           orientation: "left bottom"
       });
   </script>

@endsection