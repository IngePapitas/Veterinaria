@foreach($categoriamedicamentos as $categoriamedicamento)
<tr class="border-t-2 border-gray-200"> 
    <td>
        <button id="buttonCategoriaMedicamento{{ $categoriamedicamento->id }}" type="button" value="{{ $categoriamedicamento->nombre }}" class="px-4 - m-2">{{ $categoriamedicamento->nombre }}</button>
    </td>
</tr>
@endforeach