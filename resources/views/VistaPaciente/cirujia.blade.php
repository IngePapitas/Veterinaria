@extends('Panza')

@section('Panza')
<div class=" rounded shadow-xl h-auto p-8 m-8">
<div class="bg-blue-500 font-bold text-4xl mb-4 rounded-xl shadow-inner p-4 text-white">
        Cirujias de {{$paciente->nombre}}
    </div>
    @foreach($cirujias as $cirujia)
    @php

    if(in_array($cirujia->id_estado, [1, 2])){
    $bgColor = 'bg-green-400';
    }
    elseif($cirujia->id_estado === 3){
    $bgColor = 'bg-gray-400';
    }
    elseif(in_array($cirujia->id_estado, [4, 5])){
    $bgColor = 'bg-red-400';
    }
    else{
    $bgColor = '';
    }

    @endphp
    <a href="{{ route('NotaServicio.show', $cirujia->id)}}" class="p-4 mb-4 bg-blue-100 shadow-inner rounded-xl grid grid-cols-2 transform transition-transform duration-200 hover:scale-105">
        <div class="">
            <h3 class="font-bold text-xl">{{$cirujia->servicio}}</h3>
            <h4> {{$cirujia->created_at}}</h4>
            <span> Dr. {{$cirujia->nombre}}</span>
        </div>
        <div class="flex items-center justify-end">
            <div class="rounded-xl {{$bgColor}} p-2 text-white font-bold shadow-inner">
                {{$cirujia->estado}}
            </div>
        </div>
    </a>

    @endforeach

</div>
@endsection