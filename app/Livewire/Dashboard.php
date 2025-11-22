<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lectura;

class Dashboard extends Component
{
    public $lecturas = [];

    protected $listeners = ['actualizarDashboard' => 'agregarLectura'];

    public function mount()
    {
        $this->lecturas = Lectura::latest()->take(10)->get();
    }

    public function agregarLectura($lectura)
    {
        $this->lecturas->prepend($lectura);
        $this->lecturas = $this->lecturas->take(10);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
