<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::pluck('nombre', 'id');
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            $imagen->storeAs('public/imagenes', $nombreImagen);
            
            Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'imagen' => 'imagenes/' . $nombreImagen,
                'categoria_id' => $request->categoria_id,
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::pluck('nombre', 'id');
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        
        $producto = Producto::findOrFail($id);
        
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            $imagen->storeAs('public/imagenes', $nombreImagen);
            
            if ($producto->imagen) {
                Storage::delete('public/' . $producto->imagen);
            }
            
            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'imagen' => 'imagenes/' . $nombreImagen,
                'categoria_id' => $request->categoria_id,
            ]);
        } else {
            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'categoria_id' => $request->categoria_id,
            ]);
        }
        
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        if ($producto->imagen) {
            Storage::delete('public/' . $producto->imagen);
        }
        
        $producto->delete();
        
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }
}
