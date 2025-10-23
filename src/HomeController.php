<?php

namespace Teardrops\Teardrops;

use Ludens\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return Response::render('home');
    }
}
