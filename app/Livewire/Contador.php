<?php

namespace App\Livewire;

use Livewire\Component;

class Contador extends Component
{
    public $contador = 0;

    public function incrementar()
    {
        if ($this->contador < 10) {
            $this->contador++;
        }
    }

    public function decrementar()
    {
        $this->contador--;
    }
    public function render()
    {
        return view('livewire.contador');
    }
}
