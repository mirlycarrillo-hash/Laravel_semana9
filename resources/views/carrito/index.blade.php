{{-- resources/views/carrito/index.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Mi Carrito')

@section('contenido')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem">
    <h1 style="color:#ff8ebb; text-shadow: 0 0 10px rgba(255,142,187,0.4); margin:0;">Mi Carrito de Compras</h1>
    <a href="{{ route('productos.galeria') }}" class="btn btn-outline btn-sm" style="color: #b39bc8; border-color: rgba(179,155,200,0.4); text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.9rem;">
        &larr; Seguir comprando
    </a>
</div>

@if(empty($productos))
    <div class="card" style="background: #251625; border: 1px solid rgba(255,142,187,0.15); text-align:center; padding:3rem; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.4);">
        <p style="font-size:1.2rem; color:#b39bc8; margin-bottom:1.5rem">
            Tu carrito está vacío. ¡Dale un vistazo a nuestras ofertas!
        </p>
        <a href="{{ route('productos.galeria') }}" class="btn" style="background: linear-gradient(45deg, #ff758c, #ff7eb3); color: #120714; font-weight: bold; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none;">
            Ver galería de productos
        </a>
    </div>
@else
    <div class="card" style="background: #251625; border: 1px solid rgba(255,142,187,0.15); border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.4);">
        <table style="width:100%; border-collapse: collapse; color:#ffffff;">
            <thead>
                <tr style="border-bottom: 2px solid rgba(255,142,187,0.2); color: #b39bc8; text-align: left;">
                    <th style="width:80px; padding: 0.75rem 0.5rem;">Imagen</th>
                    <th style="padding: 0.75rem 0.5rem;">Producto</th>
                    <th style="padding: 0.75rem 0.5rem;">Precio Unit.</th>
                    <th style="padding: 0.75rem 0.5rem; text-align: center;">Cantidad</th>
                    <th style="padding: 0.75rem 0.5rem;">Subtotal</th>
                    <th style="padding: 0.75rem 0.5rem; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $item)
                <tr style="border-bottom: 1px solid rgba(255,142,187,0.1);">
                    <td style="padding: 1rem 0.5rem;">
                        @if($item['producto']->foto && file_exists(public_path('img/productos/' . $item['producto']->foto)))
                            <img src="{{ asset('img/productos/' . $item['producto']->foto) }}" style="width:60px; height:60px; object-fit:cover; border-radius:8px; border: 1px solid rgba(255,142,187,0.2);">
                        @else
                            <div style="width:60px; height:60px; background:#1a0f1a; border-radius:8px; display: flex; align-items: center; justify-content: center; color: #b39bc8; font-size: 0.8rem;">📷</div>
                        @endif
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        <strong style="color: #fff; font-size: 1.05rem;">{{ $item['producto']->nombre }}</strong><br>
                        <span style="color:#b39bc8; font-size:.85rem">{{ $item['producto']->marca }}</span>
                    </td>
                    <td style="padding: 1rem 0.5rem; color: #ffffff;">S/. {{ number_format($item['producto']->precio, 2) }}</td>
                    <td style="padding: 1rem 0.5rem;">
                        <div style="display:flex; align-items:center; justify-content: center; gap:.6rem">
                            <form action="{{ route('carrito.quitar', $item['producto']->id_producto) }}" method="POST" style="margin:0;">
                                @csrf
                                <button class="btn btn-sm" style="background-color: #dc3545; color: white; border: none; border-radius: 4px; font-weight: bold; width: 25px; height: 25px; cursor: pointer;">-</button>
                            </form>
                            <strong style="font-size: 1.1rem; min-width: 20px; text-align: center;">{{ $item['cantidad'] }}</strong>
                            <form action="{{ route('carrito.agregar', $item['producto']->id_producto) }}" method="POST" style="margin:0;">
                                @csrf
                                <button class="btn btn-sm" style="background-color: #28a745; color: white; border: none; border-radius: 4px; font-weight: bold; width: 25px; height: 25px; cursor: pointer;">+</button>
                            </form>
                        </div>
                    </td>
                    <td style="padding: 1rem 0.5rem; color: #ff8ebb; font-weight: bold;">S/. {{ number_format($item['subtotal'], 2) }}</td>
                    <td style="padding: 1rem 0.5rem; text-align: center;">
                        <form action="{{ route('carrito.quitar', $item['producto']->id_producto) }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="eliminar_completo" value="1">
                            <button class="btn btn-danger btn-sm" style="background: transparent; border: 1px solid #dc3545; color: #dc3545; padding: 0.3rem 0.6rem; border-radius: 6px; cursor: pointer;" onclick="return confirm('¿Quitar este producto del carrito?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Resumen y acciones finales --}}
        <div style="display:flex; justify-content:flex-end; margin-top:2rem; gap:1.5rem; align-items:center; flex-wrap: wrap;">
            <form action="{{ route('carrito.vaciar') }}" method="POST" style="margin:0;">
                @csrf
                <button class="btn btn-outline" style="color: #b39bc8; border-color: rgba(179,155,200,0.4); background: transparent; padding: 0.7rem 1.2rem; border-radius: 8px; cursor: pointer;">
                    Vaciar carrito
                </button>
            </form>

            <div style="font-size:1.4rem; font-weight:700; color:#ff8ebb; text-shadow: 0 0 5px rgba(255,142,187,0.3);">
                Total General: S/. {{ number_format($total, 2) }}
            </div>

            <a href="{{ route('carrito.confirmar') }}" class="btn" style="background: linear-gradient(45deg, #ff758c, #ff7eb3); color: #120714; font-weight: bold; padding: 0.7rem 1.5rem; border-radius: 8px; text-decoration: none; font-size: 1rem; cursor: pointer; box-shadow: 0 0 12px rgba(255,142,187,0.3); display: inline-block; text-align: center;">
                Proceder al pago &rarr;
            </a>
        </div>
    </div>
@endif
@endsection