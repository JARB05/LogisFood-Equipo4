@extends('layouts.app')
@section('title', 'Control de Accesos - LogisFood')

@section('content')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
    .page-title { font-size:26px; font-weight:800; color:#111827; letter-spacing:-0.4px; margin:0 0 4px; }
    .page-subtitle { font-size:13px; color:#9CA3AF; font-weight:500; margin:0; }

    .stats-row { display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:14px; margin-bottom:28px; }
    .stat-card { background:#fff; border-radius:14px; padding:16px 20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); border:1.5px solid #F3EDE4; display:flex; flex-direction:column; gap:4px; }
    .stat-label { font-size:11px; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.5px; }
    .stat-value { font-size:24px; font-weight:800; color:#111827; letter-spacing:-0.5px; }
    .stat-card.orange .stat-value { color:#FF6700; }

    .lf-table { width:100%; border-collapse:collapse; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,0.06); }
    .lf-table thead { background:#111827; }
    .lf-table thead th { padding:14px 20px; text-align:left; color:#fff; font-size:12px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; }
    .lf-table tbody td { padding:14px 20px; font-size:14px; color:#374151; border-bottom:1px solid #F3EDE4; font-weight:500; vertical-align:middle; }
    .lf-table tbody tr:last-child td { border-bottom:none; }
    .lf-table tbody tr:hover { background:#FAFAF8; transition:background 0.1s; }

    .user-id { font-size:12px; font-weight:700; color:#9CA3AF; font-family:monospace; }
    .user-name { font-weight:700; color:#111827; display:flex; align-items:center; gap:10px; }
    .user-avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#FF6700,#FF8C3A); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#fff; flex-shrink:0; }
    .user-email { font-size:13px; color:#6B7280; }

    .rol-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
    .rol-Administrador { background:#FFF7F0; color:#FF6700; border:1.5px solid #FFD4B3; }
    .rol-Empleado      { background:#F0FDF4; color:#15803D; border:1.5px solid #BBF7D0; }
    .rol-Repartidor    { background:#FFFBEB; color:#B45309; border:1.5px solid #FDE68A; }
    .rol-Cliente       { background:#F9FAFB; color:#6B7280; border:1.5px solid #E5E7EB; }

    .rol-form { display:flex; align-items:center; gap:8px; }
    .rol-select-wrap { position:relative; }
    .rol-select {
        padding:8px 34px 8px 12px; border:1.5px solid #E5E0D8; border-radius:10px;
        font-size:13px; font-weight:600; color:#374151; background:#FAFAF8;
        font-family:'Outfit',sans-serif; outline:none; appearance:none;
        transition:border-color 0.2s; cursor:pointer;
    }
    .rol-select:focus { border-color:#FF6700; box-shadow:0 0 0 3px rgba(255,103,0,0.08); }
    .rol-select-wrap svg { position:absolute; right:10px; top:50%; transform:translateY(-50%); pointer-events:none; color:#9CA3AF; }

    .btn-update { display:inline-flex; align-items:center; gap:5px; padding:8px 16px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; box-shadow:0 3px 10px rgba(255,103,0,0.22); transition:transform 0.15s, box-shadow 0.15s; white-space:nowrap; }
    .btn-update:hover { transform:translateY(-1px); box-shadow:0 5px 14px rgba(255,103,0,0.32); }
    .btn-del { display:inline-flex; align-items:center; gap:5px; padding:8px 14px; background:#FFF5F5; color:#DC2626; border:1.5px solid #FECACA; border-radius:10px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; transition:background 0.15s; }
    .btn-del:hover { background:#FEE2E2; }

    .empty td { text-align:center; color:#9CA3AF; padding:60px; font-size:15px; font-weight:500; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Control de Accesos</h1>
        <p class="page-subtitle">Gestiona los roles y permisos de los usuarios</p>
    </div>
</div>

@php
    $roles = ['Administrador','Empleado','Repartidor','Cliente'];
    $counts = collect($roles)->mapWithKeys(fn($r) => [$r => $usuarios->where('rol', $r)->count()]);
@endphp

<div class="stats-row">
    <div class="stat-card orange">
        <span class="stat-label">Total usuarios</span>
        <span class="stat-value">{{ $usuarios->count() }}</span>
    </div>
    @foreach($roles as $rol)
    <div class="stat-card">
        <span class="stat-label">{{ $rol }}s</span>
        <span class="stat-value">{{ $counts[$rol] }}</span>
    </div>
    @endforeach
</div>

<table class="lf-table">
    <thead>
        <tr>
            <th style="width:70px;">ID</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol actual</th>
            <th>Cambiar rol</th>
            <th style="width:110px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($usuarios as $usuario)
        <tr>
            <td><span class="user-id">#{{ $usuario->id_usuario }}</span></td>
            <td>
                <div class="user-name">
                    <div class="user-avatar">{{ strtoupper(substr($usuario->nombre, 0, 1)) }}</div>
                    {{ $usuario->nombre }}
                </div>
            </td>
            <td><span class="user-email">{{ $usuario->email }}</span></td>
            <td><span class="rol-badge rol-{{ $usuario->rol }}">{{ $usuario->rol }}</span></td>
            <td>
                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="rol-form">
                    @csrf @method('PUT')
                    <div class="rol-select-wrap">
                        <select name="rol" required class="rol-select">
                            <option value="Cliente"       {{ $usuario->rol == 'Cliente'       ? 'selected' : '' }}>Cliente</option>
                            <option value="Empleado"      {{ $usuario->rol == 'Empleado'      ? 'selected' : '' }}>Empleado</option>
                            <option value="Repartidor"    {{ $usuario->rol == 'Repartidor'    ? 'selected' : '' }}>Repartidor</option>
                            <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <button type="submit" class="btn-update">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar
                    </button>
                </form>
            </td>
            <td>
                <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr class="empty"><td colspan="6">No hay usuarios registrados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection