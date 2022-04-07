<div class="panel-bordered">
    <div class="panel-heading col-lg-12 float-left pb-20">
        <div class="col-md-7 float-left mb-10">
            <h4>Ad Soyad Ata adı:</h4>
            <input type="text" class="form-control " id="inputHelpText" name="input_name" disabled value="Nicat Əmiraslanov">
        </div>
        <div class="col-md-5 float-left mb-10">
            <h4>Vəzifəsi:</h4>
            <input type="text" class="form-control" id="inputHelpText" name="input_position" disabled value="Baş məsləhətçi">
        </div>
    </div>

    <div class="panel-body float-left">
        @php($no = 1)
        @foreach($data->data->sending as $key=>$single_data)

        <div class="col-md-2 float-left mt-15">
            <label name="asdf" id="l1" class="mb-0 mt-5" for=""><h4>{{$single_data['label']}}</h4></label>
            <input type="number" class="form-control" id="i1" name="n{{$no++}}" {{ $single_data['disabled'] ? 'disabled' : ''  }} value="{{$single_data['value']}}">
        </div>

        @endforeach
    </div>
</div>