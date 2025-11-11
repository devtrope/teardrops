<?php

namespace App\Http\Controller;

use App\Http\Model\Cart;
use App\Http\Model\Product;
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
        $product = $modelManager->get(Product::class)->find($request->product);

        if ($currentCart) {
            if ($currentCart['quantity'] === 5) {
                return $this->json(['success' => false, 'title' => 'Maximum quantity', 'message' => 'You can\'t order more than 5 times the same item.']);
            }

            $cart = $modelManager->get(Cart::class)->find($currentCart['id']);
            $cart->product_id = $request->product;
            $cart->quantity = $cart->quantity + 1;
            $cart->update();

            return $this->json(['success' => true, 'title' => 'Added to cart', 'message' => $product->name . ' has been added to your cart.']);
        }

        $cart = new Cart();
        $cart->product_id = $request->product;
        $cart->quantity = 1;
        $cart->save();

        return $this->json(['success' => true, 'title' => 'Added to cart', 'message' => $product->name . ' has been added to your cart.']);
    }

    public function update(ModelManager $modelManager, Request $request): Response
    {
        $cart = $modelManager->get(Cart::class)->find($request->id);
        $cart->quantity = $request->quantity;
        $cart->update();
        
        return $this->json(['success' => true]);
    }
}
