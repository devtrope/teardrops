<?php

namespace App\Http\Controller;

use Ludens\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return Response::view('home');
    }
}
