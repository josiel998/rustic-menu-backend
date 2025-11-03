<?php

namespace App\Events;

use App\Models\Order; // <-- Importa o modelo Order
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class PedidoCriado implements ShouldBroadcast // <-- Implementa ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    // O pedido completo que será enviado no evento
    public Order $pedido;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $pedido) // <-- Recebe o objeto Order
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Envia para o mesmo canal privado que o Orders.tsx já ouve
        return [
           new PrivateChannel('admin-orders'), 
        ];
    }
    
    // --- INÍCIO DA CORREÇÃO ---
    /**
     * O nome do evento que o frontend vai ouvir.
     */
    public function broadcastAs(): string
    {
        return 'PedidoCriado'; // Isso corresponde ao .listen('.PedidoCriado', ...)
    }
    // --- FIM DA CORREÇÃO ---
    
    /**
     * Os dados que serão enviados.
     * (Enviamos o pedido completo)
     */
    public function broadcastWith(): array
    {
        return [
            'pedido' => $this->pedido
        ];
    }
}