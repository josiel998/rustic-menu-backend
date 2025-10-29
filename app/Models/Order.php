<?php

// Em app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
   use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'cliente',
        'telefone', 
        'endereco',
        'meio_pagamento',
        'total',
        'status',
        'itens',
        'uuid',
    ];

    // Converte o JSON da DB para array e vice-versa
    protected $casts = [
        'itens' => 'array',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
