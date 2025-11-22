<?php

namespace App\Events;

use App\Models\Lectura;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevoDatoDesdeESP32 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lectura;

    public function __construct(Lectura $lectura)
    {
        $this->lectura = $lectura;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('huerta.datos');
    }

    public function broadcastAs()
    {
        return 'nuevo-dato';
    }
}
