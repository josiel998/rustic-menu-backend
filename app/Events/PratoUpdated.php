<?php

namespace App\Events;

use App\Models\Prato; // Importa o model Prato
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PratoUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Prato $prato;

    public function __construct(Prato $prato)
    {
        $this->prato = $prato;
    }

    public function broadcastOn(): array
    {
        // Envia para o mesmo canal 'pratos' que o PratoCriado usa
        return [
            new Channel('pratos'),
        ];
    }

    public function broadcastAs(): string
    {
        // O frontend vai ouvir por '.PratoUpdated'
        return 'PratoUpdated';
    }
}