<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request; // Importante para capturar los parámetros de búsqueda (?buscar y ?categoria)

class ProductoController extends Controller
{
    // Muestra la lista de todos los productos (en formato tabla)
    public function index()
    { 
        $productos = Producto::with('categoria')->get(); 
        return view('productos.index', compact('productos'));
    } 

    // Muestra el detalle de un producto específico
    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    // Muestra la galería de productos con filtros de búsqueda y categoría (Reto Final)
    public function galeria(Request $request)
    {
        // Iniciamos la consulta base con Eager Loading para optimizar el rendimiento
        $query = Producto::with('categoria');

        // Reto 3: Barra de búsqueda por nombre (Filtro en tiempo real al procesar el formulario)
        if ($request->has('buscar') && $request->buscar != '') {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // Reto 1: Filtro por categoría mediante el menú desplegable <select>
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('id_categoria', $request->categoria);
        }

        // Obtenemos los productos ya filtrados
        $productos = $query->get();

        // Necesitamos traer todas las categorías para poder llenar el elemento <select> en la vista
        $categorias = Categoria::all();

        // Enviamos los productos y las categorías a la vista
        return view('productos.galeria', compact('productos', 'categorias'));
    }
}