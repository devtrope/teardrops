<?php

namespace App\Http\Controller;

use App\Http\Model\Cart;
use Ludens\Database\ModelManager;
use Ludens\Framework\Controller\AbstractController;
use Ludens\Http\Response;

class CartController extends AbstractController
{
    public function index(ModelManager $modelManager): Response
    {
        $cart = $modelManager->get(Cart::class)->all();
        return $this->render('cart/index', ['cart' => $cart]);
    }
}
