<?php

namespace Teardrops\Teardrops\Http\Controller;

use Ludens\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return Response::render('home');
    }
}
