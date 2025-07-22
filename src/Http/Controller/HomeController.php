<?php

namespace Teardrops\Teardrops\Http\Controller;

class HomeController extends AppController
{
    public function getIndex(): void
    {
        $this->set('name', 'Teardrops');
        $this->render('home.html.twig');
    }
}
