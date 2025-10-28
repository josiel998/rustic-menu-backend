<?php

namespace App\Events;

use App\Models\Prato; // Importa o model Prato
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Importante!
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PratoCriado implements ShouldBroadcast // Implementa o WebSocket
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // Torna o prato público para que o evento o envie
    public Prato $prato;

    /**
     * Create a new event instance.
     */
    public function __construct(Prato $prato)
    {
        $this->prato = $prato;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Define o canal público 'pratos'
        // O frontend (Index.tsx) vai ouvir este canal
        return [
            new Channel('pratos'),
        ];
    }

    /**
     * O nome do evento que o frontend vai ouvir.
     * (Por padrão, seria 'PratoCriado', mas 'prato.criado' é uma boa convenção)
     *
     * No seu Index.tsx, você deve ouvir por: .listen('.PratoCriado', ...)
     * (O frontend que te passei já ouve por `.PratoCriado`)
     */
    public function broadcastAs(): string
    {
        return 'PratoCriado';
    }
}