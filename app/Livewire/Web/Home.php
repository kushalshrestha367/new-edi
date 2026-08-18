<?php

namespace App\Livewire\Web;

use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;


class Home extends Component
{
    public function render()
    {
        return view('web.welcome')
            ->layout('web.layouts.app', [
                'seoModel' => new SEOData(
                    title: 'EDI Homes — Home',
                ),
            ]);
    }
}
