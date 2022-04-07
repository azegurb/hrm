{{-- Select2 --}}

{{--Link--}}
<form id="shiftAdder">
    <div class="col-md-6 float-left">
        <h4 style="font-size: 15px;">Növbə</h4>
        <div class="input-group">
            <select class="form-control select" id="getShift" data-url="{{route('shift.get')}}" name="shift"></select>
        </div>
        <div class="col-md-12 mt-20 periodic-shift-selector" style="display: none">
            <div class="col-md-6 pl-0 float-left">
                <h4>İş günü</h4>
                <div class="workDay">

                </div>
            </div>
            <div class="col-md-6 pr-0 float-left">
                <h4>Istirahət günü</h4>
                <div class="restDay">

                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary float-left mt-30"> Təsdiq </button>
</form>

@push('scripts')
<script src="{{asset('js/custom/pages/work-graphics/shift-connector.js')}}"></script>
<script>$('#getShift').selectObj('getShift',false);</script>
@endpush