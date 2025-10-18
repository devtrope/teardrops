<?php

namespace Teardrops\Teardrops;

class HomeController
{
    public function index(): Response
    {
        return Response::render('home');
    }
}
