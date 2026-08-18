<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ContactMap extends Component
{
    public $latitude = 26.464791;
    public $longitude = 87.280825;

    protected $listeners = ['updateMapCoordinates'];

    public function updateMapCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function render()
    {
        return view('livewire.contact-map');
    }
}
