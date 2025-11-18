<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    use HasFactory;

    // Define o nome da tabela que vamos criar
    protected $table = 'delivery_zones';

    // Define os campos que podemos preencher
    protected $fillable = [
        'cidade',
        'bairro',
        'taxa',
    ];
}