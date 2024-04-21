<!-- resources/views/categorias/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detalles de la Categoría</h2>
        <div>
            <p><strong>Nombre:</strong> {{ $categoria->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>
            <p><strong>Imagen:</strong> @if($categoria->imagen) <img src="{{ asset('storage/' . $categoria->imagen) }}" alt="Imagen de la categoría" width="100"> @else No disponible @endif</p>
        </div>
    </div>
@endsection
