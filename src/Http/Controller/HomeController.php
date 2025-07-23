<?php

namespace Teardrops\Teardrops\Http\Controller;

use Teardrops\Teardrops\Http\Model\Song;

class HomeController extends AppController
{
    public function getIndex(): void
    {
        //$this->set('songs', Song::all());
        $this->render('home.html.twig');
    }
}
