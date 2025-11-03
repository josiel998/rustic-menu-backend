<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log; // <-- ADICIONE ESTE IMPORT
use Illuminate\Support\Facades\Auth;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
public function boot(): void
    {
        // --- INÍCIO DA CORREÇÃO ---
        // Remova 'api' da lista de middlewares.
        // O 'auth:sanctum' sozinho é o correto para validar o Bearer Token.
    //    Broadcast::routes([]);
        // --- FIM DA CORREÇÃO ---

      

        require base_path('routes/channels.php');
    }
}