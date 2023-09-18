@foreach($especialidades as $especialidad)
<tr class="border-t-2 border-gray-200"> 
    <td>
    <button id="buttonEspecialidad{{ $especialidad->id }}" type="button" value="{{ $especialidad->descripcion }}" class="px-4 - m-2">{{ $especialidad->descripcion }}</button>
    </td>
</tr>
@endforeach


