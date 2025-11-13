<?php

namespace App\Http\Controller;

use Ludens\Http\Response;

class HomeController extends BaseController
{
    public function index(): Response
    {
        return $this->render('home/index');
    }

    public function about(): Response
    {
        return $this->render('about/index');
    }
}
