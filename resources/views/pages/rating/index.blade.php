@extends('layouts.main_layout',['sidebar'=>'rating','nopage' => true,'data' => $employees])

@section('title', !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı')

@section('links')
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/uikit/buttons.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endsection

@section('content')
    {{--@include('pages.chairman.component.index', ['data'=>$data]);--}}
    <!-- Contacts Content -->

    <div class="">
        <div id="contactsContent" class="page-content page-content-table py-20" data-plugin="selectable">
            <!-- Actions -->
            <div class="page-content-actions py-0">
                <div class="float-right" style="display: flex">

                    <div class="form-group pt-0 mr-40 index-increase mt-10" style="display: flex">
                        @if($notification->data->count > 0)
                        <span style="cursor: pointer" onclick="getList()">
                            <i class="icon md-notifications alert-not alert-not-back-danger"></i>
                            <span class="badge badge-pill up badge-danger notification-count-control">{{$notification->data->count}}</span>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-5 mr-40 index-increase" style="display: flex">
                        <input type="checkbox" class="js-switch-small float-left" id="isTradeUnion"  required="required">
                        <h5 class="mt-1 ml-10" id="date-filter-text">Aylıq</h5>
                    </div>
                    <div class="ml-15">
                        <div class="input-group index-increase">
                            <span class="input-group-addon date-range-start">
                                <i class="icon md-calendar font-black" aria-hidden="true"></i>
                            </span>
                            <input type="text" id="startDate" class="form-control font-black input-dater" name="startDate" value="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rate By Area -->
            <div class="dropdown-divider"></div>
            @include('pages.rating.component.rateBy')
        </div>
    </div>
    </div>

    <div class="modal fade bs-example-modal-xl" tabindex="-1" id="ratingModal" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" onclick="$('#ratingModal').modal('hide')" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer pt-10 pb-10 mt-5" style="background: #e8e8e8">
                    <button type="button" onclick="$('#ratingModal').modal('hide')"  class="btn text-black btn-default">Bağla</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Add/Edit-->

@section('scripts')
    <link rel="stylesheet" href="{{asset('css/rating.css')}}">
    {{-- Sweetalert --}}
    {{-- Core --}}
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js ')}}"></script>

    {{-- Select2 --}}
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>

    {{-- Plugins --}}
    <script type="text/javascript" src="{{ asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/pages/orders/file/file_generator.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/plugins/page-row/orders/orders-row.js') }}"></script>
    <script src="{{ asset('core/global/vendor/switchery/switchery.min.js')}}"></script>
    <script>
        $('#tree-container-show').hide();
        setTimeout(function(){
            $.getScript("{{asset('/core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}");
            $.getScript("{{asset('/core/global/js/Plugin/bootstrap-datepicker.js')}}");
            $.getScript("{{asset('/core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.az.min.js')}}");
        },500);
        setTimeout(function(){
            $('.input-dater').datepicker({
                format: 'mm.yyyy',
                viewMode: "months",
                minViewMode: "months",
                todayHighlight: true,
                weekStart: 1,
                autoclose: true,
                language:'az'
            });
        },1200);
        $('.breadcrumb').find('.breadcrumb-item').last().remove();
        $('.breadcrumb').find('.breadcrumb-item').last().find('a').text('Əməkdaşların xidməti fəaliyyətlərinin qiymətləndirilməsi');
    </script>
    <script src="{{asset('js/custom/pages/rating/main.js')}}"></script>
@endsection