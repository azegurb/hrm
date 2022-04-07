@extends('layouts.main_layout', ['sidebar'=>'helper_lists'])

@section('title', 'KÖMƏKÇİ SİYAHILAR')

@section('links')
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <script>var route = "{{route('helper-list.index')}}"</script>
    <yield id="links"></yield>
@endsection

@section('content')
    <yield id="content" style="width:100%">
        {{-- Modal --}}
        @include('pages.helper_lists.position_names._modals')
        {{-- /Modal --}}
    </yield>
@endsection
@section('scripts')
    {{-- Select2 --}}
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/select2.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/spin.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/ladda/ladda.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/ladda.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js ')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-datepicker.js')}}"></script>
    <script>
        $(".input_datepicker").datepicker({
            orientation: "left bottom"
        });
    </script>

    <script>
        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
        $('#tree-container-show').hide();
    </script>
    <yield id="scripts"></yield>
@endsection