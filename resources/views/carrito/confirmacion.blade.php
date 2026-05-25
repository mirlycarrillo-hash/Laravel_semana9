{{-- resources/views/carrito/confirmacion.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Pedido Confirmado')

@section('contenido')
<div class="card" style="background: #251625; border: 1px solid rgba(40, 167, 69, 0.3); border-radius: 16px; padding: 3rem; text-align: center; max-width: 650px; margin: 2rem auto; box-shadow: 0 4px 25px rgba(0,0,0,0.5);">
    
    <div style="font-size: 4rem; margin-bottom: 1rem;">🎉</div>
    
    <h1 style="color: #a2e8b4; text-shadow: 0 0 10px rgba(40,167,69,0.3); margin: 0 0 1rem 0;">
        ¡Pedido Confirmado Exitosamente!
    </h1>
    
    <p style="color: #b39bc8; font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;">
        Muchas gracias por tu compra. Tu orden ha sido procesada de manera correcta en nuestra plataforma virtual.
    </p>

    <div style="background: #1d111d; border-radius: 12px; padding: 1.5rem; text-align: left; border: 1px solid rgba(255, 142, 187, 0.1); margin-bottom: 2.5rem; color: #fff;">
        <h3 style="color: #ff8ebb; margin-top: 0; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,142,187,0.1); padding-bottom: 0.5rem;">Detalles del Comprobante</h3>
        <p style="margin: 0.5rem 0;">👤 <strong>Cliente:</strong> {{ Auth::user()->name }}</p>
        <p style="margin: 0.5rem 0;">📅 <strong>Fecha de Registro:</strong> {{ now()->format('d/m/Y h:i A') }}</p>
        <p style="margin: 0.5rem 0;">💰 <strong>Monto Abonado:</strong> <span style="color: #ff8ebb; font-weight: bold;">S/. {{ number_format($total, 2) }}</span></p>
        <p style="margin: 0.5rem 0; color: #28a745;">✓ <strong>Estado del Pago:</strong> Aprobado electrónicamente</p>
    </div>

    <a href="{{ route('productos.galeria') }}" class="btn" style="background: linear-gradient(45deg, #ff758c, #ff7eb3); color: #120714; font-weight: bold; padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 15px rgba(255,142,187,0.2);">
        Regresar a la Tienda
    </a>
</div>
@endsection