<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|max:15|unique:productos,id_producto',
            'nombre' => 'required|max:100',
            'precio' => 'required|numeric',
            'categoria' => 'required|max:50',
            'imagen_url' => 'nullable|max:255',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'id_producto' => 'required|max:15|unique:productos,id_producto,' . $producto->id_producto . ',id_producto',
            'nombre' => 'required|max:100',
            'precio' => 'required|numeric',
            'categoria' => 'required|max:50',
            'imagen_url' => 'nullable|max:255',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}