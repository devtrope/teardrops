<?php

namespace App\Http\Controller;

use Ludens\Http\Response;
use Ludens\Framework\Controller\AbstractController;

class HomeController extends AbstractController
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
