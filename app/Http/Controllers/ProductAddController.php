<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductAddController extends Controller
{
    public function addProduct(): View
    {
        return view("product-add");
    }

    public function addProductInsert(Request $req): RedirectResponse
    {
        $addProductResultMsg = "";
        $addProductResult = "success|danger";

        return redirect(route("products"))->with([
            "product_deletion_msg" => $addProductResultMsg,
            "product_deletion_result" => $addProductResult
        ]);
    }
}
