<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar todas las categorías
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar el formulario para crear
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guardar una categoría nueva en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre'
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    /**
     * Mostrar el formulario para editar una categoría específica
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar la categoría en la base de datos
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre,' . $id . ',id_categoria'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    /**
     * Eliminar la categoría 
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->productos()->count() > 0) {
            return back()->withErrors('Seguridad: No puedes eliminar esta categoría porque tiene productos asignados. Mueve los productos a otra categoría primero.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada con éxito.');
    }
}