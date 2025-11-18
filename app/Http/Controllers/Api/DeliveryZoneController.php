<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    /**
     * Lista todas as zonas (para o OrderForm)
     */
    public function index()
    {
        // Agrupamos por cidade para facilitar o frontend
        $zones = DeliveryZone::orderBy('cidade')->orderBy('bairro')->get();
        
        // Formata os dados da mesma forma que o frontend esperava
        $grouped = $zones->groupBy('cidade')->map(function ($items, $cidade) {
            return $items->map(function ($item) {
                return [
                    'nome' => $item->bairro,
                    'taxa' => (float) $item->taxa, // Garante que é um número
                    'id' => $item->id // Envia o ID para o Admin
                ];
            });
        });

        return response()->json($grouped);
    }

    /**
     * Salva uma nova zona (para o Admin)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cidade' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'taxa' => 'required|numeric|min:0',
        ]);

        $zone = DeliveryZone::create($data);

        return response()->json($zone, 201);
    }
    
    /**
     * Atualiza uma zona (para o Admin)
     */
    public function update(Request $request, DeliveryZone $deliveryZone)
    {
         $data = $request->validate([
            'cidade' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'taxa' => 'required|numeric|min:0',
        ]);

        $deliveryZone->update($data);

        return response()->json($deliveryZone);
    }

    /**
     * Deleta uma zona (para o Admin)
     */
    public function destroy(DeliveryZone $deliveryZone)
    {
        $deliveryZone->delete();
        return response()->json(null, 204);
    }
}