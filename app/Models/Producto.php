<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $primaryKey = 'id_producto';

    // Se añade 'foto' al fillable para permitir la asignación masiva
    protected $fillable = ['nombre', 'marca', 'precio', 'stock', 'id_categoria', 'foto'];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(
            'App\Models\Categoria',
            'id_categoria',
            'id_categoria'
        );
    }
}