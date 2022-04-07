@extends('layouts.main_layout', ['sidebar'=>'salary'])

@section('title', 'Əmək haqqı')

@section('links')
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <script>var route = "{{route('salary.index')}}"</script>
    <yield id="links"></yield>
@endsection

@section('content')
    <yield id="content" style="width:100%">

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
    <script src="{{asset('core/assets/js/Plugin/menu.js')}}"></script>
    <script>
        $(".input_datepicker").datepicker({
            orientation: "left bottom",
            weekstart: 1
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
    <script>
        $('.dd-content').hide();
        $('.dd-menu').click(function(){
            $(this).next('.dd-content').slideToggle();
        });

    </script>
    <yield id="scripts"></yield>





@endsection