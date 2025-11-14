<?php

namespace App\Http\Controller;

use App\Http\Model\Cart;
use App\Http\Model\Product;
use Ludens\Database\ModelManager;
use Ludens\Http\Request;
use Ludens\Http\Response;

class CartController extends BaseController
{
    private ModelManager $modelManager;

    public function __construct(ModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
        return parent::__construct($modelManager);
    }

    public function index(): Response
    {
        $cart = $this->modelManager->get(Cart::class)->all();
        return $this->render('cart/index', ['cart' => $cart]);
    }

    public function add(Request $request): Response
    {
        $currentCart = $this->modelManager->get(Cart::class)::query()->where('product_id', $request->product)->first();
        $product = $this->modelManager->get(Product::class)->find($request->product);

        if ($currentCart) {
            if ($currentCart['quantity'] === 5) {
                return $this->json(['success' => false, 'title' => 'Maximum quantity', 'message' => 'You can\'t order more than 5 times the same item.']);
            }

            $cart = $this->modelManager->get(Cart::class)->find($currentCart['id']);
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

    public function update(Request $request): Response
    {
        $cart = $this->modelManager->get(Cart::class)->find($request->id);
        $cart->quantity = $request->quantity;
        $cart->update();
        
        return $this->json(['success' => true]);
    }

    public function delete(Request $request): Response
    {
        $cart = $this->modelManager->get(Cart::class)->find($request->id);
        $cart->delete();
        return $this->json(['success' => true]);
    }
}
