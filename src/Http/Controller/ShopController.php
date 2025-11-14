<?php

namespace App\Http\Controller;

use App\Http\Model\Category;
use Ludens\Database\ModelManager;
use Ludens\Http\Response;

class ShopController extends BaseController
{
    public function index(ModelManager $modelManager): Response
    {
        $categories = $modelManager->get(Category::class)->all();
        return $this->render('shop/index', [
            'categories' => $categories
        ]);
    }
}
