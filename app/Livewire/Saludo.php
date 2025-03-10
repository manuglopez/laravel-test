<?php

namespace App\Livewire;

use Livewire\Component;

class Saludo extends Component
{
    public $nombre = '';
    public $mensaje = 'Escribe tu nombre...';

    public function updatedNombre()
    {
        if (strtolower($this->nombre) === 'mikel') {
            $this->mensaje = 'Hola Boss';
        } elseif (!empty($this->nombre)) {
            $this->mensaje = 'Hola ' . ucfirst($this->nombre);
        } else {
            $this->mensaje = 'Escribe tu nombre...';
        }
    }

    public function render()
    {
        return view('livewire.saludo');
    }
}
