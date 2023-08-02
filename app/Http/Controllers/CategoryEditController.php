<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryEditController extends Controller
{
    /**
     * Category editing - returns view with required values if specified category exists, redirects to 'categories' otherwise.
     * @param int|string $category_id
     * @return View|RedirectResponse
     */
    public function editCategory(int|string $category_id): View|RedirectResponse
    {
        $categoryToEdit = Category::select("id", "name", "slug")->find(id:$category_id);

        if(isset($categoryToEdit['id']))
        {
            return view("category-edit", [
                "category_id" => $categoryToEdit['id'],
                "category_name" => $categoryToEdit['name'],
                "category_slug" => $categoryToEdit['slug']
            ]);
        }
        else
        {
            return redirect(route("categories"))->with([
                "category_deletion_msg" => "Specified category does not exist or cannot be edited.",
                "category_deletion_result" => "danger"
            ]);
        }
    }

    /**
     * Category editing - form save function.
     * @param Request $req
     * @return View
     */
    public function editCategorySave(Request $req): View
    {
        $catId = $req['category_id'];
        $catName = $req['category_name'];

        $validation = (strlen($catName) <= 100);

        if ($validation)
        {
            $catToUpdate = Category::select("id", "name", "slug")->find(id:$catId);

            $catSlug = Str::slug($catName);
            $slugCount = Category::where("slug", "like", $catSlug . "%")->where("slug", "!=", $catToUpdate['slug'])->get()->count();
            $slugId = ($slugCount ?? 0) + 1;
            $catSlug = $catSlug . "-" . $slugId;

            $updateResult = ($catToUpdate->update([
                "name" => $catName,
                "slug" => $catSlug
            ]));
        }
        else
        {
            $catSlug = $req['category_slug'];
            $updateResult = false;
        }

        if ($updateResult)
        {
            $categoryEditResult = [
                "category_edit_result" => "success",
                "category_edit_result_msg" => "Category was updated successfully."
            ];
        }
        else
        {
            $categoryEditResult = [
                "category_edit_result" => "danger",
                "category_edit_result_msg" => (!$validation) ? "Category could not be updated, length of category name is " . strlen($catName) . ", maximum is 100." : "Category could not be updated."
            ];
        }

        return view("category-edit", [
            "category_id" => $catId,
            "category_name" => $catName,
            "category_slug" => $catSlug,
            "category_edit_result" => $categoryEditResult['category_edit_result'],
            "category_edit_result_msg" => $categoryEditResult['category_edit_result_msg']
        ]);
    }
}
