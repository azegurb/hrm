<tr style="background-color: #ffe3a6">
    <td>{{$count}}</td>
    @php($c = count($row))
    @if($c > 0)
        @for($i = 0;$i < $c;$i++)
            {!! rowG($value,$row[$i]) !!}
        @endfor
    @endif
    @if(!empty($ccon))
        <td>
            <div class="submit-confirm"  style="display: flex">
                <button type="button" class="btn btn-sm btn-success mr-5" onclick="confirmation($(this),'true','{{$value->id}}')">Təsdiqlə</button>
                <button type="button" class="btn btn-sm btn-danger ml-5" onclick="confirmation($(this),'false','{{$value->id}}')">İmtina</button>
            </div>
        </td>
    @else
        <td></td>
    @endif
</tr>