<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Returns all categories.
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        return Response()->json(Category::select("id", "name", "slug")->get());
    }

    /**
     * Returns category by $identifier param.
     * @param int|string $identifier
     * @return JsonResponse
     */
    public function getCategoryByIdOrSlug(int|string $identifier): JsonResponse
    {
        if (is_numeric($identifier))
        {
            return Response()->json(Category::select("id", "name", "slug")->find(id:$identifier));
        }
        else
        {
            return Response()->json(Category::select("id", "name", "slug")->where("slug", "=", $identifier)->first());
        }
    }
}
