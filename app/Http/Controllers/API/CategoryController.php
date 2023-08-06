<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
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
     * Delete category by $category_id from Request with all products which it contains.
     * @param Request $req
     * @return RedirectResponse
     */
    public function deleteCategory(Request $req): RedirectResponse
    {
        if ($req->isMethod("delete") && isset($req['category_id']))
        {
            $doDeleteCategoryProducts = (isset($req['remove_category_products']) && $req['remove_category_products']);

            $category_id = $req['category_id'];
            $catToDelete = Category::select("id", "name", "slug")->find(id: $category_id);

            $catDeletionResult = (isset($catToDelete)) ? $catToDelete->delete() : null;

            $allProductsWereRemovedSuccessfully = true;
            if ($doDeleteCategoryProducts && isset($catDeletionResult))
            {
                $productsInCategory = $catToDelete->products()->get();

                foreach($productsInCategory as $productInCategory)
                {
                    $r = $productInCategory->delete();
                    if (!$r)
                    {
                        $allProductsWereRemovedSuccessfully = false;
                    }
                }
            }
            elseif(isset($catDeletionResult)) //: only if category was removed successfully.
            {
                Product::where("category_id", "=", $category_id)->update(["category_id" => null]); // update 'category_id' of 'products' in DB of that of removed category to null as these products should no longer be in some category.
            }

            if ($catDeletionResult)
            {
                return redirect()->route('categories')->with([
                        "category_deletion_msg" => "Category with id '#$catToDelete->id', name '$catToDelete->name' and slug '$catToDelete->slug' was deleted successfully.",
                        "category_products_removal_msg_show" => $doDeleteCategoryProducts,
                        "category_products_removal_msg" => ($allProductsWereRemovedSuccessfully) ? "All products in category were also removed successfully." : "Some or all products in category could not be removed.",
                        "category_deletion_result" => "success"
                    ]);
            }
            return redirect()->route('categories')->with([
                    "category_deletion_msg" => "Category with id '#$category_id' could not be deleted properly, no products were removed.",
                    "category_deletion_result" => "danger"
                ]);
        }
        return redirect()->route('categories');
    }

    // <==========================================================================================================> //
    // <==============================================[↓ API PART ↓]==============================================> //
    // <==========================================================================================================> //

    /**
     * API: Returns all categories.
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        return Response()->json(Category::select("id", "name", "slug")->get());
    }

    /**
     * API: Returns category by $identifier param.
     * @param int|string $category_identifier
     * @return JsonResponse
     */
    public function getCategoryByIdOrSlug(int|string $category_identifier): JsonResponse
    {
        if (is_numeric($category_identifier))
        {
            return Response()->json(Category::select("id", "name", "slug")->find(id:$category_identifier));
        }
        else
        {
            return Response()->json(Category::select("id", "name", "slug")->where("slug", "=", $category_identifier)->first());
        }
    }
}
