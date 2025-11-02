<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; // <-- 1. ADICIONE ESTE IMPORT


 Broadcast::channel('pratos', function ($user, $id) {
   
   dd($user);
    return true;
});


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    
    dd(($user ) ."2");
    return (int) $user->id === (int) $id;
});


// --- 2. SUBSTITUA SEU CANAL 'admin-orders' POR ESTE ---
Broadcast::channel('admin-orders', function ($user) {
    // Se o código chegar aqui, o $user já foi autenticado
    // pelo middleware. Só precisamos de verificar se ele não é nulo.
// dd(($user ) .'3');

    return true;
});