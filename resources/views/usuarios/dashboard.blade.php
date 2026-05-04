@extends('layouts.app')
@section('title', 'Control de Accesos')

@section('content')
<style>
    .page-title { font-size: 24px; font-weight: 700; color: #1e3a8a; margin-bottom: 24px; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(37,99,235,0.08); }
    thead { background: #1d4ed8; }
    thead th { padding: 14px 16px; text-align: left; color: #fff; font-size: 13px; font-weight: 600; }
    tbody td { padding: 14px 16px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #e0e7ff; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    select {
        padding: 8px 12px;
        border: 1.5px solid #c7d2fe; border-radius: 6px;
        font-size: 13px; color: #1e293b; background: #f8faff;
    }
    select:focus { outline: none; border-color: #1d4ed8; }
    .btn-update {
        padding: 8px 14px; background: #1d4ed8; color: #fff;
        border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; margin-left: 8px;
    }
    .btn-update:hover { background: #1e40af; }
    .btn-del {
        padding: 8px 14px; background: #fef2f2; color: #b91c1c;
        border: 1px solid #fecaca; border-radius: 6px; font-size: 13px; cursor: pointer;
    }
    .btn-del:hover { background: #fee2e2; }
    .rol-form { display: flex; align-items: center; }
    .empty { text-align: center; color: #64748b; padding: 40px; }
    .rol-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .rol-Administrador { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .rol-Empleado      { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .rol-Repartidor    { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
    .rol-Cliente       { background: #f8faff; color: #475569; border: 1px solid #e2e8f0; }
</style>

<h1 class="page-title">Control de Accesos</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol actual</th>
            <th>Cambiar rol</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->id_usuario }}</td>
            <td>{{ $usuario->nombre }}</td>
            <td>{{ $usuario->email }}</td>
            <td>
                <span class="rol-badge rol-{{ $usuario->rol }}">{{ $usuario->rol }}</span>
            </td>
            <td>
                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="rol-form">
                    @csrf @method('PUT')
                    <select name="rol" required>
                        <option value="Cliente"        {{ $usuario->rol == 'Cliente'        ? 'selected' : '' }}>Cliente</option>
                        <option value="Empleado"       {{ $usuario->rol == 'Empleado'       ? 'selected' : '' }}>Empleado</option>
                        <option value="Repartidor"     {{ $usuario->rol == 'Repartidor'     ? 'selected' : '' }}>Repartidor</option>
                        <option value="Administrador"  {{ $usuario->rol == 'Administrador'  ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <button type="submit" class="btn-update">Guardar</button>
                </form>
            </td>
            <td>
                <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="empty">No hay usuarios registrados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
