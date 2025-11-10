<?php

namespace App\Http\Controller;

use App\Http\Model\Category;
use App\Http\Model\Product;
use Ludens\Database\ModelManager;
use Ludens\Http\Response;
use Ludens\Framework\Controller\AbstractController;

class ShopController extends AbstractController
{
    public function index(ModelManager $modelManager): Response
    {
        $products = $modelManager->get(Product::class)->all();
        $categories = $modelManager->get(Category::class)->all();
        return $this->render('shop/index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
