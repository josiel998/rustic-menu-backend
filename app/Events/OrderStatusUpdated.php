<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;// <<< MUDANÇA
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast // <<< MUDANÇA
{
    use Dispatchable, SerializesModels;

    public int $id;
    public string $status;
    public string $uuid;

    /**
     * Create a new event instance.
     */
    public function __construct(int $id, string $status, string $uuid) // <<< MUDANÇA
    {
        $this->id = $id;
        $this->status = $status;
        $this->uuid = $uuid;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Envia para o canal público do pedido e o canal privado do Admin
    return [
            new Channel('order.uuid.'.$this->uuid), 
           new PrivateChannel('admin-orders'), // Canal privado para Admin (Orders.tsx)
        ];
    }
    
    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array // <<< MUDANÇA
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
        ];
    }
}