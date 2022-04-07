<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'award-types-search','sname' => 'award-search' , 'pid' => 'award_types_pagination' , 'pname' => 'award-pagination'])
            {{-- /Filters --}}
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th class="table-width-5">№</th>
                    <th class="table-width-auto"></th>
                    <th class="table-width-auto">Adı Soyadı</th>
                    <th class="table-width-auto">Vəzifəsi</th>
                    <th class="table-width-auto">Məzuniyyətə çıxma tarixi</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @php($no = 0)
                @foreach($data->data as $key => $value)
                    <tr>
                        <td>{{++$no}}</td>
                        <td><img class="avatar img-fluid" src="{{$value[0]->photo != null ? 'data:image/png;base64,'.$value[0]->photo : asset('media/noavatar.png')}}" alt="..."></td>
                        <td>{{$value[0]->firstName . ' ' . $value[0]->lastName }}</td>
                        <td>{{$value[0]->listPositionName}}</td>
                        <td>{{$value[0]->vacationStartDate}}</td>
                        <td class="text-nowrap text-right">
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="openModal('{{route('salary_vacation.edit' , $value[0]->userId)}}' , 'salary-vacation-modal')">
                                <i class="icon md-settings" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            {{--@include('components.pagination' , ['id' => 'award_types_pagination','url' => route('award-types.index') , 'totalCount' => $data->totalCount,'page' => $page])--}}
            {{-- /Pagination load more button --}}
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.salary.salary_vacation._modals')
    {{-- /Modal --}}
</section>
<section id="scripts">
    <script src="{{asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script src="{{asset('js/custom/plugins/page-row/helper-lists/awardtypes-row.js')}}"></script>
    <script>
        $('#award-types-search').search('award-types-search','award_types_pagination');
        $('#award_types_pagination').pagination('load','award_types_pagination','award-types-search');
    </script>
</section>