<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductAddController extends Controller
{
    public function addProduct(): View
    {
        $allCategories = Category::select("id", "name")->get();

        return view("product-add", [
            "categories" => $allCategories
        ]);
    }

    public function addProductInsert(Request $req): RedirectResponse
    {
        $productName = $req['product_name'];
        $productDesc = $req['product_desc'];
        $productCost = str_replace(",", ".", $req['product_cost']);
        $productCost = doubleval($productCost);
        $productCategoryId = $req['product_category_id'] ?? null;

        $validation = (
            (strlen($productName) <= 255 && strlen($productName) > 0) &&
            (strlen($productDesc) <= 255 && strlen($productDesc) > 0) &&
            ($productCost >= 0)
        );

        if ($validation)
        {
            $newProduct = new Product();
            $newProduct['name'] = $productName;
            $newProduct['desc'] = $productDesc;
            $newProduct['cost'] = $productCost;
            $newProduct['category_id'] = $productCategoryId;
            $insertResult = $newProduct->save();
        }
        else
        {
            $insertResult = false;
        }

        if ($insertResult)
        {
            $addProductResultMsg = "New product was added successfully.";
            $addProductResult = "success";
        }
        else
        {
            $addProductResultMsg = "New product could not be added (length of product name / description cannot be 0 and higher than 255 characters).";
            $addProductResult = "danger";
        }

        return redirect(route("products"))->with([
            "product_deletion_msg" => $addProductResultMsg,
            "product_deletion_result" => $addProductResult
        ]);
    }
}
