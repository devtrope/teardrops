<?php

namespace App\Http\Controller;

use Ludens\Database\ModelManager;
use Ludens\Framework\Controller\AbstractController;

class BaseController extends AbstractController
{
    public function __construct(ModelManager $modelManager)
    {
        $cart = $modelManager->get(\App\Http\Model\Cart::class)->all();
        $quantity = 0;

        foreach ($cart as $item) {
            $quantity += $item->quantity;
        }

        $this->share('cartItemsCount', $quantity);
    }
}
