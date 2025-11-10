<?php

namespace App\Http\Model;

use Ludens\Database\Model;

class Cart extends Model
{
    public array $belongsTo = [
        'product' => [
            'model' => Product::class,
            'foreign_key' => 'product_id'
        ],
    ];
}