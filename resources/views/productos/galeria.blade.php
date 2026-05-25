{{-- resources/views/productos/galeria.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Galería de Productos')

@section('contenido')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <h1 style="color: #ff8ebb; text-shadow: 0 0 10px rgba(255,142,187,0.5); margin:0; font-size: 2.2rem;">
        Galería de Productos
        <span style="font-size:1.1rem; font-weight:normal; color: #b39bc8; display: block; margin-top: 0.3rem;">
            ({{ $productos->count() }} artículos disponibles)
        </span>
    </h1>
    <a href="{{ route('productos.index') }}" class="btn btn-outline btn-sm" style="border-color: #ff8ebb; color: #ff8ebb; text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem;">
        Ver como Tabla
    </a>
</div>

<form action="{{ route('productos.galeria') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; background: #251625; padding: 1.2rem; border-radius: 16px; border: 1px solid rgba(255, 142, 187, 0.15); margin-bottom: 2rem;">
    
    <div style="flex: 1; min-width: 250px;">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="🔍 Buscar producto por nombre..." style="width: 100%; padding: 0.6rem 1rem; background: #1a0f1a; border: 1px solid rgba(255,142,187,0.3); border-radius: 8px; color: #fff; outline: none; font-size: 0.95rem;">
    </div>

    <div style="min-width: 220px;">
        <select name="categoria" onchange="this.form.submit()" style="width: 100%; padding: 0.6rem 1rem; background: #1a0f1a; border: 1px solid rgba(255,142,187,0.3); border-radius: 8px; color: #fff; outline: none; cursor: pointer; font-size: 0.95rem;">
            <option value="">📁 Todas las categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id_categoria }}" {{ request('categoria') == $cat->id_categoria ? 'selected' : '' }}>
                    {{ $cat->descripcion }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" style="background: #b39bc8; color: #120714; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 0.95rem;">
            Buscar
        </button>
        @if(request('buscar') || request('categoria'))
            <a href="{{ route('productos.galeria') }}" style="background: rgba(255,255,255,0.1); color: #fff; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem;">
                Limpiar
            </a>
        @endif
    </div>
</form>

@if($productos->isEmpty())
    <div class="alert alert-info" style="background-color: #2c1b30; border-color: #ff8ebb; color: #ff8ebb; padding: 2rem; border-radius: 12px; text-align: center;">
        🔍 No se encontraron productos que coincidan con los filtros aplicados.
    </div>
@else
    <style>
        .galeria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            padding-bottom: 3rem;
        }
        .producto-card {
            background: #251625;
            border: 1px solid rgba(255, 142, 187, 0.15);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            position: relative;
        }
        .producto-card:hover {
            transform: translateY(-5px);
            border-color: #ff8ebb;
            box-shadow: 0 0 20px rgba(255, 142, 187, 0.4);
        }
        .img-contenedor {
            width: 100%;
            height: 220px;
            background-color: #1a0f1a;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 142, 187, 0.1);
        }
        .img-contenedor img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .no-foto {
            color: #b39bc8;
            font-style: italic;
            font-size: 0.95rem;
        }
        .card-body {
            padding: 1.25rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .card-body h3 {
            color: #ffffff;
            margin: 0;
            font-size: 1.3rem;
        }
        .marca {
            color: #b39bc8;
            font-size: 0.9rem;
            margin: 0;
        }
        .precio {
            color: #ff8ebb;
            font-size: 1.4rem;
            font-weight: bold;
            margin: 0.5rem 0 0 0;
            text-shadow: 0 0 5px rgba(255,142,187,0.3);
        }
        .card-footer {
            padding: 1rem 1.25rem;
            background: #1d111d;
            border-top: 1px solid rgba(255, 142, 187, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .badge-stock {
            padding: 0.25rem 0.6rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .stock-ok { background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid #28a745; }
        .stock-warn { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid #ffc107; }
        .stock-low { background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid #dc3545; }
        .stock-none { background: rgba(220, 53, 69, 0.5); color: #ffffff; border: 1px solid #dc3545; }
        
        .btn-rosa {
            background: linear-gradient(45deg, #ff758c, #ff7eb3);
            color: #120714;
            font-weight: bold;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-rosa:hover {
            box-shadow: 0 0 10px #ff8ebb;
            transform: scale(1.03);
        }
        .btn-deshabilitado {
            background: #4a3b4a;
            color: #887a88;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            cursor: not-allowed;
            font-weight: bold;
        }
    </style>

    <div class="galeria-grid">
        @foreach($productos as $producto)
        <div class="producto-card">
            
            @if($producto->stock == 0)
                <div style="position: absolute; top: 12px; right: 12px; background: #dc3545; color: #fff; padding: 0.3rem 0.7rem; font-size: 0.75rem; font-weight: bold; border-radius: 20px; box-shadow: 0 0 8px rgba(220,53,69,0.6); z-index: 5;">
                    🛑 AGOTADO
                </div>
            @endif

            {{-- Imagen del producto --}}
            <div class="img-contenedor">
                @if($producto->foto && file_exists(public_path('img/productos/' . $producto->foto)))
                    <img src="{{ asset('img/productos/' . $producto->foto) }}" alt="{{ $producto->nombre }}" style="{{ $producto->stock == 0 ? 'opacity: 0.35; filter: grayscale(1);' : '' }}">
                @else
                    <div class="no-foto">📷 Sin imagen</div>
                @endif
            </div>

            <div class="card-body">
                <h3>{{ $producto->nombre }}</h3>
                <p class="marca">Marca: {{ $producto->marca }}</p>
                
                <div>
                    @if($producto->stock > 20)
                        <span class="badge-stock stock-ok">Stock: {{ $producto->stock }}</span>
                    @elseif($producto->stock > 5)
                        <span class="badge-stock stock-warn">Stock: {{ $producto->stock }}</span>
                    @elseif($producto->stock > 0)
                        <span class="badge-stock stock-low">¡Bajo Stock! ({{ $producto->stock }})</span>
                    @else
                        <span class="badge-stock stock-none">Agotado</span>
                    @endif
                </div>

                <p class="precio">S/. {{ number_format($producto->precio, 2) }}</p>
            </div>

            <div class="card-footer">
                <a href="{{ route('productos.show', $producto->id_producto) }}" class="btn btn-outline btn-sm" style="color: #b39bc8; border-color: rgba(179,155,200,0.4); text-decoration: none; padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.85rem;">
                    Detalles
                </a>

                @if($producto->stock == 0)
                    <button class="btn-deshabilitado" disabled>Sin Stock</button>
                @else
                    <form action="{{ route('carrito.agregar', $producto->id_producto) }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-rosa">+ Carrito</button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection