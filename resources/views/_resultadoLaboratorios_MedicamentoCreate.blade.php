@foreach($laboratorios as $laboratorios)
<tr class="border-t-2 border-gray-200"> 
    <td>
        <button id="buttonLaboratorio{{ $laboratorio->id }}" type="button" value="{{ $laboratorio->nombre }}" class="px-4 - m-2">{{ $laboratorio->nombre }}</button>
    </td>
</tr>
@endforeach