<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validación para el campo de imagen
        ]);
    
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            // Mover la imagen al directorio de almacenamiento deseado
            $imagen->storeAs('public/imagenes', $nombreImagen);
            
            // Agregar aquí la lógica para crear la categoría con la ruta de la imagen
            Categoria::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'imagen' => 'imagenes/' . $nombreImagen, // Guardar la ruta de la imagen en la base de datos
            ]);
        }
    
        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente');
    }
    

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validación para el campo de imagen
        ]);
    
        $categoria = Categoria::findOrFail($id);
    
        // Si se proporciona una nueva imagen, almacenarla y actualizar la ruta en la base de datos
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            // Mover la imagen al directorio de almacenamiento deseado
            $imagen->storeAs('public/imagenes', $nombreImagen);
            
            // Eliminar la imagen anterior si existe
            if ($categoria->imagen) {
                Storage::delete('public/' . $categoria->imagen);
            }
            
            // Actualizar la ruta de la imagen en la base de datos
            $categoria->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'imagen' => 'imagenes/' . $nombreImagen,
            ]);
        } else {
            // Si no se proporciona una nueva imagen, actualizar solo los otros campos
            $categoria->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);
        }
    
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente');
    }
    

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente');
    }
}
