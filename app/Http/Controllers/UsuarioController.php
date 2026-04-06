<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos a todos los usuarios de la base de datos
        $usuarios = Usuario::all(); 
        
        // Los mandamos a una vista que llamaremos 'dashboard'
        return view('usuarios.dashboard', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validamos por seguridad que no inyecten un rol que no existe en el ENUM
        $request->validate([
            'rol' => 'required|in:Cliente,Administrador,Repartidor,Empleado'
        ]);

        // Buscamos al usuario por su ID
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();
        
        // Actualizamos únicamente su campo rol y guardamos
        $usuario->rol = $request->rol;
        $usuario->save();

        // Redirigimos a la misma página del dashboard con un mensaje verde de éxito
        return back()->with('mensaje', 'El rol de ' . $usuario->nombre . ' se actualizó correctamente a ' . $request->rol . '.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscamos al usuario
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();
        
        // Guardamos su nombre temporalmente para mostrarlo en la alerta
        $nombre = $usuario->nombre;
        
        // Lo eliminamos de la base de datos MySQL
        $usuario->delete();

        // Redirigimos con el mensaje
        return back()->with('mensaje', 'El usuario ' . $nombre . ' ha sido eliminado del sistema.');
    }
}
