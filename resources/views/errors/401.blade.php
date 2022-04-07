@extends('errors.layouts.error_layout')

@section('title', '401')

@section('page-title', '401 Sizin sistemə giriş izniniz yoxdur' )

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
                <h1 class="animation-slide-top">401</h1>
                <p>SİZİN BU SƏHİFƏYƏ GİRİŞİNİZ YOXDUR !</p>
                <p>{{$exception->getMessage()}}</p>
            </header>
            <p class="error-advise" style="color: #000;">Xahiş edirik sistemə yenidən daxil olmağı yoxlayın</p>
            <div class="btn btn-primary btn-round custom-reload" onclick="window.location.reload()">Yenidən daxil ol</div>
            <footer class="page-copyright">
                <p>HR ASAN</p>
                <p>© 2017. Bütün hüquqları qorunur.</p>

            </footer>
        </div>
    </div>
    <!-- End Page -->
@endsection