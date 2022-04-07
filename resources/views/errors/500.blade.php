@extends('errors.layouts.error_layout')

@section('title', '500')

@section('page-title', '500 Daxili sistem xətası')

@section('content')
    <style>
        .custom-reload{
            color: white!important;
            cursor: pointer;
        }
    </style>
    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content vertical-align-middle">
            <header>
                <h1 class="animation-slide-top">500</h1>
                <p>İSTƏYİNİZ ÜZRƏ MƏLUMAT ƏLDƏ ETMƏK MÜMKÜN OLMADI !</p>
                <p>{{$exception->getMessage()}}</p>
            </header>
            <p class="error-advise" style="color: #000;">Bu haqda sistem inzibatçısına məlumat verməyiniz xahiş olunur !</p>
            <div class="btn btn-primary btn-round custom-reload" style="color:white;"  onclick="window.location.reload()">Yenidən yoxla</div>
            <footer class="page-copyright">
                <p>HR ASAN</p>
                <p>© 2017. Bütün hüquqları qorunur.</p>

            </footer>
        </div>
    </div>
    <!-- End Page -->
    <script>
        if(window.location.pathname != '/personal-cards'){
            window.location.replace("/");
        }
    </script>
@endsection