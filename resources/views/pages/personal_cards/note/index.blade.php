<section id='links'>
</section>

<section id='content'>
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div  class="panel-body pt-20">


            <div class="tab-content">
                @include('components.filter-bar' , ['sid' => 'note_search','sname' => 'n-search' , 'pid' => 'note_paginate' , 'pname' => 'n-pagination'])
                <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th class="table-width-5">№</th>
                        <th class="table-width-auto">Qeyd</th>
                        <th class="table-width-10">Tarix</th>
                        <th class="table-width-8"></th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    {{--@if(count($new) > 0)--}}
                        {{--@foreach($new as $newNC)--}}
                            {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '', 'row' => ['note','issueDate']])--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                    @if($data->totalCount > 0)
                        @foreach($data->data as $key => $value)
                            <tr id="{{ $value->id }}">
                                <td>{{++$key}}</td>
                                <td>{{$value->note}}</td>
                                <td>{{date('d.m.Y', strtotime($value->issueDate))}}</td>
                                <td class="text-nowrap text-right">
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('note.edit' , $value->id)}}' , 'note')">
                                        <i class="icon md-edit" aria-hidden="true"></i>
                                        <span class="tptext tpedit">Düzəliş et</span>
                                    </div>
                                    <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('note.destroy' , $value->id)}}" )'>
                                        <i class="icon md-delete" aria-hidden="true"></i>
                                        <span class="tptext tpdel">Sil</span>
                                    </div>
                                </td>
                            </tr>
                            {{--@if(!is_null($value->nc))--}}
                                {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['note','issueDate']])--}}
                            {{--@endif--}}
                        @endforeach
                    @else
                        <tr align="center"><td style="display: none">0</td><td colspan="4" class="alert alert-warning" >Məlumat daxil edilməmişdir! </td></tr>
                    @endif

                    </tbody>
                </table>


                {{-- Pagination load more button --}}
                @include('components.pagination' , ['id' => 'note_paginate','url' => route('note.index') , 'totalCount' => $data->totalCount,'page' => $page])
                {{-- /Pagination load more button --}}
                {{--Modals--}}
                @include('pages.personal_cards.note._modals', ['modalid'=>'note_form'])
                {{--/Modals--}}
                <label ></label>

                <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button" data-selectable="selectable">
                    <button id="addToTable"  style="margin-right: 20px; margin-right: -2px;" class="btn btn-floating btn-info waves-effect"
                            data-target="#note" data-toggle="modal" type="button">
                        <i class="icon md-plus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>


</section>

<section id="scripts">
    <script src="{{asset('js/custom/plugins/page-row/note-row.js')}}"></script>
    <script>
        function confirmation(elem,isC,id){
            $.ajax({
                url:'/personal-cards/note-confirm/'+id+'/'+isC+'/',
                type: 'GET',
                success: function(response){
                    if(response == 200){
                        $('[href="/personal-cards/note"]').click();
                    }
                }
            });
        }
        $(".date_id").datepicker({
            orientation: "left bottom",
            format: 'dd.mm.yyyy',
            weekStart: 1
        });
        $('#note_search').search('note_search','note_paginate');
        $('#note_paginate').pagination('load','note_paginate','note_search');
        //        $('#exampleUploadForm').uploaderC('exampleUploadForm');
    </script>

</section>


