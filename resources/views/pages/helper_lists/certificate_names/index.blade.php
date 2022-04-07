@extends('layouts.main_layout', ['sidebar'=>'helper_lists'])

@section('title', 'KÖMƏKÇİ SİYAHILAR')

@section('page-title', 'Sertifikat adları')

@section('links')
    <link rel="stylesheet" href="{{asset('core/global/vendor/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endsection

@section('content')
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'certificate-search','sname' => 'cer-search' , 'pid' => 'certificate-pagination' , 'pname' => 'cer-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-auto">Adı</th>
                    <th class="table-width-8"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-nowrap">
                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" >
                            <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                        </div>
                        <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" >
                            <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                <button id="addToTable"   class="btn btn-floating btn-info waves-effect" data-target="#certificate-names-modal" data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.certificate_names._modals')
    {{-- /Modal --}}
@endsection
@section('scripts')
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/select2.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js ')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-datepicker.js')}}"></script>
    <script>
        $(".input_datepicker").datepicker({
            orientation: "left bottom",
            weekStart: 1
        });
    </script>
@endsection