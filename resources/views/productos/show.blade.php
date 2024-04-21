@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detalles del Producto</h2>
        <div>
            <strong>Nombre:</strong> {{ $producto->nombre }} <br>
            <strong>Descripción:</strong> {{ $producto->descripcion }} <br>
            <strong>Precio:</strong> {{ $producto->precio }} <br>
            <strong>Imagen:</strong> 
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto" width="200">
            @else
                No disponible
            @endif
            <br>
            <strong>Categoría:</strong> {{ $producto->categoria->nombre }} <br>
        </div>
    </div>
@endsection
