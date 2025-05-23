<?php

namespace App\Http\Controllers;

use Composer\InstalledVersions;

class HomeController
{
    public function getIndex()
    {
        return view('base.html.twig', [
            'title' => 'Home',
            'version' => InstalledVersions::getPrettyVersion('teardrops/framework'),
            'features' => [
                ['title' => 'Routing', 'desc' => 'Map HTTP methods to controller methods automatically.'],
                ['title' => 'Views', 'desc' => 'Twig-based rendering with clean templating logic.'],
                ['title' => 'Controllers', 'desc' => 'Convention-over-configuration HTTP binding.'],
            ]
        ]);
    }
}
