<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryAddController extends Controller
{
    public function addCategory(): View
    {
        return view("category-add");
    }

    public function addCategoryInsert(Request $req): RedirectResponse
    {
        $addCategoryResultMsg = "";
        $addCategoryResult = "success|danger";

        return redirect(route("categories"))->with([
            "category_deletion_msg" => $addCategoryResultMsg,
            "category_deletion_result" => $addCategoryResult
        ]);
    }
}
