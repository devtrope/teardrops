<?php

namespace App\Http\Controller;

use App\Http\Model\Cart;
use Ludens\Database\ModelManager;
use Ludens\Framework\Controller\AbstractController;
use Ludens\Http\Request;
use Ludens\Http\Response;

class CartController extends AbstractController
{
    public function index(ModelManager $modelManager): Response
    {
        $cart = $modelManager->get(Cart::class)->all();
        return $this->render('cart/index', ['cart' => $cart]);
    }

    public function add(ModelManager $modelManager, Request $request): Response
    {
        $currentCart = $modelManager->get(Cart::class)::query()->where('product_id', $request->product)->first();

        if ($currentCart) {
            $cart = $modelManager->get(Cart::class)->find($currentCart['id']);
            $cart->product_id = $request->product;
            $cart->quantity = $cart->quantity + 1;
            $cart->update();

            return $this->json(['success' => true, 'message' => 'Product added to cart.']);
        }

        $cart = new Cart();
        $cart->product_id = $request->product;
        $cart->quantity = 1;
        $cart->save();

        return $this->json(['success' => true, 'message' => 'Product added to cart.']);
    }
}
