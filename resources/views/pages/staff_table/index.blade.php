@extends('layouts.main_layout',['sidebar'=>''])

@section('title', !empty(authUser()) ? authUser()->user_data->user->firstName.' '.authUser()->user_data->user->lastName: 'İstifadəçi adı')

@section('links')
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/bootstrap-maxlength/bootstrap-maxlength.css') }}">
    <link rel="stylesheet" href="{{ asset('core/global/vendor/ladda/ladda.css') }}">
    <link rel="stylesheet" href="{{ asset('core/assets/examples/css/uikit/buttons.css')}}">
    <link rel="stylesheet" href="{{ asset('core/assets/examples/css/advanced/animation.css')}}">
    <link rel="stylesheet" href="{{ asset('js/custom/plugins/context/jquery.contextMenu.css')}}">

    <script>var route = "{{route('position.index')}}";var tree = {!! $tree !!} ; var hasId = 200;var side = false;

    </script>
    <style>

        li.jstree-open > a .jstree-icon, li.jstree-closed > a .jstree-icon {
            background: url(../core/global/vendor/jstree/city-hover.svg) no-repeat top left;
            background-size: 16px 16px;
        }
        li.jstree-leaf > a .jstree-icon {
            background: url(../core/global/vendor/jstree/building-org.svg) no-repeat top left;
            background-size: 16px 16px;
        }

        .panel-info li{
            float: left;
            list-style-type: none;
            margin-right: 15px;
            cursor: pointer;
            border-radius: 3px;
            padding: 1px 10px;
            border: 1px solid transparent;
        }
        .panel-info li .num{
            text-align: center;
            font-size: 25px;
        }
        .taskAllOf:hover{
            border-color:#a4a6c3 ;
            background: rgba(229, 229, 255, 0.62);
        }
        .taskAllOf.active{
            border-color:#a4a6c3 ;
            background: rgba(229, 229, 255, 0.62);
        }
        .tasktypeExpired:hover{
            border-color: #e5a8a5 ;
            background: rgba(255, 212, 219, 0.62);
        }
        .tasktypeExpired.active{
            border-color: #e5a8a5 ;
            background: rgba(255, 212, 219, 0.62);
        }
        .tasktypeProcessing:hover{
            border-color: #fbb36a ;
            background: rgba(255, 230, 207, 0.62);
        }
        .tasktypeProcessing.active{
            border-color: #fbb36a ;
            background: rgba(255, 230, 207, 0.62);
        }
        .tasktypeDone:hover{
            border-color: #65a06f ;
            background: rgba(190, 255, 208, 0.62);
        }
        .tasktypeDone.active{
            border-color: #65a06f ;
            background: rgba(190, 255, 208, 0.62);
        }
        .tasktypeNotRegistered:hover{
            border-color: #a2a59e ;
            background: rgba(237, 241, 233, 0.62);
        }
        .tasktypeNotRegistered.active{
            border-color: #a2a59e ;
            background: rgba(237, 241, 233, 0.62);
        }

    </style>

@endsection

@section('content')

    <div class="panel panel-info panel-line mb-5">
        <div class="panel-body">
            <div class="col-md-12">
                <ul class="panel-info float-right">

                    <li class="taskAllOf tasksAll text-center">
                        <div class="num blue-a400 count">{{ $totals->data->totalCountOwn }}</div>
                        <p class="font-black">Ştat sayı</p>
                    </li>
                    <li class="tasktypeExpired tasksAll text-center">
                        <div class="num red-600 total-count" data-type="expired" >{{ $totals->data->totalCount }}</div>
                        <p class="font-black">Cəmi ştat sayı</p>
                    </li>
                    <li class="tasktypeProcessing tasksAll text-center">
                        <div class="num orange-600 salary" data-type="processing">{{ $totals->data->totalSalaryOwn }}</div>
                        <p class="font-black">Maaş</p>
                    </li>
                    <li class="tasktypeDone tasksAll text-center">
                        <div class="num green-600 total-salary" data-type="done">{{ $totals->data->totalSalary }}</div>
                        <p class="font-black">Cəmi maaş</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel" id="personalCards_TrainingNeeds">
        <div class="panel-heading p-20">
            {{--Filters--}}
            @include('components.filter-bar' , ['sid' => 'staff-table-search','sname' => 't-search' , 'pid' => 'staff_table_paginate' , 'pname' => 't-pagination'])
            {{--End Filters--}}
        </div>
        <div class="clearfix"></div>
        <div class="panel-body pt-0">
            <div class="row">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th class="table-width-5">№</th>
                        <th>Vəzifə</th>
                        <th>Ştat sayı</th>
                        <th>Maaş</th>
                        <th class="table-width-8"></th>
                    </tr>
                    </thead>
                    <tbody id="positionNameTBody">

                    </tbody>
                </table>
                <div class="col-md-12 load-more-container" align="center" data-total="" id="staff-table-paginate">
                    <button class="btn btn-default btn-round col-md-3 btn-load-more-staff-table" style="display: none;"> Daha çox </button>
                    <div class="col-md-12">
                        <div class="loader pagination-loader vertical-align-middle loader-circle" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('components.modal-header' , ['id' => 'staffTableModal','mdlTitle' => 'Ştat üzrə vəzifələrin qeydiyyatı ekranı', 'mdUrl' => route('position.store'), 'custom' => 'postData($(this))'])
    <div class="row">
        <div class="col-md-6">
            <h4>Struktur bölmə:</h4>
            <select class="form-control select" id="listStructures" name="structureId" data-url="{{ route('structures.list') }}" required>
                <option></option>
            </select>
        </div>
        <div class="col-md-6">
            <h4>Vəzifə:</h4>
            <select id="listPositions" class="form-control select" name="listPositionNameId" data-url="{{ url('/helper-lists/list-position-names') }}" required>
                <option></option>
            </select>
        </div>
        <div class="col-md-4">
            <h4>Ştat sayı:</h4>
            <input type="number" class="form-control" name="stuffCount" required>
        </div>
        <div class="col-md-4">
            <h4>Maaş:</h4>
            <input type="number" class="form-control" step="any" name="salary" required>

            <div id="salarydiv" style="display: none ">
                <input type="text" class="form-control" step="any" id="salaryId" name="salaryId">
            </div>

        </div>
        <div class="col-md-4">
            <h4>Məzuniyyət günləri:</h4>
            <input type="number" class="form-control" name="vacationDays" min="0" max="99" required>
        </div>
        <div class="col-md-6" style="display: none;">
            <div class="col-md-6" style="top: 15px;">
                <div class="checkbox-custom checkbox-primary">
                    <input type="checkbox" id="isCivilService" name="isCivilService"/>
                    <label for="isCivilService">Dövlət qulluğu</label>
                </div>
                <div class="checkbox-custom checkbox-primary">
                    <input type="checkbox" id="notStuff" name="notStuff"/>
                    <label for="notStuff">Ştatdan kənar</label>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="display: none;">
            <div id="positionClassification" style="display: none;">
                <h4>Vəzifə təsnifatı:</h4>
                <select id="listPositionClassifications" class="form-control select" name="listPositionClassificationId" data-url="{{ route('position-classification.list') }}">
                    <option></option>
                </select>
            </div>
        </div>
        <div id="payment-container" class="row col-md-12 m-0 mt-40" style="border-top: 1px solid #efefef">
            <div class="col-md-12 mt-15 mb-10">
                <button id="add-btn" type="button" class="btn btn-floating btn-info btn-xs waves-effect pull-left">
                    <i class="icon md-plus" aria-hidden="true"></i>
                </button>
                <label><h4 class="pull-right ml-10">Ödəniş əlavə et</h4></label>
            </div>
            <div class="col-md-6">
                <h5>Ödənişin adı:</h5>
            </div>
            <div class="col-md-5">
                <h5>Məbləğ/Faiz:</h5>
            </div>

            <table class="table table-striped" id="paymentTable">


            </table>


        </div>
    </div>
    @include('components.modal-footer')
    <!-- End Modal -->

    @include('pages.personal_cards.index.tree.modal')

    <!-- Add button-->
    <div class="site-action">
        <button type="button" data-target="#staffTableModal" data-toggle="modal" class="btn btn-floating btn-info waves-effect">
            <i class="icon md-plus" aria-hidden="true"></i>
        </button>
    </div>
    <!-- /Add button-->

@endsection

@section('scripts')
    <script src="{{asset('core/global/vendor/raty/jquery.raty.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/panel.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/raty.js')}}"></script>
    <script src="{{asset('core/assets/examples/js/uikit/panel-structure.js')}}"></script>

    {{-- Select2 --}}
    <script src="{{asset('core/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('core/global/vendor/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/select2.js')}}"></script>

    <script src="{{asset('js/custom/plugins/context/jquery.contextMenu.js')}}"></script>
    <script src="{{asset('js/custom/plugins/context/jquery.ui.position.js')}}"></script>

    {{--Page footer scripts--}}
    <script src="{{ asset('js/custom/pages/staff-table/staff-table-scripts.js') }}"></script>
    <script src="{{ asset('js/custom/pages/staff-table/get-table-body.js') }}"></script>
    <script src="{{ asset('js/custom/pages/staff-table/post-data.js') }}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/tree-operations.js')}}"></script>
    <script src="{{asset('js/custom/pages/personal_cards/change-parent.js')}}"></script>



    <script>

        /*
         *
         * Search
         *
         * */

        Array.prototype.exists=function (obj) {

            var found=false;

            for(var i=0;i<this.length;i++){

                if(this[i]==obj){

                    found=true;
                    break;
                }

            }

            return found;
        }


        var paymentTypes='',  selectedArr=[], deletedArr=[];

        $('#staff-table-search').on('keyup', function () {

            var query     = $(this).val();
            var structure = $(this).data('structure');

            $.ajax({
                type: 'GET',
                url: '/staff-table',
                data: { search: query, structureId: structure },
                success: function (response) {

                    if (parseInt(response.code) === 200) {

                        $('#positionNameTBody').html(loadTable(response.data));

                    }

                }
            });

        });

        /*
         *
         * Change limit
         *
         * */

        $('#staff_table_paginate_filter').on('change', function () {

            $('.pagination-loader').show('fast');

            var query     = $('#staff-table-search').val();
            var structure = $('#staff-table-search').data('structure');
            var limit     = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/staff-table',
                data: { search: query, structureId: structure, limit: limit},
                success: function (response) {

                    if (parseInt(response.code) === 200) {

                        $('#positionNameTBody').html(loadTable(response.data));

                        $('.pagination-loader').hide('fast');

                    }

                }
            });

        });


        $('#staffTableModal').on('shown.bs.modal', function () {


            deletedArr=[], selectedArr=[];
            document.getElementById('paymentTable').innerHTML='';

            if (typeof $('#staff-table-search').data('structure') != 'undefined') {


                var select = $('#listStructures');

                $(document).find('form').append('<input type="hidden" name="structureId" id="structureId" value="' + $('#staff-table-search').data('structure') + '">');

                var option = $('<option></option>').prop('selected', true)
                    .val($('#staff-table-search').data('structure'))
                    .text($('#staff-table-search').data('name'));


                option.appendTo(select);
                select.trigger('change');

                select.prop('disabled', true);

            }

            $('#structuresGet').selectObj('structuresGet' , '' , '' , true);
            $('#structuresType').selectObj('structuresType');

            if(typeof $('#staffTableModal').attr('data-rel')=='undefined'){

                if(document.getElementById('structureId')){
                    var data={struktureId:document.getElementById("structureId").value};
                }
                else {
                    var data=null;
                }
            }

            else {

                $('#paymentTable').html('');

                if(document.getElementById('_put')){
                    var data={struktureId:document.getElementById("structureId").value, posNameId:$('#staffTableModal').attr('data-rel')};

                }
                else {
                    var data=null;

                }

                //var data=null;
            }

            console.log(data);
            $.ajax({
                type: 'GET',
                url: '/staff-table/getpaymenttypes',
                async:false,
                data:data,
                success: function (response) {

                    if (parseInt(response.code) === 200) {

                        paymentTypes = response;
                        var tableStr = '', optionStr = '';
                        var wholedata = response.data;

                        console.log(response);
                        if (response && response.inner && response.inner.totalCount>0){

                            response.inner.data.forEach(function (element, index) {

                                var selectedId = response.inner.data[index].paymentTypeIdId;
                                var selectedValue = response.inner.data[index].value;
                                var startDate=response.inner.data[index].startDate;
                                var endDate=response.inner.data[index].endDate;
                                var id = response.inner.data[index].id;
                                console.log(response.inner.data[index]);
                                var rowC = createRow(selectedId, wholedata, selectedValue, id, startDate, endDate)

                                document.getElementById('paymentTable').appendChild(rowC)

                            })

                        }
                        else {

                            response.data.forEach(function (element, index) {

                                var selectedId = response.data[index].id;
                                var selectedValue = response.data[index].itemName;

                            })
                        }
                    }

                    $('.newpaymentTypeIdName').each(function () {

                        selectedArr.push($(this).val())

                    });

                    $(".startDate").datepicker({
                        orientation: "left bottom",
                        format: 'yyyy-mm-dd',
                        weekstart: 1
                    });
                    $(".endDate").datepicker({
                        orientation: "left bottom",
                        format: 'yyyy-mm-dd',
                        weekstart: 1
                    });

//                    $(".startDate").datepicker({
//                        orientation: "left bottom",
//                        format: 'dd.mm.yyyy'
//                    });



                }
            });

        });

        //        $('#payment-head').hide();

        var labelCount = 0;
        function  createRow(selectedId, wholedata, selectedValue, id, startDate, endDate) {
            labelCount++;

            var tr=document.createElement('tr');
            var cell1=document.createElement('td');
            var cell2=document.createElement('td');
            var cell3=document.createElement('td');
            var cell4=document.createElement('td');
            var cell5=document.createElement('td');
            var cell6=document.createElement('td');

            var input=document.createElement('select');
            input.name='paymentTypeIdName[]';
            var input2=document.createElement('input');
            input2.name='relPositionPaymentValue[]';
            input2.value=selectedValue;
            input2.style.width='80px';
            var input3=document.createElement('button');
            input3.innerHTML='<i class="icon md-minus" aria-hidden="true"></i>';
            input3.className='btn btn-floating btn-danger btn-xs waves-effect';
            input.className='form-control paymentTypeIdName';
            input2.value=selectedValue;
            input2.id=id;

            var input4=document.createElement('input');

            input4.type='text';
            input4.className='form-control startDate';
            input4.name='oldstartDate[]';
            input4.value=startDate;
            input4.style.width='100px';

            var input5=document.createElement('input');
            input5.name='oldendDate[]';
            input5.value=endDate;
            input5.className='form-control endDate';
            input5.style.width='100px';

            var isclosed=document.createElement('input');
            isclosed.type='checkbox';
            isclosed.name='isClosed[]';
            isclosed.className='js-switch-small1 isClosed';
            isclosed.id='checkbox'+labelCount;
            var checkboxLabel=document.createElement('label');
            checkboxLabel.for='checkbox'+labelCount;
            var checkboxDiv=document.createElement('div');
            checkboxDiv.className= 'checkbox-custom checkbox-primary';

            var inputstr='<option value="0">Seçin...</option>';
            $.each(wholedata, function (index, itemData) {


                if(itemData.id==selectedId){

                    inputstr=inputstr+'<option value="'+itemData.id+'" selected>'+itemData.itemName+'</option>';
                }
                else {

                    inputstr=inputstr+'<option value="'+itemData.id+'">'+itemData.itemName+'</option>';

                }

            });
            input.innerHTML=inputstr;
            input3.id='remove-btn';
            input2.className='form-control relPositionPaymentValue';
            checkboxDiv.appendChild(isclosed);
            checkboxDiv.appendChild(checkboxLabel);
            cell1.appendChild(input);
            cell2.appendChild(input2);
            cell3.appendChild(input3);
            cell4.appendChild(input4);
            cell5.appendChild(input5);
            cell6.appendChild(checkboxDiv);

            tr.appendChild(cell1);
            tr.appendChild(cell2);

            tr.appendChild(cell4);
            tr.appendChild(cell5);
            tr.appendChild(cell3);
            tr.appendChild(cell6);
            return tr;

        }

        function appendRow(obj, appendedTableName){

            var tr=document.createElement('tr');
            var cell1=document.createElement('td');
            var cell2=document.createElement('td');
            var cell3=document.createElement('td');
            var cell4=document.createElement('td');
            var cell5=document.createElement('td');
            var cell6=document.createElement('td');

            var input=document.createElement('select');
            input.name='newpaymentTypeIdName[]';

            var input2=document.createElement('input');
            input2.name='newrelPositionPaymentValue[]';
            input2.style.width='80px';
            var input3=document.createElement('button');

            var inputhidden=document.createElement('input');

            var input4=document.createElement('input');
            input4.name='startDate[]';
            input4.className='form-control startDate';
            input4.type='text';
            input4.style.width='100px';


            var input5=document.createElement('input');
            input5.name='endDate[]';
            input5.className='form-control endDate';
            input5.type='text';
            input5.style.width='100px';

            var isclosed=document.createElement('input');
            isclosed.type='checkbox';
            isclosed.name='isClosed[]';
            isclosed.className='js-switch-small1 isClosed';
            isclosed.id='checkbox'+labelCount;
            var checkboxLabel=document.createElement('label');
            checkboxLabel.for='checkbox'+labelCount;
            var checkboxDiv=document.createElement('div');
            checkboxDiv.className= 'checkbox-custom checkbox-primary';

            inputhidden.type='hidden';
            inputhidden.name='isPercent[]';
            inputhidden.className='isPercent';
            input3.innerHTML='<i class="icon md-minus" aria-hidden="true"></i>';
            input3.className='btn btn-floating btn-danger btn-xs waves-effect';
            input.className='form-control newpaymentTypeIdName';
            var inputstr='<option value="0">Seçin...</option>';
            $.each(obj, function (index, itemData) {

                inputstr=inputstr+'<option value="'+itemData.id+'">'+itemData.itemName+'</option>';
            });
            input.innerHTML=inputstr;
            input3.id='remove-btn';
            input2.className='form-control';
            checkboxDiv.appendChild(isclosed);
            checkboxDiv.appendChild(checkboxLabel);
            cell1.appendChild(input);
            cell2.appendChild(input2);
            cell2.appendChild(inputhidden);

            cell4.appendChild(input4);
            cell5.appendChild(input5);
            cell3.appendChild(input3);
            cell6.appendChild(checkboxDiv);

            tr.appendChild(cell1);
            tr.appendChild(cell2);

            tr.appendChild(cell4);
            tr.appendChild(cell5);
            tr.appendChild(cell3);
            tr.appendChild(cell6);
            document.getElementById(appendedTableName).appendChild(tr);
            $(tr).find('.startDate').datepicker({format: 'yyyy-mm-dd, weekstart: 1'})

            $(tr).find('.endDate').datepicker({format: 'yyyy-mm-dd, weekstart: 1'})
        }



        $("#add-btn").click(function(){
            labelCount++;
            console.log(labelCount+"<<<");

//            console.log(paymentTypes.data);
//            console.log(selectedArr);
//            console.log(document.getElementById('paymentTable').rows.length);
//            console.log('---');

            var emptyObj=[];
            $.each(paymentTypes.data, function (index, itemData) {

                console.log($(this)[0].id);

                if(!selectedArr.exists($(this)[0].id)){

                    emptyObj.push(paymentTypes.data[index]);
                }

            });

            paymentTypes.data=emptyObj;

            if((paymentTypes.data.length+selectedArr.length)>document.getElementById('paymentTable').rows.length){

                appendRow(paymentTypes.data, 'paymentTable')
                console.log(paymentTypes.data)

            }
            else {

//                alert(paymentTypes.data.length+selectedArr.length)
            }


        });

        $('body').on('click', '#remove-btn', function () {

            $(this).parent().parent().remove();
            var val=$(this).parent().parent().find('.paymentTypeIdName').val();
            var id=$(this).parent().parent().find('.relPositionPaymentValue').attr('id');
            deletedArr.push(id);
            console.log(deletedArr);

        });

        $('body').on('change', '.newpaymentTypeIdName', function () {

            var selectedId=$(this).val();

            var that=$(this);

            paymentTypes.data.forEach(function (element, index) {

                if(paymentTypes.data[index].id==selectedId){

                    that.parent().parent().find('.isPercent').val(paymentTypes.data[index].isPercent)
                }

            })
            console.log(paymentTypes.data)

        });

        $('body').on('change', '#listPositions', function () {


            $('#salaryId').val($(this).val());

        })
        //        $('body').on('focus', '.endDate', function () {
        //
        //            $(this).datepicker({    });
        //        })


    </script>

    <script src="{{asset('core/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('core/global/js/Plugin/bootstrap-datepicker.js')}}"></script>
@endsection