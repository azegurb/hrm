@extends('layouts.main_layout',['sidebar'=>''])

@section('title', !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı')

@section('links')
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/uikit/buttons.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <script>var route = "{{route('orders.index')}}"; var hasId = false</script>
@endsection

@section('content')

    <div class="panel" id="personalCards_orders">
        <div class="panel-heading p-20">
            {{--Filters--}}
            @include('components.filter-bars.orders' , ['sid' => 'orders-search','sname' => 't-search' , 'pid' => 'orders_paginate' , 'pname' => 't-pagination'])
            {{--End Filters--}}
        </div>
        <div class="clearfix"></div>
        <div class="panel-body pt-0">
            <div class="row">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th class="table-width-5">№</th>
                        <th>Əmrin tipi</th>
                        <th>Əmrin nömrəsi</th>
                        <th>Əmrin verilmə tarixi</th>
                        <th class="table-width-8"></th>
                    </tr>
                    </thead>
                    <tbody id="ordersBody">
                    @if($data->totalCount > 0)
                        @foreach($data->data as $key=>$order)
                            <tr id="{{ $order->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $order->listOrderTypeId->name }}</td>
                                <td>{{ $order->orderNum }}</td>
                                <td>{{ $order->orderDate }}</td>
                                <td class="text-nowrap text-right">
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"
                                         onclick="openModal('{{route('orders.edit', $order->id)}}', 'ordersModal')" title="Düzəliş et">
                                        <i class="icon md-edit" aria-hidden="true"></i>
                                        <span class="tptext tpedit">Düzəliş et</span>
                                    </div>
                                    {{--<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"--}}
                                         {{--onclick="removeData($(this), '{{ route('orders.destroy', $order->id) }}')" title="Sil">--}}
                                        {{--<i class="icon md-delete" aria-hidden="true"></i>--}}
                                        {{--<span class="tptext tpdel">Sil</span>--}}
                                    {{--</div>--}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr align="center"><td colspan="5" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                    @endif
                    </tbody>
                </table>
                {{-- Pagination load more button --}}
                @include('components.pagination' , ['id' => 'orders_paginate','url' => route('orders.index') , 'totalCount' => $data->totalCount, 'page' => $page])
                {{-- /Pagination load more button --}}
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include('components.modal-header' , ['id' => 'ordersModal','mdlTitle' => 'Əmrlərin daxil / redaktə edilməsi ekranı', 'mdlSize' => 'xl', 'mdUrl' => route('orders.store')])
    @include('components.modal-footer')
    <!-- End Modal -->

    <!-- Add button-->
    <div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">
        <button id="addToTable" class="btn btn-floating btn-info waves-effect" onclick="openModal('{{route('orders.create')}}', 'ordersModal')" type="button">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
    <!-- /Add button-->

@endsection

@section('scripts')

    {{-- Sweetalert --}}
    {{-- Core --}}
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js ')}}"></script>

    {{-- Select2 --}}
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>

    {{-- Plugins --}}
    <script type="text/javascript" src="{{ asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/pages/orders/file/file_generator.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/plugins/page-row/orders/orders-row.js') }}"></script>

    <script>
        $('#tree-container-show').hide();
        $('#orders-search').search('orders-search','orders_paginate');
        $('#orders_paginate').pagination('load','orders_paginate','orders-search');

        /* select order type for filter bar */

        $('#orderTypesFilter').selectObj('orderTypesFilter', 'personalCards_orders', false, false, 'order-types');
        $('.order-types').closest('.select2-container').css('z-index', 1);

        /* use of advanced filer method */

        $('[data-plugin="datepicker"]').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            weekStart: 1
        });

        let fields = [
            {
                type      : 'select',
                selector  : '#orderTypesFilter',
                filterType: '='
            },
            {
                type      : 'text',
                selector  : '#orderNumberFilter',
                filterType: 'contains'
            },
            {
                type      : 'date-range',
                selectors : {
                    start : '#orderDateStart',
                    end   :   '#orderDateEnd'
                }
            }
        ];

        let config = {
            tableBody: $('#ordersBody'),
            rowGenerator: 'orders_paginate',
            indexUrl: '/orders',
            fields: fields
        };

        window.initFilters(config);

    </script>

    @include('components.filedoc')

@endsection