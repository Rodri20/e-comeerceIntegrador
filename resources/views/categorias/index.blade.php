<!-- resources/views/categorias/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Listado de Categorías</h2>
        <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Crear Categoría</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion }}</td>
                        <td>
                            @if($categoria->imagen)
                                <img src="{{ asset('storage/' . $categoria->imagen) }}" alt="Imagen de la categoría" width="50">
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
