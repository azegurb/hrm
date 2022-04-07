@extends('layouts.main_layout',['sidebar'=>'personal_cards'])

@section('title', 'Orxan Abbaslı')

@section('links')
    <link rel="stylesheet" href="{{ asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/ladda/ladda.css') }}">
@endsection

@section('page-title', 'Orxan Abbaslı <small>/ İşə davamiyyət </small>')

@section('content')

    <div class="panel" id="personalCards_WorkAttendance">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <h4>Başlama &mdash; Bitmə tarixi</h4>
                        <div class="input-daterange" data-plugin="datepicker">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon md-calendar" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control date" name="start"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">&mdash;</span>
                                <input type="text" class="form-control" name="end"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Seçim edin</h4>
                    <select class="form-control" data-plugin="select2" data-placeholder="Seçim edin" data-allow-clear="true">
                        <option></option>
                        <option>İşdə olmama halı</option>
                        <option>Ümumi giriş-çıxış</option>
                        <option>Geçikmələr</option>
                        <option>Vaxtından tez getmələr</option>
                    </select>
                </div>
                <div class="col-md-2 pt-30">
                    <div class="float-left">
                        <button type="button" class="btn btn-primary ladda-button" data-style="slide-right" data-plugin="ladda">
                            <span class="ladda-label">Təsdiqlə <i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('core/global/vendor/raty/jquery.raty.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/panel.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/raty.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/uikit/panel-structure.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/select2.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/spin.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/ladda.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/ladda.js')}}"></script>


    <script>
        $(".input-daterange").datepicker({
            orientation: "left bottom",
            format: "dd.mm.yyyy",
            weekStart: 1
    </script>


@endsection