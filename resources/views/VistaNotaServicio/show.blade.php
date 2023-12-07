@extends('Panza')

@section('Panza')
<style>
</style>
<div class="p-8 border-b-2 bg-gray-100">
    <div class="bg-blue-500 font-bold text-4xl mb-4 rounded-xl shadow-inner p-4 text-white">
        Detalles de Servicio
    </div>
    <div class="rounded-xl shadow-inner bg-gray-200 p-4 mb-4">
        <h2 class="">Fecha: {{$encabezado->created_at}}</h2>
        <h2 class="">Encargado: Dr. {{$encabezado->personal}}</h2>
        <h2 class="">Paciente: {{$encabezado->paciente}}</h2>
        <h2 class="">Estado del paciente: {{$encabezado->estado}}</h2>
        <h2 class="font-bold text-lg"> {{$servicioRealizado->servicio}} - {{$servicioRealizado->tipo}}</h2>
    </div>
    <div class="rounded-xl shadow-inner bg-gray-200 p-4 ">
        Descripcion: {{$encabezado->descripcion}}
    </div>
</div>
<div class="grid grid-cols-3 gap-2 w-full">
    <div class="col-span-2 h-auto p-8 border-r-2">
        <div class="font-bold text-xl mb-4 rounded-xl shadow-inner p-2 text-center text-white bg-blue-500">
            Multimedia
        </div>
        
        <div class="grid grid-cols-3 gap-2">
        @foreach($notasImagenes as $notaImagen)
        <div>
            <img src="{{ Storage::url($notaImagen->path_archivo) }}" alt="{{ $notaImagen->descripcion }}" class="h-40 w-40">
            <span class="text-sm">
                {{ $notaImagen->descripcion }}
            </span>
            
        </div>
        @endforeach
        </div>
        
        @if(count($notasImagenes) < 1)
            <div class="text-center">No hay imagenes registradas en este servicio.</div>
        @endif
    </div>
    <div class="py-8">
        <div class="font-bold text-xl mb-4 rounded-xl  p-2 text-center text-white bg-blue-500">
            Documentos
        </div>
        @foreach($notasDocumentos as $notaDocumento)
        <a href="{{ Storage::url($notaDocumento->path_archivo) }}" download class="rounded-xl block bg-red-500 w-full text-white p-2 px-4 mb-2">
            <i class="fa-solid fa-file-pdf mr-2"></i>
            {{ $notaDocumento->descripcion }}
        </a>

        @endforeach
        @if(count($notasDocumentos) < 1)
            <div class="text-center text-sm">No hay documentos registrados en este servicio.</div>
        @endif
    </div>

</div>
<div class="bg-gray-200 rounded-xl p-8 w-full">
    <div class="bg-gray-600 rounded-xl shadow-lg p-2 text-center text-white text-xl">
        Historial de Servicios
    </div>
    @foreach($historial as $historia)
    @php
    if ($historia->id == $encabezado->id) {
    $bg_color = 'bg-blue-500';
    $text_color = 'text-white';
    } else {
    $bg_color = 'bg-white';
    $text_color = '';
    }
    @endphp

    <a href="{{route('NotaServicio.show', $historia->id)}}" class="{{$bg_color}} {{$text_color}} shadow-xl rounded-xl p-2 mt-2 text-center block hover:scale-105 transform transition-transform duration-200">
        {{$historia->created_at}}-{{$historia->servicio}} - {{$historia->tipo}}
    </a>

    @endforeach
</div>

@endsection