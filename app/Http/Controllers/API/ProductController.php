<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProducts(): \Illuminate\Http\JsonResponse
    {
        return Response()->json(Product::select("name", "desc", "cost", "category_id")->get());
    }
}
