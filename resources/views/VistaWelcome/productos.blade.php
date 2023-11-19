@include('nav-welcome')
<!--Prueba de la seccion de producto-->
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap -m-4">
      @foreach ($productos as $p)
      <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
        <a href="{{ route('producto.show',$p->id) }}" class="block relative h-48 rounded overflow-hidden">
          <img alt="{{ $p->nombre }}" class="object-cover object-center w-full h-full block" src="{{ asset($p->imagen) }}">
        </a>
        <div class="mt-4">
          <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $p->categoria->categoria }}</h3>
          <h2 class="text-gray-900 title-font text-lg font-medium">{{ $p->nombre }}</h2>
          <p class="mt-1">{{ $p->precio }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
<!--Pie de pagina-->
@include('footer')