@extends('layouts.app')

@section('title', 'Dashboard de Usuarios — LogisFood')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Control de Accesos</h1>
    <p class="text-sm text-gray-500 mt-1">Administra los roles de todos los usuarios registrados en el sistema.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 bg-blue-50 flex items-center justify-between">
        <div class="flex items-center gap-2 text-blue-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-sm font-semibold">{{ $usuarios->count() ?? 0 }} usuarios registrados</span>
        </div>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                <th class="px-5 py-3 text-left">ID</th>
                <th class="px-5 py-3 text-left">Nombre</th>
                <th class="px-5 py-3 text-left">Email</th>
                {{--
                    SELECTOR DE ROL:
                    El admin puede cambiar el rol a Empleado o Repartidor desde aquí.
                    Las opciones disponibles son: Cliente, Empleado, Repartidor, Administrador.
                --}}
                <th class="px-5 py-3 text-left">Rol</th>
                <th class="px-5 py-3 text-left">Eliminar</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($usuarios as $usuario)
            <tr class="hover:bg-blue-50/30 transition">
                <td class="px-5 py-3 text-gray-400 font-mono text-xs">{{ $usuario->id_usuario }}</td>
                <td class="px-5 py-3 font-semibold text-gray-800">{{ $usuario->nombre }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $usuario->email }}</td>
                <td class="px-5 py-3">
                    <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST"
                          class="flex items-center gap-2">
                        @csrf @method('PUT')
                        <select name="rol" required
                                class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                            <option value="Cliente"        {{ $usuario->rol == 'Cliente'        ? 'selected' : '' }}>Cliente</option>
                            <option value="Empleado"       {{ $usuario->rol == 'Empleado'       ? 'selected' : '' }}>Empleado</option>
                            <option value="Repartidor"     {{ $usuario->rol == 'Repartidor'     ? 'selected' : '' }}>Repartidor</option>
                            <option value="Administrador"  {{ $usuario->rol == 'Administrador'  ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                            Guardar
                        </button>
                    </form>
                </td>
                <td class="px-5 py-3">
                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar al usuario {{ $usuario->nombre }}? Esta acción no se puede deshacer.');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-xs font-semibold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-10 text-center text-gray-400">No hay usuarios registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
