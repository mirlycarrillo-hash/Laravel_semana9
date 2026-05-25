<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    // Muestra el contenido del carrito
    public function index()
    {
        $carrito   = session('carrito', []);
        $productos = [];
        $total     = 0;

        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto) {
                $subtotal    = $producto->precio * $cantidad;
                $total      += $subtotal;
                $productos[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('carrito.index', compact('productos', 'total'));
    }

    // Agrega un producto al carrito (o incrementa su cantidad)
    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);
        $carrito  = session('carrito', []);

        if (isset($carrito[$id])) {
            // Si ya existe, incrementa la cantidad comprobando el stock
            if ($carrito[$id] < $producto->stock) {
                $carrito[$id]++;
            } else {
                return back()->with('error', 'No hay más stock disponible de ' . $producto->nombre);
            }
        } else {
            // Primera vez: agrega con cantidad 1
            $carrito[$id] = 1;
        }

        session(['carrito' => $carrito]);
        return back()->with('success', $producto->nombre . ' agregado al carrito.');
    }

    // Quita una unidad de un producto (o lo elimina si se presiona Eliminar o queda en 0)
    public function quitar($id)
    {
        $carrito = session('carrito', []);

        if (isset($carrito[$id])) {
            // Condición extra por si se presiona el botón "Eliminar" directo de tu vista
            if (request()->has('eliminar_completo') || $carrito[$id] <= 1) {
                unset($carrito[$id]);
            } else {
                $carrito[$id]--;
            }
        }

        session(['carrito' => $carrito]);
        return back()->with('info', 'Producto actualizado en el carrito.');
    }

    // Vacía completamente el carrito
    public function vaciar()
    {
        session()->forget('carrito');
        return back()->with('info', 'El carrito ha sido vaciado.');
    }

    // ==========================================================================
    // 🚀 RETO FINAL: CONFIRMACIÓN DE COMPRA Y EMISIÓN DE COMPROBANTE (RETO 4)
    // ==========================================================================
    public function confirmar()
    {
        $carrito = session('carrito', []);
        
        // Si el usuario intenta entrar directo por URL sin tener items, lo devolvemos
        if (empty($carrito)) {
            return redirect()->route('productos.galeria')->with('error', 'El carrito está vacío.');
        }

        $total = 0;
        
        // Calculamos el total antes de limpiar la sesión para mandarlo a la vista
        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto) {
                $total += $producto->precio * $cantidad;
            }
        }

        // Limpiamos la sesión del carrito simulando que la compra ya fue pagada con éxito
        session()->forget('carrito');

        // Retornamos la vista de confirmación neón inyectándole el monto acumulado
        return view('carrito.confirmacion', compact('total'));
    }
}