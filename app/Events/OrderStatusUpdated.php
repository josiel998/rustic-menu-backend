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

    /**
     * Create a new event instance.
     */
    public function __construct(int $id, string $status) // <<< MUDANÇA
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Envia para o canal público do pedido e o canal privado do Admin
        return [
            new Channel('order.'.$this->id),
           new PrivateChannel('admin-orders'),
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