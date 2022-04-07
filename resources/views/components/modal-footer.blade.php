</div>
    <div class="modal-footer pt-10 pb-10 mt-5" style="background: #e8e8e8">
        <button type="button" class="btn close-modal-s text-black btn-{{$mdlClassBtnCancel or 'default'}}">{{$mdlTextBtnCancel or 'İmtina'}}</button>
        <button type="submit" class="btn btn-{{$mdlClassBtnSuccess or 'success'}}">{{$mdlTextBtnSuccess or 'Təsdiq'}}</button>
        {!! $custom or '' !!}

        {{$ids or ''}}
    </div>
</form>
</div>
</div>
</div>