<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /*Mostrar todos los productos (Read)*/
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('productos.index', compact('productos'));
    }

    /*Mostrar formulario de creación (Manda datos al Frontend)*/
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /* Guardar el nuevo producto en la BD (Create)*/
    public function store(Request $request)
    {
        // Validación de seguridad
        $request->validate([
            'id_producto' => 'required|string|max:15|unique:productos',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen_url' => 'nullable|url|max:255'
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index');
    }

    /*Mostrar formulario de edición (Manda el producto exacto al Frontend)*/
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /*Actualizar el producto en la BD (Update)*/
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen_url' => 'nullable|url|max:255'
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index');
    }

    /*Eliminar el producto de la BD (Delete)*/
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index');
    }
}