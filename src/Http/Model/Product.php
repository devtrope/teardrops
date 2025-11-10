<?php

namespace App\Http\Model;

use Ludens\Database\Model;

class Product extends Model
{
    public array $hasMany = [
        'details' => [
            'model' => ProductDetail::class,
            'foreign_key' => 'product_id'
        ],
    ];
}