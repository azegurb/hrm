@extends('layouts.main_layout',['sidebar'=>''])

@section('title', !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı')

@section('links')
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/uikit/buttons.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/ladda/ladda.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/pickdate/default.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/pickdate/default.date.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/pickdate/default.time.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/c3/c3.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <style>
        .data-user:hover {
            cursor: pointer;
        }

        .btn-close, .close-finished {
            border-color: #f44336;
            color: #f44336;
            background-color: #ffffff;
        }

        .btn-close:hover, .close-in-progress {
            border-color: #ffffff;
            color: #ffffff;
            background-color: #f44336;
            cursor: pointer;
        }
    </style>

    <script>var route = "{{route('accounting.index')}}"; var hasId = false;</script>
@endsection

@section('content')

    <div class="panel">

        <div class="panel-body container-fluid">

            <div class="row row-lg">

                <div class="col-xl-12">
                    <!-- Example Tabs -->
                    <div class="example-wrap">
                        <div class="nav-tabs-horizontal" data-plugin="tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" onclick="getTab('{{url('accounting/salary/index')}}')" data-toggle="tab" href="javascript:void()" aria-controls="exampleTabsOne" role="tab" aria-expanded="true">
                                        Əməkhaqqı
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" onclick="getTab('{{url('accounting/advance/index')}}')" data-toggle="tab" href="javascript:void()" aria-controls="exampleTabsTwo" role="tab" aria-expanded="false">
                                        Avans
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" onclick="getTab('{{url('accounting/vacation/index')}}')" data-toggle="tab" href="javascript:void()" aria-controls="exampleTabsTwo" role="tab" aria-expanded="false">
                                        Məzuniyyət
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content pt-20">
                                <div class="tab-pane active" role="tabpanel" aria-expanded="true">

                                    <!-- tab content -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Example Tabs -->
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal modal-primary fade modal-3d-flip-vertical modal-default"
         id="payment-info-modal" aria-hidden="false" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="modal-title" style="float:left">
                        Ödənişlər haqqında ətraflı məlumat
                    </h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

@endsection

@section('scripts')

    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js ')}}"></script>
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/spin.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/ladda.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/toastr/toastr.js')}}"></script>
    <script src="{{asset('core/global/vendor/pickdate/picker.js')}}"></script>
    <script src="{{asset('core/global/vendor/pickdate/picker.date.js')}}"></script>
    <script src="{{asset('core/global/vendor/pickdate/picker.time.js')}}"></script>
    <script src="{{asset('core/global/vendor/simple-pagination/simplePagination.js')}}"></script>
    <script src="{{asset('core/global/vendor/jspdf/jspdf.js')}}"></script>

    <script src="{{asset('js/custom/pages/accounting/index.js') }}"></script>

@endsection