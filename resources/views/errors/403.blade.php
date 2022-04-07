@extends('errors.layouts.error_layout')

@section('title', '403')

@section('page-title', '403 Istifadəçinin Sessiya müddəti bitmişdir' )

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
                <h1 class="animation-slide-top">403</h1>
                <p>Sessiyanızın müddəti bitmişdir xahiş olunur sistemə yenidən daxil olun</p>
            </header>
            <p class="error-advise"></p>
            <a class="btn btn-primary btn-round custom-reload" href="{{url('/logout')}}">Yenidən daxil ol</a>
            <footer class="page-copyright">
                <p>Port Of Baku</p>
                <p>© 2017. Bütün hüquqları qorunur.</p>

            </footer>
        </div>
    </div>
    <!-- End Page -->
@endsection