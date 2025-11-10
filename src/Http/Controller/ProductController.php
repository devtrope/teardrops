<?php

namespace App\Http\Controller;

use App\Http\Model\Product;
use Ludens\Database\ModelManager;
use Ludens\Http\Response;
use Ludens\Framework\Controller\AbstractController;
use Ludens\Http\Request;

class ProductController extends AbstractController
{
    public function index(ModelManager $modelManager, Request $request): Response
    {
        $products = $modelManager->get(Product::class)::query();

        if ($request->limit) {
            $products->limit($request->limit);
        }

        if ($request->category) {
            $products->where('category_id', $request->category);
        }

        if ($request->order) {
            $suffix = (int) $request->order === 1 ? 'ASC' : 'DESC';
            $products->order('price', $suffix);
        }

        if ($request->offset) {
            $products->offset($request->offset);
        }

        $products = $products->get();
        return $this->render('product/index', data: ['products' => $products]);
    }

    public function display(ModelManager $modelManager, string $id): Response
    {
        $product = $modelManager->get(Product::class)->find($id);
        return $this->render('product/show', ['product' => $product]);
    }
}
