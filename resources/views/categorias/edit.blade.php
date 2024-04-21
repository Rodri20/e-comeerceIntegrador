<!-- resources/views/categorias/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Categoría</h2>
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $categoria->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion">{{ $categoria->descripcion }}</textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <img src="{{ asset('storage/' . $categoria->imagen) }}" alt="Imagen de la categoría" width="100"><br>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
