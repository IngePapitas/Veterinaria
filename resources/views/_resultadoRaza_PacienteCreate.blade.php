@foreach($razas as $raza)
<tr class="border-t-2 border-gray-200"> 
    <td>
    <button id="buttonRazas{{ $raza->id }}" type="button" value="{{ $raza->nombre }}" class="px-4 - m-2">{{ $raza->nombre }}</button>
    </td>
</tr>
@endforeach


