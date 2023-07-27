<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories(): \Illuminate\Http\JsonResponse
    {
        return Response()->json(Category::select("name", "slug")->get());
    }
}
