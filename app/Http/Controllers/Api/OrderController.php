<?php

// Em app/Http\Controllers\Api\OrderController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // GET /api/pedidos
    public function index()
    {
        // Protegido por Sanctum, então só admin vê
    $pedidos = Order::whereNull('deleted_at') 
                        ->orderBy('created_at', 'desc')
                        ->get();
        return response()->json($pedidos);
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

    public function resetOrders()
    {
        // Opcional: Usar transação para garantir que todos sejam deletados ou nenhum
        DB::beginTransaction(); 
        try {
            // Pega todos os pedidos que NÃO estão soft-deleted
            $pedidosParaDeletar = Order::whereNull('deleted_at')->get(); 

            // Itera sobre cada pedido e chama o método delete()
            // Como o Model usa SoftDeletes, isso apenas preencherá 'deleted_at'
            foreach ($pedidosParaDeletar as $pedido) {
                $pedido->delete(); 
            }

            DB::commit(); // Confirma a transação

            // (Opcional: Disparar evento WebSocket)
            // broadcast(new PedidosResetados())->toOthers();

            return response()->json(['message' => 'Todos os pedidos foram marcados como excluídos (soft delete).'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Desfaz a transação em caso de erro
            return response()->json(['message' => 'Erro ao resetar pedidos.', 'error' => $e->getMessage()], 500);
        }
    }

    // PATCH /api/pedidos/{id}
    public function update(Request $request, Order $order)
    {
        // Protegido por Sanctum. $order é injetado (Route-Model Binding)
        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $order->update($data);
broadcast(new OrderStatusUpdated($order->id, $order->status, $order->uuid))->toOthers();        return response()->json($order);
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