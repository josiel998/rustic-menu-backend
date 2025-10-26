<?php

// Em app/Http\Controllers\Api\OrderController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // GET /api/pedidos
    public function index()
    {
        // Protegido por Sanctum, então só admin vê
        return Order::latest()->get();
    }

    // POST /api/pedidos
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',    
            'endereco' => 'required|string|max:255',
            'meio_pagamento' => 'required|string|max:255',
            'total' => 'required|numeric',
            'status' => 'required|string',
            'itens' => 'required|array'
        ]);

        $order = Order::create($data);
        return response()->json($order, 201);
    }

    // PATCH /api/pedidos/{id}
    public function update(Request $request, Order $order)
    {
        // Protegido por Sanctum. $order é injetado (Route-Model Binding)
        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $order->update($data);
        return response()->json($order);
    }

    public function showPublic(string $uuid)
    {
        // Usamos where() e firstOrFail() em vez de injeção de modelo
        // para não expor o ID primário.
        $order = Order::where('uuid', $uuid)->firstOrFail();

        // Retornamos apenas os dados que o cliente precisa ver
        return response()->json([
            'id' => $order->id,
            'cliente' => $order->cliente,
            'status' => $order->status,
            'total' => $order->total,
            'itens' => $order->itens,
        ]);
    }
}