<?php

namespace App\Http\Controller;

use App\Http\Model\Product;
use Ludens\Database\ModelManager;
use Ludens\Http\Response;
use Ludens\Http\Request;

class ProductController extends BaseController
{
    private ModelManager $modelManager;

    public function __construct(ModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
        return parent::__construct($modelManager);
    }

    public function index(Request $request): Response
    {
        $products = $this->modelManager->get(Product::class)::query();

        if ($request->limit) {
            $products->limit($request->limit);
        }

        if ($request->category) {
            $products->where('category_id', $request->category);
        }

        if ($request->order) {
            $suffix = (int) $request->order === 1 ? 'ASC' : 'DESC';
            $products->orderBy('price', $suffix);
        }

        if ($request->offset) {
            $products->offset($request->offset);
        }

        $products = $products->get();
        return $this->render('product/index', data: ['products' => $products]);
    }

    public function display(string $id): Response
    {
        $product = $this->modelManager->get(Product::class)->find($id);
        return $this->render('product/show', ['product' => $product]);
    }
}
