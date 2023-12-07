@extends('Panza')

@section('Panza')

<div class="container mx-auto px-4 py-8">

    <div class="mb-4">
        <a href="{{ route('NotaServicio.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Crear nota Nota de Servicio
        </a>
    </div>


    <div class=" rounded shadow-xl h-auto p-8 ">

        @foreach($servicios as $servicio)
        @php

        if(in_array($servicio->id_estado, [1, 2])){
        $bgColor = 'bg-green-400';
        }
        elseif($servicio->id_estado === 3){
        $bgColor = 'bg-gray-400';
        }
        elseif(in_array($servicio->id_estado, [4, 5])){
        $bgColor = 'bg-red-400';
        }
        else{
        $bgColor = '';
        }

        @endphp
        <a href="{{ route('NotaServicio.show', $servicio->id)}}" class="p-4 mb-4 bg-blue-100 shadow-inner rounded-xl grid grid-cols-2 transform transition-transform duration-200 hover:scale-105">
            <div class="">
                <h3 class="font-bold text-xl">{{$servicio->servicio}} - {{$servicio->tipo}}</h3>
                <span class="block"> ID: {{$servicio->id}}</span>
                <span class="block"> ID: {{$servicio->paciente}}</span>
                <h4> {{$servicio->created_at}}</h4>
                <span> Dr. {{$servicio->nombre}}</span>
                
            </div>
            <div class="flex items-center justify-end">
                <div class="rounded-xl {{$bgColor}} p-2 text-white font-bold shadow-inner">
                    {{$servicio->estado}}
                </div>
            </div>
        </a>

        @endforeach

    </div>

</div>
@endsection