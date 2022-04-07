<section id="links">

</section>
<section id="content">
    <div class="panel nav-tabs-horizontal nav-tabs-inverse">
        <div  class="panel-body pt-20">
            {{-- Filters --}}
            @include('components.filter-bar' , ['sid' => 'provision-search','sname' => 'p-search' , 'pid' => 'provision_paginate' , 'pname' => 'p-pagination'])
            {{-- /Filters --}}
            {{--@if(count($dataNC->data) > 0)--}}
                {{--<table class="table" style="border: 1px solid #ffe0b2;border-radius: 3px">--}}
                    {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<td colspan="5" class="text-center alert alert-warning" style="font-size: 20px">--}}
                                {{--<strong>Təsdiqə göndərilmişlər</strong>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th id="testin" class="table-width-5" data-id="" >№</th>--}}
                            {{--<th class="table-width-15">Status</th>--}}
                            {{--<th class="table-width-20">Təminat</th>--}}
                            {{--<th class="table-width-10">Əvəzolunma</th>--}}
                            {{--<th class="table-width-25">Əvəzolunma</th>--}}
                            {{--<th class="text-right table-width-8"></th>--}}
                        {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody >--}}
                    {{--@foreach($dataNC->data as $key => $valueNC)--}}
                        {{--@php($valueNC->id = $valueNC->mainId->id != null ? $valueNC->mainId->id : (int)$valueNC->provisionId->id)--}}
                        {{--<tr id="{{$valueNC->id}}">--}}
                            {{--<td>{{++$key}}</td>--}}
                            {{--<td>--}}
                                {{--<div class="checkbox-custom checkbox-warning text-left">--}}
                                    {{--<input type="checkbox" disabled="disabled" id="{{$valueNC->id}}" value="true" class="check-provision" name="status" {{$valueNC->status != 0 ? 'checked' : ''}}/>--}}
                                    {{--<label for="{{$valueNC->id}}"></label>--}}
                                {{--</div>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--{{$valueNC->provisionId->name}}--}}
                            {{--</td>--}}
                            {{--<td>--}}

                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<div class="col-md-8 float-left updater-replace" style="display: {{!empty($valueNC->replacedProvisionList) && count($valueNC->replacedProvisionList) > 0 ? 'initial' : 'none'}}">--}}
                                    {{--<select name="replacedProvisionId" id="provision-get_{{$valueNC->id}}" class="select" data-reId="{{!empty($valueNC->replacedProvisionList) ? $valueNC->replacedProvisionList[0]->id : '' }}" data-url="{{route('provision-get')}}">--}}
                                        {{--@if(!empty($valueNC->replacedProvisionList) && count($valueNC->replacedProvisionList) > 0)--}}
                                            {{--<option value="{{$valueNC->replacedProvisionList[0]->id}}">{{$valueNC->replacedProvisionList[0]->replacedProvisionId}}</option>--}}
                                        {{--@endif--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-4 float-right  submit-confirm"  style="display: {{$nc ? '' : 'none'}}">--}}
                                    {{--<button type="button" class="btn btn-sm btn-success" onclick="confirmation($(this),'true','{{$valueNC->id}}','{{$valueNC->customConfirmId}}')">Təsdiqlə</button>--}}
                                    {{--<button type="button" class="btn btn-sm btn-danger" onclick="confirmation($(this),'false','{{$valueNC->id}}','{{$valueNC->customConfirmId}}')">İmtina</button>--}}
                                {{--</div>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<script>--}}
                            {{--$('#provision-get_{{$valueNC->id}}').selectObj('provision-get_{{$valueNC->id}}' , false);--}}
                        {{--</script>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--@endif--}}

            <table class="table mt-30">
                <thead>
                <tr>
                    <th id="testin" class="table-width-5" data-id="" >№</th>
                    <th class="table-width-15">Status</th>
                    <th class="table-width-20">Təminat</th>
                    <th class="table-width-10">Əvəzolunma</th>
                    <th class="table-width-25">Əvəzolunma</th>
                    {{--<th class="text-right table-width-8"></th>--}}
                </tr>
                </thead>
                <tbody id="contact-tbody" align="left">
                @if($data->totalCount > 0)
                    @foreach($data->data as $key => $value)
                        @php($value->id = $value->id != null ? (int)$value->id : uniqid())
                        <tr id="{{$value->id}}">
                            <td>{{++$key}}</td>
                            <td>
                                <div class="checkbox-custom checkbox-primary text-left">
                                    <input type="checkbox" id="{{$value->id}}" value="true" class="check-provision" name="status" {{$value->status != 0 ? 'checked' : ''}}/>
                                    <label for="{{$value->id}}"></label>
                                </div>
                            </td>
                            <td>
                                {{$value->provisionName}}
                            </td>
                            <td>
                                <div class="checkbox-custom checkbox-primary text-left updater" style="display: {{$value->status != 0 ? 'initial' : 'none'}}">
                                    <input type="checkbox" id="replace_{{$value->id}}" data-id="{{$value->id}}" value="true" class="check-provision-replace" name="status" {{$value->status == 2 ? 'checked' : ''}}/>
                                    <label for="replace_{{$value->id}}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="col-md-10 float-left updater-replace" style="display: {{$value->status == 2 ? 'initial' : 'none'}}">
                                    <select name="replacedProvisionId" id="provision-get_{{$value->id}}" class="select" data-reId="{{!empty($value->replacedProvisionList) ? $value->replacedProvisionList[0]->id : '' }}" data-url="{{route('provision-get')}}">
                                        @if($value->status == 2 && !empty($value->replacedProvisionList))
                                            <option value="{{$value->replacedProvisionList[0]->id}}">{{$value->replacedProvisionList[0]->replacedProvisionId}}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2 float-right  updater-submit" data-id="{{$value->id}}" data-provision="{{$value->provisionId}}" data-activated="{{$value->status == 1 ? 'true' : 'false'}}" style="display: none">
                                    <button type="button" id="form_{{$value->id}}"  class="btn btn-primary btn-primary">Təsdiq</button>
                                </div>
                            </td>
                            {{--<td class="text-nowrap text-right">--}}
                                {{--<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick="editData('{{route('provision.edit' , $value->id)}}' , 'contact-modal')">--}}
                                    {{--<i class="icon md-edit" aria-hidden="true"></i>--}}
                                    {{--<span class="tptext tpedit">Düzəliş et</span>--}}
                                {{--</div>--}}
                                {{--<div class="btn btn-md btn-icon btn-flat btn-default waves-effect tp" onclick='removeData($(this) , "{{route('provision.destroy' , $value->id)}}" )'>--}}
                                    {{--<i class="icon md-delete" aria-hidden="true"></i>--}}
                                    {{--<span class="tptext tpdel">Sil</span>--}}
                                {{--</div>--}}
                            {{--</td>--}}
                        </tr>
                        <script>
                            $('#provision-get_{{$value->id}}').selectObj('provision-get_{{$value->id}}' , false);
                        </script>
                    @endforeach
                @else
                    <tr align="center"><td colspan="6" class="alert alert-warning">Məlumat daxil edilməmişdir!</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- Contact Modal --}}
    @include('pages.personal_cards.provision._modals')
    {{-- /Contact Modal --}}
</section>
<section id="scripts">
    <script src="{{ asset('js/custom/plugins/refresh.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/ascolorpicker.js')}}"></script>
    <script src="{{asset('js/custom/pages/provisions/controller.js')}}"></script>
    {{--Sweetalert--}}
    <script>
        function confirmation(elem,isC,id,ccid){
            $.ajax({
                url:'/personal-cards/provision-confirmation/'+id+'/'+isC+'/'+ccid,
                type: 'GET',
                success: function(response){
                    console.log(response);
                    if(response == 200){
                        $('[href="/personal-cards/provision"]').click();
                    }
                }
            });
        }
    </script>
    @stack('scripts')

</section>