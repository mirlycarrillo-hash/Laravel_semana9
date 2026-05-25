{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')

@auth
    <div class="alert alert-success" style="background-color: rgba(40, 167, 69, 0.12); border: 1px solid #28a745; color: #a2e8b4; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; box-shadow: 0 0 10px rgba(40,167,69,0.2);">
        ¡Hola, <strong style="color: #ffffff;">{{ Auth::user()->name }}</strong>! Has iniciado sesión correctamente. Tienes acceso completo al sistema.
    </div>
@endauth

<div class="card" style="background: #251625; border: 1px solid rgba(255, 142, 187, 0.15); border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
    
    <h2 style="color:#ff8ebb; text-shadow: 0 0 12px rgba(255,142,187,0.4); margin: 0 0 0.5rem 0; font-size: 2.2rem;">
        Bienvenido al Administrador de Productos
    </h2>
    
    <p style="color:#b39bc8; margin-bottom: 2.5rem; font-size: 1.1rem;">
        Gestiona tus categorías, productos y catálogo virtual desde un solo lugar.
    </p>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; max-width: 600px; margin: 0 auto 2.5rem auto;">
        
        <div style="background: #1d111d; border: 1px solid rgba(179,155,200,0.2); border-top: 4px solid #b39bc8; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 3rem; font-weight: 700; color: #ffffff; text-shadow: 0 0 8px rgba(255,255,255,0.15);">
                {{ $totalCategorias }}
            </div>
            <div style="margin-top: .4rem; color: #b39bc8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                Categorías
            </div>
        </div>

        <div style="background: #1d111d; border: 1px solid rgba(255,142,187,0.2); border-top: 4px solid #ff8ebb; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 3rem; font-weight: 700; color: #ff8ebb; text-shadow: 0 0 10px rgba(255,142,187,0.3);">
                {{ $totalProductos }}
            </div>
            <div style="margin-top: .4rem; color: #ff8ebb; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                Productos
            </div>
        </div>

    </div>

    <hr style="border: 0; border-top: 1px solid rgba(255, 142, 187, 0.1); margin-bottom: 2rem;">

    <div style="display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('productos.galeria') }}" class="btn" style="background: linear-gradient(45deg, #ff758c, #ff7eb3); color: #120714; font-weight: bold; padding: 0.75rem 1.8rem; border-radius: 8px; text-decoration: none; font-size: 1.05rem; box-shadow: 0 0 12px rgba(255,142,187,0.4); transition: all 0.2s;">
            🛒 Ver Galería de Ventas
        </a>
        
        <a href="{{ route('categorias.index') }}" class="btn btn-outline" style="color: #b39bc8; border: 1px solid rgba(179,155,200,0.4); padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; transition: all 0.2s;">
            📁 Mantenedor de Categorías
        </a>