<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * Returns all categories for view.
     * @return View
     */
    public function getCategoriesForView(): View
    {
        $categories = Category::select("id", "name", "slug")->get();
        return view('categories', ["categories" => $categories]);
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

    /**
     * Returns view for category editing.
     * @param int|string $identifier
     * @return View
     */
    public function editCategory(int|string $identifier): View
    {
        $catToEdit = (is_numeric($identifier)) ? Category::select("id", "name", "slug")->find(id:$identifier) : Category::select("id", "name", "slug")->where("slug", "=", $identifier)->first();

        if (isset($catToEdit))
        {
            return view('edit-category', ["category" => $catToEdit]);
        }
        else
        {
            return view('categories');
        }
    }

    /**
     * Delete category by $identifier from Request with all products which it contains.
     * @param Request $req
     * @return RedirectResponse
     */
    public function deleteCategory(Request $req): RedirectResponse
    {
        if ($req->isMethod("delete") && isset($req['category_id']))
        {
            $identifier = $req['category_id'];
            $catToDelete = Category::select("id", "name", "slug")->find(id: $identifier);
            $result = (isset($catToDelete)) ? $catToDelete->delete() : NULL;
            if ($result)
            {
                return redirect()->route('categories')
                    ->with("category_deletion_msg", "Category with id '#$catToDelete->id', name '$catToDelete->name' and slug '$catToDelete->slug' was deleted successfully.")
                    ->with("category_deletion_result", "success");
            }
            return redirect()->route('categories')
                ->with("category_deletion_msg", "Category with id '#$identifier' could not be deleted properly.")
                ->with("category_deletion_result", "danger");
        }
        return redirect()->route('categories');
    }
}
