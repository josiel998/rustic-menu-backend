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

Broadcast::channel('admin-orders', function ($user) {
    // ... (este está correto)
    return true;
});