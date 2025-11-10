<?php

namespace App\Http\Controller;

use Ludens\Http\Response;
use App\Http\Model\Product;
use Ludens\Database\ModelManager;
use Ludens\Framework\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(ModelManager $modelManager): Response
    {
        $products = $modelManager->get(Product::class)::query()->limit(4)->get();
        return $this->render('home/index', ['products' => $products]);
    }

    public function about(): Response
    {
        return $this->render('about/index');
    }
}
