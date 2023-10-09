@foreach($especies as $especie)
<tr class="border-t-2 border-gray-200"> 
    <td>
    <button id="buttonEspecie{{ $especie->id }}" type="button" value="{{ $especie->nombre }}" class="px-4 - m-2">{{ $especie->nombre }}</button>
    </td>
</tr>
@endforeach


