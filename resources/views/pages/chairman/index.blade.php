@extends('layouts.main_layout',['sidebar'=>'','nopage' => true])

@section('title', !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı')

@section('links')
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/uikit/buttons.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <script>var route = "{{url('/chairman/main')}}"; var hasId = false</script>
@endsection

@section('content')
    @include('pages.chairman.component.index', ['data'=>$data]);
@endsection

<!-- Modal Add/Edit-->

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