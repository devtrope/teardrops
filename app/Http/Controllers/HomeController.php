<?php

namespace App\Http\Controllers;

class HomeController
{
    public function getIndex()
    {
        return view('base.html.twig', [
            'title' => 'Home',
            'version' => '0.0.2',
            'features' => [
                ['title' => 'Routing', 'desc' => 'Map HTTP methods to controller methods automatically.'],
                ['title' => 'Views', 'desc' => 'Twig-based rendering with clean templating logic.'],
                ['title' => 'Controllers', 'desc' => 'Convention-over-configuration HTTP binding.'],
            ]
        ]);
    }
}
