<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Importante!
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast // Implemente ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $status;
    public int $id;

    /**
     * Create a new event instance.
     */
    public function __construct(public Order $order)
    {
        // Puxamos os dados que queremos enviar para o frontend
        $this->status = $order->status;
        $this->id = $order->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Este é o "nome do canal" que o frontend vai ouvir.
        // Estamos criando um canal público para cada pedido, usando o UUID.
        return [
            new Channel('order.'.$this->order->uuid),
        ];
    }
}