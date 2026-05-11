<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Le indicamos que la tabla se llama 'categorias'
    protected $table = 'categorias';

    // Definimos tu llave primaria personalizada
    protected $primaryKey = 'id_categoria';

    // Campos que permitiremos llenar masivamente
    protected $fillable = ['descripcion'];

    /**
     * Relación: Una categoría tiene muchos productos
     */
    public function productos()
    {
        return $this->hasMany(
            'App\Models\Producto',
            'id_categoria', // Llave foránea en la tabla productos
            'id_categoria'  // Llave local en la tabla categorias
        );
    }
}