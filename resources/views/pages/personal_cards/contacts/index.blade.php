<section id="links">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{asset('core/global/vendor/animsition/animsition.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/asscrollable/asScrollable.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/switchery/switchery.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/intro-js/introjs.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/slidepanel/slidePanel.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/flag-icon-css/flag-icon.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/waves/waves.css')}}">
    <link rel="stylesheet" href="{{asset('core/assets/examples/css/forms/masks.css')}}">
</section>
<section id="content">
        <div class="panel nav-tabs-horizontal nav-tabs-inverse">
            <div  class="panel-body pt-20">
                {{-- Filters --}}
                    @include('components.filter-bar' , ['sid' => 'contact-search','sname' => 'c-search' , 'pid' => 'contacts_paginate' , 'pname' => 'c-pagination'])
                {{-- /Filters --}}
                {{--@if(count($new) > 0)--}}
                {{--<table class="table" style="border: 1px solid #ffe0b2;border-radius: 3px">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<td colspan="4" class="alert alert-info text-center">--}}
                            {{--<strong style="font-size: 20px">Yeni təsdiqə göndərilənlər</strong>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<th id="testin" class="table-width-5" data-id="" >№</th>--}}
                        {{--<th>Əlaqə vasitəsi</th>--}}
                        {{--<th>İnformasiya</th>--}}
                        {{--<th class="text-right table-width-8"></th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}

                        {{--@foreach($new as $newNC)--}}
                            {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['listContactTypeId.name','contactInfo']])--}}
                        {{--@endforeach--}}

                    {{--</tbody>--}}
                {{--</table>--}}
                {{--@endif--}}

                <table class="table">

                    <thead>
                        <tr>
                            <th id="testin" class="table-width-5" data-id="" >№</th>
                            <th>Əlaqə vasitəsi</th>
                            <th>İnformasiya</th>
                            <th class="text-right table-width-8"></th>
                        </tr>
                    </thead>
                    <tbody id="contact-tbody">
                    @if($data->totalCount > 0)
                    @foreach($data->data as $key => $value)
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            <td>{{$value->listContactTypeId->name}}</td>
                            <td>{{$value->contactInfo}}</td>
                            <td class="text-nowrap text-right">
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData('{{route('contacts.edit' , $value->id)}}' , 'contact-modal')">
                                    <i class="icon md-edit" aria-hidden="true"></i>
                                    <span class="tptext tpedit">Düzəliş et</span>
                                </div>
                                <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this) , "{{route('contacts.destroy' , $value->id)}}" )'>
                                    <i class="icon md-delete" aria-hidden="true"></i>
                                    <span class="tptext tpdel">Sil</span>
                                </div>
                            </td>
                        </tr>
                        {{--@if(!is_null($value->nc))--}}
                            {{--@include('components.row', ['value' => $value->nc,'count' => $key,'ccon' => $data->ccon,'row' => ['listContactTypeId.name','contactInfo']])--}}
                        {{--@endif--}}
                    @endforeach
                    @else
                        <tr align="center"><td colspan="4" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                    @endif
                    </tbody>

                </table>
                {{-- Pagination load more button --}}
                    @include('components.pagination' , ['id' => 'contacts_paginate','url' => route('contacts.index') , 'totalCount' => $data->totalCount,'page' => $page])
                {{-- /Pagination load more button --}}
            </div>
                <div class="site-action" data-animate="fade" data-child="button" data-selectable="selectable">
                        <button id="addToTable"  class="btn btn-floating btn-info waves-effect" data-target="#contact-modal" data-toggle="modal" type="button">
                            <i class="icon md-plus" aria-hidden="true"></i>
                        </button>
                </div>
        </div>
        {{-- Contact Modal --}}
        @include('pages.personal_cards.contacts._modals', ['modalid'=>'contact-modal_form'])
        {{-- /Contact Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('core/global/js/Plugin/ascolorpicker.js')}}"></script>

     {{--Sweetalert--}}

    <script>
            function confirmation(elem,isC,id){
                $.ajax({
                    url:'/personal-cards/contact-confirm/'+id+'/'+isC+'/',
                    type: 'GET',
                    success: function(response){
                        if(response == 200){
                            $('[href="/personal-cards/contacts"]').click();
                        }
                    }
                });
            }

        $('#listContactType').selectObj('listContactType');
        $('#contact-search').search('contact-search','contacts_paginate');
        $('#contacts_paginate').pagination('load','contacts_paginate','contact-search');

        var inputContact = $('input[name="contactinfo"]');

//        $('#listContactType').on('select2:select', function (event) {
//
//            console.log(event.params.data);
//
//            var label = event.params.data.sLabel;
//
//            switch (label) {
//                case 'mobile-personal' :
//                    inputContact.mask('(000)-000-00-00', { placeholder: "(000)-000-00-00" });
//                    break;
//
//                case 'mobile-work' :
//                    inputContact.mask('(000)-000-00-00', { placeholder: "(000)-000-00-00" });
//                    break;
//
//                default:
//                    inputContact.unmask();
//                    break;
//            }
//
//        });

    </script>

    @stack('scripts')

</section>