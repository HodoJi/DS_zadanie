<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Returns all products.
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        return Response()->json(Product::select("id", "name", "desc", "cost", "category_id")->get());
    }

    /**
     * Returns product by $id param.
     * @param int $id
     * @return JsonResponse
     */
    public function getProductById(int $id): JsonResponse
    {
        return Response()->json(Product::select("id", "name", "desc", "cost", "category_id")->find($id));
    }
}
