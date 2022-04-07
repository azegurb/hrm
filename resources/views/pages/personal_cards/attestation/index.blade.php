<section id='links'>
    <style>
        #text tr td {
            vertical-align: middle;
        }
    </style>
</section>
<section id='content'>
    <div class="panel" id="personalCards_Attestation">
        <div class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'attestation-search','sname' => 'att-search' , 'pid' => 'attestation_pagination' , 'pname' => 'att-pagination'])
            {{-- /Filters --}}
        </div>
        <div class="clearfix"></div>
        <div class="panel-body pt-0">

            {{--@if(count($new) > 0)--}}
                {{--<table class="table" style="border: 1px solid #ffe0b2;border-radius: 3px">--}}
                    {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<td colspan="4" class="alert alert-info text-center">--}}
                                {{--<strong style="font-size: 20px">Yeni təsdiqə göndərilənlər</strong>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th id="testin" class="table-width-5" data-id="">№</th>--}}
                            {{--<th class="table-width-15">Müsabiqənin növü</th>--}}
                            {{--<th >Qurumun adı</th>--}}
                            {{--<th class="table-width-10">Tarixi</th>--}}
                            {{--<th >Nəticə</th>--}}
                            {{--<th >Qeydlər</th>--}}
                            {{--<th class="text-right table-width-8"></th>--}}
                        {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@foreach($new as $newNC)--}}
                        {{--@include('components.row', ['value' => $newNC,'ccon' => $data->ccon,'count' => '','row' => ['listAttestationTypeId.name','organName','dateOff','listAttestationResultId.name','notes']])--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--@endif--}}

            <table  class="table">
                <thead>
                    <tr>
                        <th id="testin" class="table-width-5" data-id="">№</th>
                        <th class="table-width-15">Müsabiqənin növü</th>
                        <th >Qurumun adı</th>
                        <th class="table-width-10">Tarixi</th>
                        <th >Nəticə</th>
                        <th >Qeydlər</th>
                        <th class="text-right table-width-8"></th>
                    </tr>
                </thead>
                <tbody>
                @if($data->totalCount > 0)
                @foreach($data->data as $key=>$value)
                    <tr id="{{$value->id}}">
                        <td>{{++$key}}</td>
                        <td>{{$value->listAttestationTypeId->name}}</td>
                        <td>{{$value->organName}}</td>
                        <td>{{$value->dateOff}}</td>
                        <td>{{$value->listAttestationResultId->name}}</td>
                        <td>{{$value->notes}}</td>
                        <td class="text-nowrap text-right">
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"  onclick="editData('{{route('attestation.edit' , $value->id)}}' , 'attestation-modal')">
                                <i class="icon md-edit" aria-hidden="true"></i>
                                <span class="tptext tpedit">Düzəliş et</span>
                            </div>
                            <div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp"   onclick='removeData($(this) , "{{route('attestation.destroy' , $value->id)}}" )'>
                                <i class="icon md-delete" aria-hidden="true"></i>
                                <span class="tptext tpdel">Sil</span>
                            </div>
                        </td>
                    </tr>
                    {{--@if(!is_null($value->nc))--}}
                        {{--@include('components.row', ['value' => $newNC,'count' => '','row' => ['listAttestationTypeId.name','organName','dateOff','listAttestationResultId.name','notes']])--}}
                    {{--@endif--}}
                @endforeach
                @else
                    <tr align="center"><td colspan="7" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>
            {{-- Pagination load more button --}}
            @include('components.pagination' , ['id' => 'attestation_pagination','url' => route('attestation.index') , 'totalCount' => $data->totalCount,'page' => $page])
            {{-- /Pagination load more button --}}
        </div>

    </div>
    {{-- Modal --}}
    @include('pages.personal_cards.attestation._modals')
    {{-- /Modal --}}
    <div class="site-action">
        <button  class="btn btn-floating btn-info waves-effect" data-target="#attestation-modal" data-toggle="modal" type="button">
            <i class="icon md-plus" aria-hidden="true"></i></button>
    </div>


</section>
<section id='scripts'>

    <script src="{{asset('js/custom/plugins/page-row/attestation-row.js')}}"></script>
    <script>
        $('#listAttestationType').selectObj('listAttestationType');
        $('#listAttestationResult').selectObj('listAttestationResult');
        $('#attestation-search').search('attestation-search','attestation_pagination');
        $('#attestation_pagination').pagination('load','attestation_pagination','attestation-search');
    </script>
    <script>
        $('.date-picker').datepicker({
            format: 'dd.mm.yyyy',
            language: 'az',
            clearBtn: true,
            todayHighlight: true,
            weekStart: 1,
            autoclose: true
        });
    </script>

</section>