@foreach($medicamentos as $medicamento)
<tr class="border-t-2 border-gray-200"> 
    <td>
    <button id="buscarAlergia{{ $medicamento->id }}" type="button" value="{{ $medicamento->nombre }}" class="px-4 - m-2">{{ $medicamento->nombre }}</button>
    </td>
</tr>
@endforeach