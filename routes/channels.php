<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User; // <-- 1. ADICIONE ESTE IMPORT (MUITO IMPORTANTE)

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// --- 2. ADICIONE ESTA FUNÇÃO ---
// Esta é a regra que faltava. Ela autoriza o canal 'admin-orders'
// que o seu Orders.tsx está tentando ouvir.

Broadcast::channel('admin-orders', function (User $user) {
    // Se o $user não for nulo (ou seja, está autenticado via Sanctum),
    // a conexão será permitida.
    return $user != null; 
});