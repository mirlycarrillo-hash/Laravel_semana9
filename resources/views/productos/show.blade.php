{{-- resources/views/productos/show.blade.php --}}
@extends('layouts.app')

@section('titulo', $producto->nombre)

@section('contenido')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('productos.galeria') }}" class="btn btn-outline btn-sm" style="color: #b39bc8; border-color: rgba(179,155,200,0.4);">
        &larr; Volver a la Galería
    </a>
</div>

<div class="producto-card" style="background: #251625; border: 1px solid rgba(255, 142, 187, 0.2); border-radius: 16px; padding: 2rem; display: flex; gap: 2.5rem; flex-wrap: wrap; box-shadow: 0 0 25px rgba(0,0,0,0.5);">
    
    {{-- Lado Izquierdo: Imagen del Producto --}}
    <div style="flex: 0 0 320px; max-width: 100%; height: 320px; background: #1a0f1a; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255, 142, 187, 0.1);">
        @if($producto->foto && file_exists(public_path('img/productos/' . $producto->foto)))
            <img src="{{ asset('img/productos/' . $producto->foto) }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div style="color: #b39bc8; font-style: italic;">📷 Sin imagen de muestra</div>
        @endif
    </div>

    {{-- Lado Derecho: Información y Ficha Técnica --}}
    <div style="flex: 1; min-width: 280px; display: flex; flex-direction: column; justify-content: center;">
        <h1 style="color: #ff8ebb; text-shadow: 0 0 10px rgba(255,142,187,0.4); margin: 0 0 0.5rem 0; font-size: 2.5rem;">
            {{ $producto->nombre }}
        </h1>
        <p style="color: #b39bc8; font-size: 1.1rem; margin: 0 0 1.5rem 0;">
            Marca de producto: <strong style="color: #fff;">{{ $producto->marca }}</strong>
        </p>

        <div style="background: #1d111d; border-radius: 8px; padding: 1rem; border-left: 4px solid #ff8ebb; margin-bottom: 2rem;">
            <table style="width: 100%; border-collapse: collapse; color: #ffffff;">
                <tr style="border-bottom: 1px solid rgba(255,142,187,0.1);">
                    <td style="padding: 0.6rem 0; color: #b39bc8; font-weight: 600;">Precio Unitario</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ff8ebb; font-size: 1.4rem; font-weight: bold;">
                        S/. {{ number_format($producto->precio, 2) }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid rgba(255,142,187,0.1);">
                    <td style="padding: 0.6rem 0; color: #b39bc8; font-weight: 600;">Stock en Almacén</td>
                    <td style="padding: 0.6rem 0; text-align: right;">{{ $producto->stock }} unidades</td>
                </tr>
                <tr>
                    <td style="padding: 0.6rem 0; color: #b39bc8; font-weight: 600;">Categoría asignada</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ff8ebb;">
                        {{ $producto->categoria->descripcion ?? 'Sin categoría' }}
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <form action="{{ route('carrito.agregar', $producto->id_producto) }}" method="POST">
                @csrf
                <button type="submit" style="background: linear-gradient(45deg, #ff758c, #ff7eb3); color: #120714; font-weight: bold; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 15px rgba(255,142,187,0.2); transition: all 0.2s;">
                    🛒 Añadir al Carrito de Compras
                </button>
            </form>
        </div>
    </div>

</div>
@endsection