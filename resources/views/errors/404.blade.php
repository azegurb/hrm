@extends('errors.layouts.error_layout')

@section('title', '404')

@section('page-title', '404 Səhifə tapılmadı')

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
                <h1 class="animation-slide-top">404</h1>
                <p>SƏHİFƏ TAPILMADI !</p>
                <p>{{$exception->getMessage()}}</p>
            </header>
            {{--<p class="error-advise" style="color: #000;">Axtardığınız səhifə tapılmadı xahiş edirik düməyə basaraq Ana səhifəyə geri qayıdın</p>--}}
            <div class="btn btn-primary btn-round custom-reload" onclick="window.location.reload()">Ana səhifə</div>
            <footer class="page-copyright">
                <p>HR ASAN</p>
                <p>© 2017. Bütün hüquqları qorunur.</p>

            </footer>
        </div>
    </div>
    <!-- End Page -->
@endsection