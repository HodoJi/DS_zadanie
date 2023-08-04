<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryAddController extends Controller
{
    /**
     * Category add - returns view with form for adding new category.
     * @return View
     */
    public function addCategory(): View
    {
        return view("category-add");
    }

    /**
     * Category add - form insert function.
     * @param Request $req
     * @return RedirectResponse
     */
    public function addCategoryInsert(Request $req): RedirectResponse
    {
        $categoryName = $req['category_name'];

        $validation = (strlen($categoryName) > 0 && strlen($categoryName) <= 100);

        if ($validation)
        {
            $categorySlug = Str::slug($categoryName);

            $i = 1;
            do
            {
                $categoryNewSlug = $categorySlug . "-" . $i;
                $i++;

                $count = Category::where("slug", "=", $categoryNewSlug)->get()->count();
            }
            while( $count != 0 );

            $newCategory = new Category();
            $newCategory['name'] = $categoryName;
            $newCategory['slug'] = $categoryNewSlug;
            $insertResult = $newCategory->save();
        }
        else
        {
            $insertResult = false;
        }

        if ($insertResult)
        {
            $addCategoryResultMsg = "New category was created successfully.";
            $addCategoryResult = "success";
        }
        else
        {
            $addCategoryResultMsg = "New category could not be created (length of category name cannot be 0 and higher than 100 characters, current length: " . strlen($categoryName) . ").";
            $addCategoryResult = "danger";
        }

        return redirect(route("categories"))->with([
            "category_deletion_msg" => $addCategoryResultMsg,
            "category_deletion_result" => $addCategoryResult
        ]);
    }
}
