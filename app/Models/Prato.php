<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Prato extends Model
{
    use HasFactory;

protected $fillable = [
        'nome',
        'descricao',
        'preco',      
        'category',   
        'period',     
        'imagem_url', 
        'category', // <-- Verifique se está aqui
         'period',
    ];
}