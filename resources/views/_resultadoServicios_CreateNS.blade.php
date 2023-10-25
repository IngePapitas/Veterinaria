@foreach($servicios as $servicio)
<tr class="border-t-2 border-gray-200"> 
    <td>
    <button id="buttonServicio{{ $servicio->id }}" type="button" value="{{ $servicio->descripcion }}" class="px-4 - m-2">{{ $servicio->descripcion }}</button>
    </td>
</tr>
@endforeach