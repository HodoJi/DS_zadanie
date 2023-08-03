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
            return $this->editCategoryNotSpecified();
        }
    }

    /**
     * Category editing - form save function.
     * @param Request $req
     * @return View
     */
    public function editCategorySave(Request $req): View
    {
        $form_categoryId = $req['category_id']; //: cannot be changed in form.
        $form_categoryName = $req['category_name']; //: can be changed in form.

        $categoryToUpdate = Category::select("id", "name", "slug")->find(id:$form_categoryId);
        $currentSlug = $categoryToUpdate['slug'];

        $validation = (strlen($form_categoryName) <= 100) && ($categoryToUpdate['name'] != $form_categoryName);

        if ($validation)
        {
            $posOfNumInSlug = strrpos($currentSlug, "-");
            $currentSlugWithoutLastDashAndNumber = substr($currentSlug, 0, $posOfNumInSlug);

            $newSlugWithoutNumber = Str::slug($form_categoryName);

            if ($currentSlugWithoutLastDashAndNumber != $newSlugWithoutNumber)
            {
                $i = 1;
                do
                {
                    $categoryNewSlug = $newSlugWithoutNumber . "-" . $i;
                    $i++;

                    $count = Category::where("slug", "=", $categoryNewSlug)->get()->count();
                }
                while( $count != 0 );
            }
            else
            {
                $categoryNewSlug = $currentSlug; //: do not change slug if string generated from current category name is equal to current slug in DB without number.
            }

            $updateResult = ($categoryToUpdate->update([
                "name" => $form_categoryName,
                "slug" => $categoryNewSlug
            ]));
        }
        else
        {
            $categoryNewSlug = $currentSlug;
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
                "category_edit_result_msg" => (!$validation) ? "Category could not be updated, category name is too long (current length: " . strlen($form_categoryName) . ", max 100 characters) or is unchanged." : "Category could not be updated."
            ];
        }

        return view("category-edit", [
            "category_id" => $form_categoryId,
            "category_name" => $form_categoryName,
            "category_slug" => $categoryNewSlug,
            "category_edit_result" => $categoryEditResult['category_edit_result'],
            "category_edit_result_msg" => $categoryEditResult['category_edit_result_msg']
        ]);
    }

    /**
     * Category editing - Not specified category to edit.
     * @return RedirectResponse
     */
    public function editCategoryNotSpecified(): RedirectResponse
    {
        return redirect(route("categories"))->with([
            "category_deletion_msg" => "Specified category does not exist or cannot be edited.",
            "category_deletion_result" => "danger"
        ]);
    }
}
