<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; // <-- 1. ADICIONE ESTE IMPORT


Broadcast::channel('pratos', function () {
    return true;
});
// --- FIM DA CORREÇÃO ---


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // ... (este está correto)
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin-orders', function (User $user) {
    // Se um usuário estiver autenticado (via token do Sanctum),
    // a variável $user não será nula.
    // Retornar o $user (ou true) permite que ele ouça o canal.
    return $user;

    // Para mais segurança no futuro, se você tiver um campo 'isAdmin' no User:
    // return $user && $user->isAdmin;
});