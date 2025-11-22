<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('huerta.datos', function ($user) {
    return true; // Luego le agregamos autenticación
});