<?php

namespace Teardrops\Teardrops\Http\Controller;

use Teardrops\Teardrops\Http\Controller;

class HomeController extends Controller
{
    public function getIndex(): void
    {
        $this->render('home.html.twig');
    }
}
